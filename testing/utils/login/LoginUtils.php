<?php
namespace Testing\Utils\Login;

use Testing\Pages\Login\LoginView;

class LoginUtils
{
    public static function performSuccessfulLogin(LoginView $loginPage): void
    {
        $loginPage->open();
        $loginPage->setUsername('standard_user');
        $loginPage->setPassword('secret_sauce');
        $loginPage->clickLoginButton();
        $successlogin = $loginPage->verifyLoginSuccessfull();
        if (strpos($successlogin, 'Products') === false) {
            throw new \Exception('Login failed.');
        }
    }
}
?>
