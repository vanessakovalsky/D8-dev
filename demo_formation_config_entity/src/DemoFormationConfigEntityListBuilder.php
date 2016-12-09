<?php

namespace Drupal\demo_formation_config_entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;


class DemoFormationConfigEntityListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Name');
    $header['key'] = $this->t('API Key');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {

    // Label
    $row['label'] = $this->getLabel($entity);

    // Key
    $row['key'] = $entity->key;

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {

    $build = parent::render();

    $build['#empty'] = $this->t('There are no DemoFormationConfigEntity available.');
    return $build;
  }

}
