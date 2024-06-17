<?php
namespace Testing\Utils\login;

use Testing\Pages\Login\LoginView;
use PHPUnit\Framework\Assert;

class LoginUtils
{
    public static function performSuccessfulLogin(LoginView $loginPage): void
    {
        $loginPage->open();
        $loginPage->setUsername('standard_user');
        $loginPage->setPassword('secret_sauce');
        $loginPage->clickLoginButton();
        $successlogin = $loginPage->verifyLoginSuccessfull();

        // Assert that the success message contains 'Products'
        Assert::assertStringContainsString('Products', $successlogin, 'Login failed. Expected "Products" message not found.');
    }
}
?>
