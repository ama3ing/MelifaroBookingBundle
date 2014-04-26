<?php
namespace Melifaro\BookingBundle\Tests\Twig;

use Melifaro\BookingBundle\Twig\CalendarExtension;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalendarExtensionTest extends WebTestCase
{
    protected $container;

    protected $item;

    public function setUp()
    {
        if (!class_exists('Doctrine\ORM\EntityManager')) {
            $this->markTestSkipped('Doctrine ORM is not available.');
        }

        parent::setUp();
        self::createClient();

        $this->container = self::$kernel->getContainer();
        $this->item = $this->container->get('doctrine')
            ->getRepository('Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\BookableItem')
            ->findOneBy(array());
    }

    public function testCanBeConstructedWithNeededArguments()
    {
        new CalendarExtension('Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\Booking',
            $this->container->get('doctrine'));
    }

    public function testKernelShouldContainBCalendarExtension()
    {

        $this->assertInstanceOf('Symfony\Component\DependencyInjection\ContainerInterface', $this->container);
        $this->assertInstanceOf('Melifaro\BookingBundle\Twig\CalendarExtension',
            $this->container->get('booking_calendar'));
    }

    public function testShouldBeTwigExtension()
    {
        $this->assertInstanceOf('\Twig_Extension', $this->container->get('booking_calendar'));
    }

    public function testShouldBeNamed()
    {
        $this->assertEquals('melifaro_booking_bundle_calendar', $this->container->get('booking_calendar')->getName());
    }

    public function testShouldContainFunctions()
    {
        $cal =  $this->container->get('booking_calendar');

        $functions = $cal->getFunctions();

        $this->assertTrue(count($functions) > 0);
    }
}
 