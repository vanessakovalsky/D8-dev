<?php

namespace Drupal\contrats\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Contrat entity entities.
 */
class ContratEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
