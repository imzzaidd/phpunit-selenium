<?php
namespace Testing\Tests\UI;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Testing\Pages\Login\LoginPage2;

class LoginTest extends TestCase
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
    public function testSuccessfulLogin(): void
    {
        $loginPage = new LoginPage2($this->driver);
        $loginPage->open();
        $loginPage->setUsername('standard_user');
        $loginPage->setPassword('secret_sauce');
        $loginPage->clickLoginButton();

        $successlogin = $loginPage->verifyLoginSuccessfull();
        $this->assertStringContainsString('Logged In Successfully', $successlogin);
    }
    public function testFailedLoginUser(): void
    {
        $loginPage = new LoginPage2($this->driver);
        $loginPage->open();
        $loginPage->setUsername('incorrectUser');
        $loginPage->setPassword('secret_sauce');
        $loginPage->clickLoginButton();

        $failedlogin = $loginPage->verifyLoginFailed();
        $this->assertStringContainsString('Username and password do not match any user in this service', $failedlogin);
    }
    public function testFailedLoginPassword(): void
    {
        $loginPage = new LoginPage2($this->driver);
        $loginPage->open();
        $loginPage->setUsername('standard_user');
        $loginPage->setPassword('incorrectPassword');
        $loginPage->clickLoginButton();

        $failedlogin = $loginPage->verifyLoginFailed();
        $this->assertStringContainsString('Username and password do not match any user in this service', $failedlogin);
    }
    public function testLogOut(): void
    {
        $loginPage = new LoginPage2($this->driver);
        $loginPage->open();
        $loginPage->setUsername('standard_user');
        $loginPage->setPassword('secret_sauce');
        $loginPage->clickLoginButton();
        $loginPage->clickHamburgerMenu();
        $loginPage->clickLogout();
    }
}