<?php
namespace Testing\Tests\UI;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Testing\Pages\Index\IndexCommercePage;

class IndexCommerceTest extends TestCase
{
    protected $driver;

    protected function setUp(): void
    {
        // Actualiza la URL para Selenium 4
        $this->driver = RemoteWebDriver::create('http://selenium-hub:4444', DesiredCapabilities::chrome());
    }

    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }

    public function testIndexCommerce(): void
    {
        $indexCommercePage = new IndexCommercePage($this->driver);
        $indexCommercePage->open();
        $indexCommercePage->setUsername('standard_user');
        $indexCommercePage->setPassword('secret_sauce');
        $indexCommercePage->clickLoginButton();
        $successlogin = $indexCommercePage->verifyLoginSuccessfull();
        $this->assertStringContainsString('Logged In Successfully', $successlogin);
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->verifyClickHambugerMenu();
        $this->assertStringContainsString('About', $indexCommercePage->verifyClickHambugerMenu());
        
    }
}