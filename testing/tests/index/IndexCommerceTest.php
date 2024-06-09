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
        $this->driver = RemoteWebDriver::create('http://selenium-hub:4444', DesiredCapabilities::chrome());
    }
    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }

    private function login(): IndexCommercePage
    {
        $indexCommercePage = new IndexCommercePage($this->driver);
        $indexCommercePage->open();
        $indexCommercePage->setUsername('standard_user');
        $indexCommercePage->setPassword('secret_sauce');
        $indexCommercePage->clickLoginButton();
        $successlogin = $indexCommercePage->verifyLoginSuccessfull();
        $this->assertStringContainsString('Products', $successlogin);
        
        return $indexCommercePage;
    }
    public function testIndex(): void
    {
        $this->login();
    }

    public function testHamburgerMenu(): void
    {
        $indexCommercePage = $this->login();
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->verifyClickHambugerMenu();
        $indexCommercePage->clickAbout();
        $indexCommercePage->verifyClickAbout();
        $indexCommercePage->backToIndex();
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->clickLogout();
        $indexCommercePage->verifyLogout();
    
    }
}
