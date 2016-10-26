<?php

namespace Drupal\demo_formation\Controller;

use Drupal\Core\Controller\ControllerBase;

class DemoPageController extends ControllerBase{

  public function __construct(){
    return $this;
  }

  public function indexDemo(){
     $database = \Drupal::service('mon_super_service_demo');
     $db_object = $database->getDatabase();
     var_dump($db_object);
     die();
    return array('#markup' => 'hello world'.$db_object->getConnection());
  }

}
