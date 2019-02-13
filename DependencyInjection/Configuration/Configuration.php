<?php

declare(strict_types=1);

namespace MaciejKosiarski\JwtKeeperBundle\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder(): TreeBuilder
	{
		$treeBuilder = new TreeBuilder('jwt_provider');
		$treeBuilder->getRootNode()
			->children()
				->scalarNode('jwt_route')
					->defaultValue('jwt')
				->end()
			->end();

		return $treeBuilder;
	}
}