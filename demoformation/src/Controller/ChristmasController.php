<?php

namespace Drupal\demoformation\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Serialization\Json;

/**
 * Class ChristmasController.
 *
 * @package Drupal\demoformation\Controller
 */
class ChristmasController extends ControllerBase {
  /**
   * Chantevivelevent.
   *
   * @return string
   *   Return Hello string.
   */
  public function chanteViveLeVent($user) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: chanteViveLeVent with parameter(s): '.  $user .''),
    ];
  }

  public function danseMonBeauSapin() {
    $output = array(
      '#type' => 'markup',
      '#markup' => $this->t('<h2>Mon beau sapin</h2>Roi des forêts ...')
    );
    return $output;
  }

  public function singFivory(){
    $config = \Drupal::service('config.factory')->get('demoformation.blocksettings');
    $url_api = $config->get('url');
    $client = \Drupal::service('http_client');
    $result = $client->get($url_api.'/api/v3/brands?limit=20', ['Accept' => 'application/json']);
    $result_decode = \Drupal\Component\Serialization\Json::decode($result->getBody()->getContents());
    foreach($result_decode['brands'] as $brand){
      $node_brand = \Drupal\node\Entity\Node::create([
        'type'  => 'article',
        'title' => $brand['name'],
        'body' => [
            'summary' => '',
            'value' => $brand['description'],
            'format' => 'full_html'
          ]
      ]);
      $node_brand->save();
      $term_id = taxonomy_term_load_multiple_by_name($brand['category']['name'], 'tags');
      //Vérification de l'existence des catégories
      // $taxonomy_query = \Drupal::entityQuery('taxonomy_term')
      //                   ->condition('vid', 'tags')
      //                   ->condition('name', $brand['category']['name']);
      // $result_taxo = $taxonomy_query->execute()->fetchAll();
      if(empty($term_id)){
        $category = \Drupal\taxonomy\Entity\Term::create([
          'vid' => 'tags',
          'langcode' => 'en',
          'name' => $brand['category']['name']
        ]);
        $category->save();
        $term_id = $category->id();
      }
      if (is_array($term_id)){
        $term_id = array_shift($term_id);
      }
      $node_brand->get('field_tags')[] = $term_id;
      $node_brand->save();

      $nodes[] = $node_brand;
    }

    return array(
      '#theme' => 'liste_commercant_fivory',
      '#brands' => $nodes,
    );
  }

}
