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
        // Actualiza la URL para Selenium 4
        $this->driver = RemoteWebDriver::create('http://selenium-hub:4444', DesiredCapabilities::chrome());

        // Inicializa la página de login con el driver
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
        $this->loginPage->open();
        $this->loginPage->setUsername('incorrectUser');
        $this->loginPage->setPassword('secret_sauce');
        $this->loginPage->clickLoginButton();

        $failedlogin = $this->loginPage->verifyLoginFailed();
        $this->assertStringContainsString('Username and password do not match any user in this service', $failedlogin);
    }

    public function testFailedLoginPassword(): void
    {
        $this->loginPage->open();
        $this->loginPage->setUsername('standard_user');
        $this->loginPage->setPassword('incorrectPassword');
        $this->loginPage->clickLoginButton();

        $failedlogin = $this->loginPage->verifyLoginFailed();
        $this->assertStringContainsString('Username and password do not match any user in this service', $failedlogin);
    }

    public function testLogOut(): void
    {
        $this->loginPage->open();
        $this->loginPage->setUsername('standard_user');
        $this->loginPage->setPassword('secret_sauce');
        $this->loginPage->clickLoginButton();
        $this->loginPage->clickHamburgerMenu();
        $this->loginPage->clickLogout();
        $logout = $this->loginPage->verifyLogout();
        $this->assertStringContainsString('Accepted usernames are:', $logout);
    }
}
?>
