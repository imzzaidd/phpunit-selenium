<?php
// config.php

return [
    'URL' => 'https://www.saucedemo.com/',
    'LOGO' => '//div[@class="login_logo"]',
    'USERNAME_FIELD' => '//input[@id="user-name"]',
    'PASSWORD_FIELD' => '//input[@id="password"]',
    'LOGIN_BUTTON' => '//input[@id="login-button"]',
    'SUBTITLE' => "//span[contains(.,'Products')]",
    'ERROR_MESSAGE' => '//h3[contains(text(), "Username and password do not match")]',
    'HAMBURGER_MENU' => '//button[@id="react-burger-menu-btn"]',
    'LOGOUT_TEXT' => '//a[@id="logout_sidebar_link"]',
    'LOGIN_INFO' => '//h4[contains(text(), "Accepted usernames are:")]',
];
?>
