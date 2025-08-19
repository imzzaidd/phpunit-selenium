<?php
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;
use Tests\Pages\HomePage;

class HomePageTest extends TestCase
{
    private static RemoteWebDriver $driver;

    public static function setUpBeforeClass(): void
    {
        self::$driver = RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()
        );
    }

    public function testHomePageLoadsSuccessfully(): void
    {
        $page = new HomePage(self::$driver);
        $page->visit();

        $this->assertTrue($page->isLoaded(), "Home page did not load as expected.");
    }

    public static function tearDownAfterClass(): void
    {
        self::$driver->quit();
    }
}