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
        $this->driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::chrome());
    }

    protected function tearDown(): void
    {
        $this->driver->quit();
    }

    public function testSuccessfulLogin()
    {
        $loginPage = new LoginPage($this->driver);
        $loginPage->open();
        $loginPage->setUsername('student');
        $loginPage->setPassword('Password123');
        $loginPage->clickLoginButton();

        $successMessage = $loginPage->getSuccessMessage();
        $this->assertStringContainsString('Logged In Successfully', $successMessage);
    }
    public function testFailedLogin()
    {
        $loginPage = new LoginPage($this->driver);
        $loginPage->open();
        $loginPage->setUsername('incorrectUser');
        $loginPage->setPassword('Password123');
        $loginPage->clickLoginButton();

        $failedMessage = $loginPage->getErrorMessage();
        $this->assertStringContainsString('Your username is invalid!',  $failedMessage);
    }

}
?>

?>
