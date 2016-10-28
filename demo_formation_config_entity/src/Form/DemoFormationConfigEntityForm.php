<?php
namespace Drupal\demo_formation_config_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DemoFormationConfigEntityForm
 *
 * Form class for adding/editing demo_formation_config_entity config entities.
 */
class DemoFormationConfigEntityForm extends EntityForm {

   /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);

    $demo_formation_config_entity = $this->entity;

    // Change page title for the edit operation
    if ($this->operation == 'edit') {
      $form['#title'] = $this->t('Edit demo_formation_config_entity: @name', array('@name' => $demo_formation_config_entity->label));
    }

    // The name.
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 255,
      '#default_value' => $demo_formation_config_entity->label,
      '#description' => $this->t("DemoFormationConfigEntity name."),
      '#required' => TRUE,
    );

    // The unique machine name of the demo_formation_config_entity.
    $form['id'] = array(
      '#type' => 'machine_name',
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#default_value' => $demo_formation_config_entity->id,
      '#disabled' => !$demo_formation_config_entity->isNew(),
      '#machine_name' => array(
        'source' => array('name'),
        'exists' => 'demo_formation_config_entity_load'
      ),
    );

    // The key.
    $form['key'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Key'),
      '#maxlength' => 255,
      '#default_value' => $demo_formation_config_entity->key,
      '#description' => $this->t("API Key."),
      '#required' => TRUE,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form,
  FormStateInterface $form_state) {

    $demo_formation_config_entity = $this->entity;

    $status = $demo_formation_config_entity->save();

    if ($status) {
      // Setting the success message.
      drupal_set_message($this->t('Saved the demo_formation_config_entity: @label.', array(
        '@label' => $demo_formation_config_entity->label,
      )));
    }
    else {
      drupal_set_message($this->t('The @label demo_formation_config_entity was not saved.', array(
        '@label' => $demo_formation_config_entity->name,
      )));
    }
    $url = new Url('demo_formation_config_entity.list');
    $form_state['redirect'] = $url->toString();

  }

}
