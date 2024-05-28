<?php
namespace Testing\Pages;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class LoginPage
{
    protected $driver;
    private const URL = 'https://practicetestautomation.com/practice-test-login/';
    private const USERNAME_FIELD = "//input[@id='username']";
    private const PASSWORD_FIELD = "//input[@name='password']";
    private const LOGIN_BUTTON = "//button[contains(.,'Submit')]";
    private const SUCCESS_MESSAGE = "//h1[@class='post-title' and contains(text(), 'Logged In Successfully')]";
    private const ERROR_MESSAGE_USER = "//div[@class='show'][contains(.,'Your username is invalid!')]";
    private const ERROR_MESSAGE_PASSWORD = "//div[@class='show'][contains(.,'Your password is invalid!')]";

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function open(): void
    {
        $this->driver->get(self::URL);
        $this->assertCurrentUrl(self::URL);
        $this->waitForElement(WebDriverBy::xpath(self::USERNAME_FIELD));
    }

    public function setUsername(string $username): void
    {
        $this->fillField(WebDriverBy::xpath(self::USERNAME_FIELD), $username);
    }

    public function setPassword(string $password): void
    {
        $this->fillField(WebDriverBy::xpath(self::PASSWORD_FIELD), $password);
    }

    public function clickLoginButton(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::LOGIN_BUTTON));
    }

    public function getSuccessMessage(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::SUCCESS_MESSAGE));
    }

    public function getErrorMessageUser(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::ERROR_MESSAGE_USER));
    }

    public function getErrorMessagePassword(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::ERROR_MESSAGE_PASSWORD));
    }

    private function assertCurrentUrl(string $expectedUrl): void
    {
        if ($this->driver->getCurrentURL() !== $expectedUrl) {
            throw new \Exception("Failed to open the correct URL: expected $expectedUrl but got " . $this->driver->getCurrentURL());
        }
    }

    private function waitForElement(WebDriverBy $by, int $timeout = 10): void
    {
        $wait = new WebDriverWait($this->driver, $timeout);
        $wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
    }

    private function fillField(WebDriverBy $by, string $value): void
    {
        try {
            $element = $this->driver->findElement($by);
            $element->clear();
            $element->sendKeys($value);
        } catch (\Exception $e) {
            throw new \Exception("Failed to fill field: " . $e->getMessage());
        }
    }

    private function clickElement(WebDriverBy $by): void
    {
        try {
            $this->driver->findElement($by)->click();
        } catch (\Exception $e) {
            throw new \Exception("Failed to click element: " . $e->getMessage());
        }
    }

    private function getElementText(WebDriverBy $by): string
    {
        try {
            $this->waitForElement($by);
            return $this->driver->findElement($by)->getText();
        } catch (\Exception $e) {
            throw new \Exception("Failed to get element text: " . $e->getMessage());
        }
    }
}
?>
