<?php

namespace Melifaro\BookingBundle\Tests\DependencyInjection;

use Melifaro\BookingBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsConfigurationInterface()
    {
        $rc = new \ReflectionClass('Melifaro\BookingBundle\DependencyInjection\Configuration');

        $this->assertTrue($rc->implementsInterface('Symfony\Component\Config\Definition\ConfigurationInterface'));
    }

    public function testCouldBeConstructedWithResolversAndLoadersFactoriesAsArguments()
    {
        new Configuration(array(), array());
    }

    public function testInjection()
    {
        $config = $this->processConfiguration(new Configuration(),
            array(
                'melifaro_booking'=> array(
                    'entity_class' => 'Vendor\Bundle\Entity\Class'
                )
            )
        );

        $this->assertArrayHasKey('entity_class', $config);
        $this->assertEquals($config['entity_class'], 'Vendor\Bundle\Entity\Class');
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testExceptionIfRequiredParameterIsMissing()
    {
        $config = $this->processConfiguration(new Configuration(),
            array(
                'melifaro_booking'=> array(
                )
            )
        );

    }

    /**
     * @param ConfigurationInterface $configuration
     * @param array                  $configs
     *
     * @return array
     */
    protected function processConfiguration(ConfigurationInterface $configuration, array $configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }
}
