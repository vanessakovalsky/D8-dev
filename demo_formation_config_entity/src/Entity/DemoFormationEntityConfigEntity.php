<?php

namespace Drupal\demo_formation_config_entity\Entity;
use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\demo_formation_config_entity;

/**
    * Defines a DemoFormationEntityConfig configuration entity class.
    *
    * @ConfigEntityType(
    *   id = "demo_formation_config_entity",
    *   label = @Translation("DemoFormationEntityConfig"),
    *   fieldable = FALSE,
    *   handlers = {
    *     "list_builder" = "Drupal\demo_formation_config_entity\DemoFormationConfigEntityListBuilder",
    *     "form" = {
    *       "add" = "Drupal\demo_formation_config_entity\Form\DemoFormationConfigEntityForm",
    *       "edit" = "Drupal\demo_formation_config_entity\Form\DemoFormationConfigEntityForm",
    *       "delete" = "Drupal\demo_formation_config_entity\Form\DemoFormationConfigEntityDeleteForm"
    *     }
    *   },
    *   config_prefix = "demo_formation_config_entity",
    *   admin_permission = "administer site configuration",
    *   entity_keys = {
    *     "id" = "id",
    *     "label" = "name"
    *   },
    * )
    */

class DemoFormationEntityConfigEntity extends  ConfigEntityBase implements DemoFormationConfigEntityInterface
{

     /**
      * The ID of the DemoFormationEntityConfig.
      *
      * @var string
      */
     public $id;

     /**
      * The label.
      *
      * @var string
      */
     public $label;

     /**
      * The key.
      *
      * @var string
      */
     public $key;

   }
