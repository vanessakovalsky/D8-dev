<?php

namespace Drupal\breaking_db\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class BreakingController.
 *
 * @package Drupal\breaking_db\Controller
 */
class BreakingController extends ControllerBase {
  /**x@
   * Shownodelist.
   *
   * @return string
   *   Return Hello string.
   */
  public function ShowNodeList() {
    $entity_query = \Drupal::entityQuery('node')
                    ->condition('status',1)
                    ->condition('type', 'page');
    $nids = $entity_query->execute();
    $content = \Drupal\node\Entity\Node::loadMultiple($nids);
    $entity_viewer = \Drupal::entityTypeManager()->getViewBuilder('node');
    foreach($content as $page){
      $output .= render($entity_viewer->view($page,'teaser'));
    }
    return [
      '#type' => 'markup',
      '#markup' => 'Liste des pages '. $output
    ];
  }

  public function ShowOtherContent(){
    $dbext = \Drupal\Core\Database\Database::setActiveConnection('ext');
    $dbext_connexion = \Drupal\Core\Database\Database::getConnection();
    $query_animals = $dbext_connexion->select('Animal', 'an');
    $query_animals->fields('an', ['espece','nom']);
    $results = $query_animals->execute()->fetchAll();
    foreach($results as $result){
      $arra_animals .= $result->espece . $result->nom;
    }
    \Drupal\Core\Database\Database::setActiveConnection();
    return [
      '#markup' => $arra_animals,
    ];
  }
}
