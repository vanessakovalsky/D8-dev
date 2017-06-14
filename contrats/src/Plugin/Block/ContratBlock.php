<?php

namespace Drupal\contrats\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ContratBlock' block.
 *
 * @Block(
 *  id = "contrat_block",
 *  admin_label = @Translation("Contrat block"),
 * )
 */
class ContratBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
         'corps' => $this->t(''),
        ] + parent::defaultConfiguration();

 }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['corps'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Corps'),
      '#description' => $this->t(''),
      '#default_value' => $this->configuration['corps'],
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['corps'] = $form_state->getValue('corps');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['contrat_block_corps']['#markup'] = '<p>' . $this->configuration['corps'] . '</p>';

    return $build;
  }

}
