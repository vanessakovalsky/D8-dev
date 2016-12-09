<?php
/**
 * @file
 * Contains \Drupal\demo_formation_config_entity\Form\DemoFormationConfigEntityDeleteForm.
 */
namespace Drupal\demo_formation_config_entity\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Url;

/**
 * Form that handles the removal of demo_formation_config_entity entities.
 */
class DemoFormationConfigEntityDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete this demo_formation_config_entity: @label?', array('@label' => $this->entity->label));
  }
  /**
   * {@inheritdoc}
   */
  public function getCancelRoute() {
    return new Url('demo_formation_config_entity.list');
  }
  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }
  /**
   * {@inheritdoc}
   */
  public function submit(array $form, array &$form_state) {

    // Delete and set message
    $this->entity->delete();
    drupal_set_message($this->t('The demo_formation_config_entity @label has been deleted.', array('@label' => $this->entity->name)));
    $form_state['redirect_route'] = $this->getCancelRoute();

  }
}
