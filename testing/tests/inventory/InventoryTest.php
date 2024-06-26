<?php
namespace Testing\Tests\Inventory;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Testing\Pages\Inventory\InventoryView;
use Testing\Utils\inventory\InventoryUtils;


class InventoryTest extends TestCase
{
    protected $driver;
    protected $inventoryView;

    protected function setUp(): void
    {
        $this->driver = RemoteWebDriver::create('http://selenium-hub:4444', DesiredCapabilities::chrome());
        $this->inventoryView = new InventoryView($this->driver);
    }

    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }

    public function testInventoryView(): void
    {
        InventoryUtils::performInventoryView($this->inventoryView);
    }

}
?>
