<?php
namespace Testing\Pages\Login;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class LoginPage2
{
    protected $driver;
    private const URL = 'https://www.saucedemo.com';
    private const LOGO = "//div[@class='login_logo'][contains(.,'Swag Labs')]";
    private const USERNAME_FIELD = "//input[contains(@placeholder,'Username')]";
    private const PASSWORD_FIELD = "//input[contains(@placeholder,'Password')]";
    private const LOGIN_BUTTON = "//input[@value='Login']";
    private const SUBTITLE = "//span[@class='title'][contains(.,'Products')]";
    private const ERROR_MESSAGE = "//h3[contains(@data-test,'error')]";
    private const HAMBURGER_MENU = "//button[contains(.,'Open Menu')]]";
    private const LOGOUT_TEXT = "//a[contains(.,'Logout')]";

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }
    public function open(): void
    {
        $this->driver->get(self::URL);
        $this->assertCurrentUrl(self::URL);
        $this->waitForElement(WebDriverBy::xpath(self::LOGO));
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
    public function verifyLoginSuccessfull(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::SUBTITLE));
    }
    public function verifyLoginFailed(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::ERROR_MESSAGE));
    }
    public function clickHamburgerMenu(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::HAMBURGER_MENU));
    }
    
    public function clickLogout(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::LOGOUT_TEXT));
    }
    

#---------------------------------------------------------
    private function waitForElement(WebDriverBy $by, int $timeout = 10): void
    {
        $wait = new WebDriverWait($this->driver, $timeout);
        $wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
    }
    private function assertCurrentUrl(string $expectedUrl): void
    {
        if ($this->driver->getCurrentURL() !== $expectedUrl) {
            throw new \Exception("Failed to open the correct URL: expected $expectedUrl but got " . $this->driver->getCurrentURL());
        }
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