<?php

namespace Drupal\demoformation\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class BlockSettingsForm extends ConfigFormBase {

  public function getFormId(){
    return 'demoformation_block_settings';
  }

  protected function getEditableConfigNames() {
    return [
      'demoformation.blocksettings',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state){
    $config = $this->config('demoformation.blocksettings');

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Block Title'),
      '#default_value' => $config->get('title'),
    );
    $form['url'] = array(
      '#type' => 'url',
      '#title' => $this->t('URL de l\'API'),
      '#default_value' => $config->get('url'),
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('demoformation.blocksettings');
    $config->set('title', $form_state->getValue('title'))
          ->set('url', $form_state->getValue('url'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
