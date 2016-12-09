<?php

namespace Drupal\demo_form_formation\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Fournit un block affichant le formulaire custom
 *
 * @Block( id = "custom_form_block",
 *  admin_label = @Translation("Contacter nous"),
 *  category = @Translation("Block contenant notre formulaire custom"),
 * )
 */

class DemoFormBlock extends BlockBase {
  public function build(){
    $custom_form = \Drupal::formBuilder()->getForm('Drupal\demo_form_formation\Form\CustomContactForm');
    $build = [
      '#theme' => 'custom_form_block',
      '#custom_form' => $custom_form
    ];
    return $build;
  }
}
