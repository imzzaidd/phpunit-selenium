<?php
namespace Testing\Pages;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;

class LoginPage
{
    protected $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function open()
    {
        $this->driver->get('https://practicetestautomation.com/practice-test-login/');
        $this->waitForElement(WebDriverBy::xpath('//input[@id="username"]'));
    }

    public function setUsername($username)
    {
        $this->driver->findElement(WebDriverBy::xpath("//input[@name='username']"))->sendKeys($username);
    }

    public function setPassword($password)
    {
        $this->driver->findElement(WebDriverBy::xpath("//input[@name='password']"))->sendKeys($password);
    }

    public function clickLoginButton()
    {
        $this->driver->findElement(WebDriverBy::xpath("//button[contains(.,'Submit')]"))->click();
    }

    public function getSuccessMessage()
    {
        $this->waitForElement(WebDriverBy::xpath('//h1[@class="post-title" and contains(text(), "Logged In Successfully")]'));
        return $this->driver->findElement(WebDriverBy::xpath('//h1[@class="post-title" and contains(text(), "Logged In Successfully")]'))->getText();
    }

    public function getErrorMessageUser()
    {
        $this->waitForElement(WebDriverBy::xpath("//div[@class='show'][contains(.,'Your username is invalid!')]"    ));
        return $this->driver->findElement(WebDriverBy::xpath("//div[@class='show'][contains(.,'Your username is invalid!')]"))->getText();
    
    }

    public function getErrorMessagePassword()
    {
        $this->waitForElement(WebDriverBy::xpath("//div[@class='show'][contains(.,'Your password is invalid!')]"    ));
        return $this->driver->findElement(WebDriverBy::xpath("//div[@class='show'][contains(.,'Your password is invalid!')]" ))->getText();
    
    }


    protected function waitForElement($by, $timeout = 10)
    {
        $wait = new \Facebook\WebDriver\WebDriverWait($this->driver, $timeout);
        $wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
    }
}
?>

