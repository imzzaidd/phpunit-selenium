<?php
namespace Testing\Pages\Index;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class IndexCommercePage
{
    protected $driver;
    private const URL = 'https://www.saucedemo.com';
    private const URL_INDEX="https://www.saucedemo.com/inventory.html";
    private const LOGO = "//div[@class='login_logo'][contains(.,'Swag Labs')]";
    private const USERNAME_FIELD = "//input[contains(@placeholder,'Username')]";
    private const PASSWORD_FIELD = "//input[contains(@placeholder,'Password')]";
    private const LOGIN_BUTTON = "//input[@value='Login']";
    private const SUBTITLE = "//span[@class='title'][contains(.,'Products')]";
    private const HAMBURGER_MENU = "//button[contains(.,'Open Menu')]"; 
    private const CLOSE_HAMBURGER_MENU = "//button[contains(.,'Close Menu')]";
    private const ABOUT_TEXT = "//a[contains(.,'About')]";
    private const LOGOUT_TEXT = "//a[contains(.,'Logout')]";
    private const ITEM_01 = "//div[@class='inventory_item_name '][contains(.,'Sauce Labs Backpack')]";
    private const ADD_CART_BTN = "//button[contains(.,'Add to cart')]";

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

    public function clickHamburgerMenu(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::HAMBURGER_MENU));
    }
    public function clickCloseHamburgerMenu(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::CLOSE_HAMBURGER_MENU));
    }
    public function verifyCloseHamburgerMenu(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::HAMBURGER_MENU));
    }
    public function verifyClickHambugerMenu(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::CLOSE_HAMBURGER_MENU));
    }

    public function clickAbout(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::ABOUT_TEXT));
    }

    public function verifyClickAbout(): string
    {
        $currentUrl = $this->driver->getCurrentURL();
        $expectedUrl = 'https://saucelabs.com'; 
        if (rtrim($currentUrl, '/') !== rtrim($expectedUrl, '/')) {
            throw new \Exception("Failed to redirect to the correct URL after clicking 'About'. Expected: '$expectedUrl', Actual: '$currentUrl'");
        }
        return $currentUrl;
    }
    public function backToIndex(): void
    {
        $this->driver->navigate()->back();
        $this->assertCurrentUrl(self::URL_INDEX);

    }
    public function clickLogout(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::LOGOUT_TEXT));
    }
    public function verifyLogout(): string
    {
        $currentUrl = $this->driver->getCurrentURL();
        $expectedUrl = 'https://www.saucedemo.com';
        if (rtrim($currentUrl, '/') !== rtrim($expectedUrl, '/')) {
            throw new \Exception("Failed to redirect to the correct URL after clicking 'Logout'. Expected: '$expectedUrl', Actual: '$currentUrl'");
        }
        return $currentUrl;
    }

    public function clickItems(): void
    {
        $this->clickElement(WebDriverBy::xpath(self::ITEM_01));
    }
    public function verifyItemURL(): string
    {
        $currentUrl = $this->driver->getCurrentURL();
        $expectedUrl = 'https://www.saucedemo.com/inventory-item.html?id=4';
        if (rtrim($currentUrl, '/') !== rtrim($expectedUrl, '/')) {
            throw new \Exception("Failed to redirect to the correct URL after clicking 'Items'. Expected: '$expectedUrl', Actual: '$currentUrl'");
        }
        return $currentUrl;
    }
    public function verifyItemView(): string
    {
        return $this->getElementText(WebDriverBy::xpath(self::ADD_CART_BTN));
    }
    

    #---------------------------------------------------------
    private function waitForElement(WebDriverBy $by, int $timeout = 10): void
    {
        $wait = new WebDriverWait($this->driver, $timeout);
        $wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
    }

    private function assertCurrentUrl(string $expectedUrl): void
    {
        $currentUrl = rtrim($this->driver->getCurrentURL(), '/');
        $normalizedExpectedUrl = rtrim($expectedUrl, '/');
        
        if ($currentUrl !== $normalizedExpectedUrl) {
            throw new \Exception("Failed to open the correct URL: expected $normalizedExpectedUrl but got $currentUrl");
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
