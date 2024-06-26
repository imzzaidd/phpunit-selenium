<?php
namespace Testing\Pages\Login;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class LoginView
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

    public function getErrorMessageXpath(): string
    {
        return $this->getConfig('ERROR_MESSAGE');
    }

    public function getHamburgerMenuXpath(): string
    {
        return $this->getConfig('HAMBURGER_MENU');
    }
    public function getAboutTextXpath(): string
    {
        return $this->getConfig('ABOUT_TEXT');
    }

    public function getLogoutTextXpath(): string
    {
        return $this->getConfig('LOGOUT_TEXT');
    }

    public function getLoginInfoXpath(): string
    {
        return $this->getConfig('LOGIN_INFO');
    }

    public function getEmptyMessage(): string
    {
        return $this->getConfig('EMPTY_MESSAGE');
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
        return $this->getElementText(WebDriverBy::xpath($this->getSubtitleXpath()));
    }

    public function verifyLoginFailed(): string
    {
        return $this->getElementText(WebDriverBy::xpath($this->getErrorMessageXpath()));
    }

    public function clickHamburgerMenu(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->getHamburgerMenuXpath()));
    }
    public function clickAbout(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->getAboutTextXpath()));
        $this->goBack();
    }


    public function clickLogout(): void
    {
        $this->clickElement(WebDriverBy::xpath($this->getLogoutTextXpath()));
    }

    public function verifyLogout(): string
    {
        return $this->getElementText(WebDriverBy::xpath($this->getLoginInfoXpath()));
    }
    
    public function verifyEmptyMessage(): string
    {
        return $this->getElementText(WebDriverBy::xpath($this->getEmptyMessage()));
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
