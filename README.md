BookingBundle [![SensioLabsInsight](https://insight.sensiolabs.com/projects/077bcf9f-3153-423b-bd97-dd580ab81d4c/big.png)](https://insight.sensiolabs.com/projects/077bcf9f-3153-423b-bd97-dd580ab81d4c)
=============
[![Build Status](https://travis-ci.org/me1ifaro/MelifaroBookingBundle.svg?branch=master)](https://travis-ci.org/me1ifaro/MelifaroBookingBundle)
-------------
Booking Bundle for Symfony 2 Applications. Bundle provides some useful functionality for handling bookings
on your website.


Installation
-------------

Prefered way to install this bundle is using [composer](http://getcomposer.org)

Download the bundle:
```bash
$ php composer.phar require "melifaro/booking-bundle:dev-master"
```
Add it to your Kernel:

```php
<?php

// app/AppKernel.php


public function registerBundles()
{
    $bundles = array(
        // ...

        new Melifaro\BookingBundle\MelifaroBookingBundle(),
    );
}
```
