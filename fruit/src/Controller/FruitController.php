<?php

namespace Drupal\fruit\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class FruitController.
 *
 * @package Drupal\fruit\Controller
 */
class FruitController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function orangepressee() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method'),
    ];
  }

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
    public function fraisetagada() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method '),
    ];
  }
}
