<?php
namespace Testing\Tests\Login;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Testing\Pages\Login\LoginView;
use Testing\Utils\login\LoginUtils;


class Login2Test extends TestCase
{
    protected $driver;
    protected $loginPage;

    protected function setUp(): void
    {
        $this->driver = RemoteWebDriver::create('http://selenium-hub:4444', DesiredCapabilities::chrome());
        $this->loginPage = new LoginView($this->driver);
    }

    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }

    public function testSuccessfulLogin(): void
    {
        LoginUtils::performSuccessfulLogin($this->loginPage);
    }


    public function testFailedLoginUser(): void
    {
        LoginUtils::performFailedLoginUser($this->loginPage);
    
    }

    public function testFailedLoginPassword(): void
    {
        LoginUtils::performFailedLoginPassword($this->loginPage);
    }

    public function testLogOut(): void
    {
        LoginUtils::performLogOut($this->loginPage);
    }

    public function testLoginEmpty(): void
    {
        LoginUtils::performLoginEmpty($this->loginPage);
    }

}
?>
