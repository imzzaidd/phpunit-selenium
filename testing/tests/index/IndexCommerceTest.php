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

    private function testLogin(): IndexCommercePage
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
        $this->testLogin();
    }

    public function testHamburgerMenu(): void
    {
        $indexCommercePage = $this->testLogin();
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->verifyClickHambugerMenu();
    }
    public function testAboutOption(): void
    {
        $indexCommercePage = $this->testLogin();
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->clickAbout();
        $indexCommercePage->verifyClickAbout();
        $indexCommercePage->backToIndex();
}
    public function testLogout(): void
    {
        $indexCommercePage = $this->testLogin();
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->clickLogout();
        $indexCommercePage->verifyLogout();
    }
    public function testCloseHamburgerMenu(): void
    {
        $indexCommercePage = $this->testLogin();
        $indexCommercePage->clickHamburgerMenu();
        $indexCommercePage->clickCloseHamburgerMenu();
        $indexCommercePage->verifyCloseHamburgerMenu();
    }

    public function testItems(): void
    {
        $indexCommercePage = $this->testLogin();
        $indexCommercePage->clickItems();
        $indexCommercePage->verifyItemURL();
        $indexCommercePage->verifyItemView();
    }

}