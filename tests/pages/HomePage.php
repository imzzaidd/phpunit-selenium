<?php
namespace Tests\Pages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class HomePage
{
    private RemoteWebDriver $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function visit(): void
    {
        $this->driver->get('https://play1.automationcamp.ir/');
    }

    public function isLoaded(): bool
    {
        $element = $this->driver->findElement(
            WebDriverBy::xpath("//h1[contains(text(), 'The Playground')]")
        );

        return $element !== null;
    }
}