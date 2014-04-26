BookingBundle
=============
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/077bcf9f-3153-423b-bd97-dd580ab81d4c/big.png)](https://insight.sensiolabs.com/projects/077bcf9f-3153-423b-bd97-dd580ab81d4c)

[![Build Status](https://travis-ci.org/me1ifaro/MelifaroBookingBundle.svg?branch=master)](https://travis-ci.org/me1ifaro/MelifaroBookingBundle)
-------------
Booking Bundle for Symfony 2 Applications. Bundle provides some useful functionality for handling bookings
on your website.


Installation
-------------

### 1. Download
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
### Create your entity

#### Doctrine ORM
Bundle has all necessary mappings for your entity. Just create your entity class and extend it from
```Melifaro\BookingBundle\Entity\Booking```, create your ```id``` field and setup proper relation for
item you want to be booked.

```php
<?php

namespace Vendor\Bundle\Entity;

use Melifaro\BookingBundle\Entity\Booking as BaseClass;

/**
 * Booking
 *
 * @ORM\Entity()
 * @ORM\Table(name="booking")
 */
class Booking extends BaseClass
{
    /**
         * @var integer
         *
         * @ORM\Column(name="id", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @var \Vendor\Bundle\Entity\BookableItem
         *
         * @ORM\ManyToOne(targetEntity="BookableItem", inversedBy="bookings")
         * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
         */
        protected $item;

        // Don't forget about getters and setters
}

```

Now we are ready to rock!

Booker Service
--------------

Core component of this bundle is booker service. You can get it in your controller by using
```php
<?php

public function bookingAction()
{
    $this->get('booker'); /** @var \Melifaro\BookingBundle\Helper\Booker */
}
```

Booker Service has following methods:
* ``` isAvailableForPeriod($item, \DateTime $start, \DateTime $end) ``` Checks is your item available for period,
returns ```boolean```
* ``` isAvailableForDate($item, \DateTime $date) ``` Checks is your item available for date, returns ```boolean```
* ``` whereAvailableForPeriod(QueryBuilder $queryBuilder, $join, \DateTime $start, \DateTime $end)``` Updates your
```QueryBuilder``` and returns the same ```QueryBuilder``` object with added join and where clause.
> Note: ```$join``` is ```array('field', 'alias')```
* ``` whereAvailableForDate(QueryBuilder $queryBuilder, $join, \DateTime $date)``` Updates your
```QueryBuilder``` and returns the same ```QueryBuilder``` object with added join and where clause.
> Note: ```$join``` is ```array('field', 'alias')```
* ``` book($item, \DateTime $start, \DateTime $end) ``` Books your item returns ```Entity | false``` (```Entity```
on success, ```false``` on failure)

