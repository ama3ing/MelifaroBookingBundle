<?php
/**
 * Created by PhpStorm.
 * User: melifaro
 * Date: 4/26/14
 * Time: 7:39 PM
 */

namespace Melifaro\BookingBundle\Tests\DependencyInjection;
use Melifaro\BookingBundle\DependencyInjection\MelifaroBookingExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @covers Melifaro\BookingBundle\DependencyInjection\Configuration
 * @covers Melifaro\BookingBundle\DependencyInjection\MelifaroBookingExtension
 */
class MelifaroBookingExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadWithoutRequiredParameter()
    {
        $loader = new MelifaroBookingExtension();

        $config = array();

        $loader->load($config, new ContainerBuilder());
    }

    public function testLoadWithRequiredParameters()
    {
        $loader = new MelifaroBookingExtension();
        $config = array('melifaro_booking' => array(
            'entity_class'=>'Vendor\Bundle\Entity\Class')
        );

        $loader->load($config, new ContainerBuilder());
    }

    public function testContainerHasNeccessaryServices()
    {
        $this->loadConfiguration();

        $entityClass = $this->containerBuilder->getParameter('melifaro_booking.entity_class');
        $services = $this->containerBuilder->getServiceIds();

        $this->assertEquals('Vendor\Bundle\Entity\Class', $entityClass);
        $this->assertContains('booker', $services);
        $this->assertContains('booking_calendar', $services);

    }

    protected function loadConfiguration()
    {
        $this->containerBuilder = new ContainerBuilder();
        $loader = new MelifaroBookingExtension();
        $config = array('melifaro_booking' => array(
            'entity_class'=>'Vendor\Bundle\Entity\Class')
        );

        $loader->load($config, $this->containerBuilder);

        $this->assertInstanceOf('Symfony\Component\DependencyInjection\ContainerBuilder', $this->containerBuilder);
    }
}
