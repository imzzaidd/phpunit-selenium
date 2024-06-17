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
    public static function performFailedLoginUser(LoginView $loginPage): void
    {
        $loginPage->loadConfig(); 
        $username = $loginPage->getConfig('INVALID_USER');
        $password = $loginPage->getConfig('VALID_PASSWORD');
        $loginPage->open();
        $loginPage->setUsername($username);
        $loginPage->setPassword($password);
        $loginPage->clickLoginButton();
        $failedlogin = $loginPage->verifyLoginFailed();

        Assert::assertStringContainsString('Username and password do not match any user in this service', $failedlogin, 'Login failed. Expected "Username and password do not match any user in this service" message not found.');
    }
    public static function performFailedLoginPassword(LoginView $loginPage): void
    {
        $loginPage->loadConfig(); 
        $username = $loginPage->getConfig('VALID_USER');
        $password = $loginPage->getConfig('INVALID_PASSWORD');
        $loginPage->open();
        $loginPage->setUsername($username);
        $loginPage->setPassword($password);
        $loginPage->clickLoginButton();
        $failedlogin = $loginPage->verifyLoginFailed();

        Assert::assertStringContainsString('Username and password do not match any user in this service', $failedlogin, 'Login failed. Expected "Username and password do not match any user in this service" message not found.');
    }
    public static function performLogOut(LoginView $loginPage): void
    {
        $loginPage->loadConfig(); 
        $username = $loginPage->getConfig('VALID_USER');
        $password = $loginPage->getConfig('VALID_PASSWORD');
        $loginPage->open();
        $loginPage->setUsername($username);
        $loginPage->setPassword($password);
        $loginPage->clickLoginButton();
        $loginPage->clickHamburgerMenu();
        $loginPage->clickLogout();
        $logout = $loginPage->verifyLogout();
        Assert::assertStringContainsString('Accepted usernames are:', $logout);

    }
    public static function performLoginEmpty(LoginView $loginPage): void
    {
        $loginPage->loadConfig();
        $empty_login_message = $loginPage->getConfig('EMPTY_MESSAGE');
        $loginPage->open();
        $loginPage->clickLoginButton();
        $loginPage->verifyEmptyMessage();
        Assert::assertStringContainsString('Epic sadface: Username is required', $empty_login_message, 'Login failed. Expected "Epic sadface: Username is required" message not found.');
    
    }

}
?>
