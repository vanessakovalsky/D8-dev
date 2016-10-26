<?php

namespace Drupal\demo_formation;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Symfony\Component\DependencyInjection\Definition;


class DemoFormationServiceProvider implements ServiceProviderInterface {
  public function register(ContainerBuilder $container){
    $definition = new Definition('\Drupal\demo_formation\Controller\DemoFormationController', ['null']);
    $container->setDefinition('mon_super_service_demo', $definition);
  }
}
