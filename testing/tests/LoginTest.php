<?php
namespace Testing\Tests\UI;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Testing\Pages\LoginPage;

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
        $loginPage = new LoginPage($this->driver);
        $loginPage->open();
        $loginPage->setUsername('student');
        $loginPage->setPassword('Password123');
        $loginPage->clickLoginButton();

        $successMessage = $loginPage->getSuccessMessage();
        $this->assertStringContainsString('Logged In Successfully', $successMessage);
    }

    public function testFailedLoginUser(): void
    {
        $loginPage = new LoginPage($this->driver);
        $loginPage->open();
        $loginPage->setUsername('incorrectUser');
        $loginPage->setPassword('Password123');
        $loginPage->clickLoginButton();

        $failedMessage = $loginPage->getErrorMessageUser();
        $this->assertStringContainsString('Your username is invalid!', $failedMessage);
    }

    public function testFailedLoginPassword(): void
    {
        $loginPage = new LoginPage($this->driver);
        $loginPage->open();
        $loginPage->setUsername('student');
        $loginPage->setPassword('incorrectPassword');
        $loginPage->clickLoginButton();

        $failedMessage = $loginPage->getErrorMessagePassword();
        $this->assertStringContainsString('Your password is invalid!', $failedMessage);
    }
}
?>
