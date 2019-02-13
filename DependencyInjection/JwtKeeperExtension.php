<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\DependencyInjection;

use MaciejKosiarski\JwtKeeperBundle\DependencyInjection\Configuration\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class JwtKeeperExtension extends Extension
{
	public function load(array $configs, ContainerBuilder $container)
	{
		$loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
		$loader->load('services.xml');

		$configuration = new Configuration();

		$config = $this->processConfiguration($configuration, $configs);

		$definition = $container->getDefinition('jwt.provider');
		$definition->replaceArgument(0, $config['jwt_route']);
	}
}