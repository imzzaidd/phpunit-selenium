<?php
namespace Testing\Utils\inventory;

use Testing\Pages\Inventory\InventoryView;
use PHPUnit\Framework\Assert;

class InventoryUtils
{
    public static function performInventoryView(InventoryView $inventoryView): void
    {
        $inventoryView->loadConfig(); 
        $username = $inventoryView->getConfig('VALID_USER');
        $password = $inventoryView->getConfig('VALID_PASSWORD');
        $inventoryView->open();
        $inventoryView->setUsername($username);
        $inventoryView->setPassword($password);
        $inventoryView->clickLoginButton();
        $successlogin = $inventoryView->verifyLoginSuccessfull();

        Assert::assertStringContainsString('Products', $successlogin, 'Login failed. Expected "Products" message not found.');
    }
    public static function performHamburguerMenu(InventoryView $inventoryView): void
    {
        self::performInventoryView($inventoryView);
        $inventoryView->clickHamburgerMenuButton();
        $inventoryView->verifyClickHamburgerMenuButton();
        $inventoryView->clickAbout();
        $inventoryView->verifyClickAbout();
    }


}
?>
