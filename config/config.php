<?php
return [
    'URL' => getenv('URL') ?: 'https://www.saucedemo.com', // Fallback URL en caso de que no se encuentre la variable de entorno
    'LOGO' => getenv('LOGO') ?: '//div[@class="login_logo"]',
    'USERNAME_FIELD' => getenv('USERNAME_FIELD') ?: '//input[@id="user-name"]',
    'PASSWORD_FIELD' => getenv('PASSWORD_FIELD') ?: '//input[@id="password"]',
    'LOGIN_BUTTON' => getenv('LOGIN_BUTTON') ?: '//input[@id="login-button"]',
    'SUBTITLE' => getenv('SUBTITLE') ?: "//span[contains(.,'Products')]",
    'ERROR_MESSAGE' => getenv('ERROR_MESSAGE') ?: '//h3[contains(text(), "Username and password do not match")]',
    'HAMBURGER_MENU' => getenv('HAMBURGER_MENU') ?: '//button[@id="react-burger-menu-btn"]',
    'LOGOUT_TEXT' => getenv('LOGOUT_TEXT') ?: '//a[@id="logout_sidebar_link"]',
    'LOGIN_INFO' => getenv('LOGIN_INFO') ?: '//h4[contains(text(), "Accepted usernames are:")]',
];
?>
