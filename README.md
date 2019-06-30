eZ Platform Captcha
======================

One of the request me and my teammates at The Cocktail receive in the last times
is to have a captcha mechanism in the admin login form and also 
in the recover password form. 

This bundle allows this possibility taking advantage of the 
gregwar/captcha-bundle and gregwar-captcha packages. 


What this bundle does
=====================

To add captcha to those forms, it works different depending on the form

### login form

in eZ Platform, login form is not a `Symfony Form`. Instead, is a
normal form that you can see in the [login.html.twig](https://github.com/ezsystems/ezplatform-admin-ui/blob/1.5/src/bundle/Resources/views/Security/login.html.twig) template.

This makes impossible to extend this from from a php class. This is why, 
this bundles adds is own security controller and templates, so the captcha can be shown

When the login_form option for the bundle is set to true, the compiler pass
will change some definitions. 

In the SecurityController we use the Captcha library to create the captcha image. 
This image is sent to the template. 
Besides, once is generated, the phrase is stored in session. 

There's also an override for the *UsernamePasswordFormAuthenticationListener* that
checks for this session variable and compares its value to the one 
provided in the form field. 

If there's no match, a exception is thrown. If there's, all goes as before. 


### forgot password form

On the other hand, there's a symfony form for the forgot password functionality.
So, in this case we opt to add a Form Type Extension that will add a Captcha Field Type. 

This Form Type Extension is only added to the container when the option is enabled. 


Install
=======

To install this bundle require this package with composer

`composer require crevillo/ezplatform-captcha`

then, you will need to enable the Gregwar Captcha Bundle and also
this bundle in your AppKernel file

```php
<?php
// app/appKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
        new Crevillo\EzCaptchaBundle\TheCocktailEzCaptchaBundle(),
       
    );
}
```

Configuration
=============

Add the following configuration to your `app/config/config.yml`:

    gregwar_captcha: ~
    crevillo_ez_captcha: ~

Usage
======

To have captcha in the forms you have to explicity enable this options. 
Modify your `app/config/config.yml`

    crevillo_ez_captcha:
        login_form: true
        forgot_password_form: true

You can disable captcha protection just setting one or both values to `false`

Options
========

For now you can define custom width and height for the captcha, but 
please take in account this will only work for the login form. 
For the other one, you can follow the instructions at [Gregwar Captcha Bundle](https://github.com/gregwar/CaptchaBundle/) documentation

