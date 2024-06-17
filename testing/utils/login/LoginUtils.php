<?php
namespace Testing\Utils\login;

use Testing\Pages\Login\LoginView;
use PHPUnit\Framework\Assert;

class LoginUtils
{
    public static function performSuccessfulLogin(LoginView $loginPage): void
    {
        $loginPage->loadConfig(); 
        $username = $loginPage->getConfig('VALID_USER');
        $password = $loginPage->getConfig('VALID_PASSWORD');
        $loginPage->open();
        $loginPage->setUsername($username);
        $loginPage->setPassword($password);
        $loginPage->clickLoginButton();
        $successlogin = $loginPage->verifyLoginSuccessfull();

        Assert::assertStringContainsString('Products', $successlogin, 'Login failed. Expected "Products" message not found.');
    }
}
?>
