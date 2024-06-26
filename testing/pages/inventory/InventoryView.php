<?php
namespace Testing\Pages\Inventory;


use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\Exception\NoSuchElementException;

class InventoryView
{
    protected $driver;
    
    // Variables de configuración
    private $config;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
        $this->loadConfig();
    }

    public function loadConfig(): void  
    {

        $configPath = './config/config.php';

        if (file_exists($configPath) && is_readable($configPath)) {
            $this->config = require $configPath;
        } else {
            throw new \Exception("No se puede cargar el archivo de configuración: $configPath");
        }
    }
    public function getConfig(string $key): string  
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            throw new \Exception("La clave de configuración '$key' no está definida en el archivo de configuración");
        }
    }
#----------------------------------------#
    
    public function getUrl(): string
    {
        return $this->getConfig('URL');
    }

    public function getLogoXpath(): string
    {
        return $this->getConfig('LOGO');
    }

    public function getUsernameFieldXpath(): string
    {
        return $this->getConfig('USERNAME_FIELD');
    }

    public function getPasswordFieldXpath(): string
    {
        return $this->getConfig('PASSWORD_FIELD');
    }

    public function getLoginButtonXpath(): string
    {
        return $this->getConfig('LOGIN_BUTTON');
    }

    public function getSubtitleXpath(): string
    {
        return $this->getConfig('SUBTITLE');
    }

    public function getHamburgerMenuButtonXpath(): string
    {
        return $this->getConfig('HAMBURGER_MENU');
    }

    public function getShoppingCartButtonXpath(): string
    {
        return $this->getConfig('SHOPPING_CART');
    }
    public function getCloseMenuButtonXpath(): string
    {
        return $this->getConfig('CLOSE_MENU');
    }
    public function getAboutTextXpath(): string
    {
        return $this->getConfig('ABOUT_TEXT');
    }
    public function getSauceLabsLogo(): string
    {
        return $this->getConfig('SAUCE_LABS_LOGO');
    }


    // Método para abrir la URL
    public function open(): void
    {
        $this->driver->get($this->getUrl());
        $this->assertCurrentUrl($this->getUrl());
        $this->waitForElement(WebDriverBy::xpath($this->getLogoXpath()));
    }

    // Métodos para interactuar con los elementos de la página
    public function setUsername(string $username): void
    {
        $this->fillField(WebDriverBy::xpath($this->getUsernameFieldXpath()), $username);
    }

    public function setPassword(string $password): void
    {
        $this->fillField(WebDriverBy::xpath($this->getPasswordFieldXpath()), $password);
    }

    public function clickLoginButton(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->getLoginButtonXpath()));
    }

    public function verifyLoginSuccessfull(): string
{
    $loginMessage = $this->getElementText(WebDriverBy::xpath($this->getSubtitleXpath()));
    
    $isFirstElementPresent = $this->isElementPresent(WebDriverBy::xpath($this->getHamburgerMenuButtonXpath())); 
    $isSecondElementPresent = $this->isElementPresent(WebDriverBy::xpath($this->getShoppingCartButtonXpath())); 

    return $loginMessage . $isFirstElementPresent . $isSecondElementPresent;
}

    public function clickHamburgerMenuButton(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->getHamburgerMenuButtonXpath()));
    }
    public function verifyClickHamburgerMenuButton(): string
{
    $ClickOk = $this->isElementPresent(WebDriverBy::xpath($this->getCloseMenuButtonXpath())); 

    return $ClickOk ;

}
    public function clickAbout(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->getAboutTextXpath()));
    }
    public function verifyClickAbout(): string
{
    $isClickAbout = $this->isElementPresent(WebDriverBy::xpath($this->getSauceLabsLogo())); 
    $this->goBack();
    return $isClickAbout;
}

#----------------------------------------#

    private function waitForElement(WebDriverBy $by, int $timeout = 17): void
    {
        $wait = new WebDriverWait($this->driver, $timeout);
        $wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
    }

    private function assertCurrentUrl(string $expectedUrl): void
    {
        $currentUrl = rtrim($this->driver->getCurrentURL(), '/');
        $normalizedExpectedUrl = rtrim($expectedUrl, '/');
        
        if ($currentUrl !== $normalizedExpectedUrl) {
            throw new \Exception("No se pudo abrir la URL correcta: se esperaba $normalizedExpectedUrl pero se obtuvo $currentUrl");
        }
    }

    private function fillField(WebDriverBy $by, string $value): void
    {
        try {
            $element = $this->driver->findElement($by);
            $element->clear();
            $element->sendKeys($value);
        } catch (\Exception $e) {
            throw new \Exception("Error al completar el campo: " . $e->getMessage());
        }
    }

    private function clickElement(WebDriverBy $by): void
    {
        try {
            $this->driver->findElement($by)->click();
        } catch (\Exception $e) {
            throw new \Exception("Error al hacer clic en el elemento: " . $e->getMessage());
        }
    }

    private function getElementText(WebDriverBy $by): string
    {
        try {
            $this->waitForElement($by);
            return $this->driver->findElement($by)->getText();
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener el texto del elemento: " . $e->getMessage());
        }
    }
    private function isElementPresent(WebDriverBy $by): bool
    {
        try {
            $this->waitForElement($by);
            $this->driver->findElement($by);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    private function goBack(): void
    {
        try {
            $this->driver->navigate()->back();
        } catch (\Exception $e) {
            throw new \Exception("Error al intentar regresar a la página anterior: " . $e->getMessage());
        }
    }

}
?>
