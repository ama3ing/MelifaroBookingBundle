<?php

namespace Melifaro\BookingBundle\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookerTest extends WebTestCase
{
    public function setUp()
    {
        if (!class_exists('Doctrine\ORM\EntityManager')) {
            $this->markTestSkipped('Doctrine ORM is not available.');
        }

        parent::setUp();
    }

    public function testKernel()
    {
        self::createClient();
        var_dump(self::$kernel);
        exit;
        $this->assertTrue(true);
    }
}
 