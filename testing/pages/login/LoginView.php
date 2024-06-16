<?php
namespace Testing\Pages\Login;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class LoginView
{
    protected $driver;
    
    // Variables que serán cargadas desde el .env
    private $url;
    private $logo;
    private $usernameField;
    private $passwordField;
    private $loginButton;
    private $subtitle;
    private $errorMessage;
    private $hamburgerMenu;
    private $logoutText;
    private $loginInfo;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
        
        // Cargar las variables de entorno
        $this->url = getenv('URL');
        $this->logo = getenv('LOGO');
        $this->usernameField = getenv('USERNAME_FIELD');
        $this->passwordField = getenv('PASSWORD_FIELD');
        $this->loginButton = getenv('LOGIN_BUTTON');
        $this->subtitle = getenv('SUBTITLE');
        $this->errorMessage = getenv('ERROR_MESSAGE');
        $this->hamburgerMenu = getenv('HAMBURGER_MENU');
        $this->logoutText = getenv('LOGOUT_TEXT');
        $this->loginInfo = getenv('LOGIN_INFO');
    }

    public function open(): void
    {
        $this->driver->get($this->url);
        $this->assertCurrentUrl($this->url);
        $this->waitForElement(WebDriverBy::xpath($this->logo));
    }

    public function setUsername(string $username): void
    {
        $this->fillField(WebDriverBy::xpath($this->usernameField), $username);
    }

    public function setPassword(string $password): void
    {
        $this->fillField(WebDriverBy::xpath($this->passwordField), $password);
    }

    public function clickLoginButton(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->loginButton));
    }

    public function verifyLoginSuccessfull(): string
    {
        return $this->getElementText(WebDriverBy::xpath($this->subtitle));
    }

    public function verifyLoginFailed(): string
    {
        return $this->getElementText(WebDriverBy::xpath($this->errorMessage));
    }

    public function clickHamburgerMenu(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->hamburgerMenu));
    }

    public function clickLogout(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->logoutText));
    }

    public function verifyLogout(): string
    {
        return $this->getElementText(WebDriverBy::xpath($this->loginInfo));
    }

    // Métodos privados
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