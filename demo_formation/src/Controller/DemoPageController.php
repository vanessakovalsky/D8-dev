<?php

namespace Drupal\demo_formation\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\demo_formation\Event\DemoFormationEvent;

class DemoPageController extends ControllerBase{
  private $dispatcher = NULL;

  public function __construct(){
    $this->dispatcher = \Drupal::service('event_dispatcher');
  }

  public function indexDemo(){
    $this->dispatcher->dispatch('my_event.view', new DemoFormationEvent());
    return array('#markup' => 'hello world');
  }

}
