<?php

namespace Drupal\demo_form_formation\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\demo_form_formation\Event\DemoSubmitEvent;

class CustomContactForm extends FormBase
{
  public function getFormId(){
    return 'custom-contact_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state){
    $form['title'] = array(
      '#type' => 'textfield',
    );
    $form['message'] = array(
      '#type' => 'textarea'
    );
    $form['email'] = array(
      '#type' => 'email'
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Envoyer'),
      '#button_type' => 'primary'
    );

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state){
    $current_user = \Drupal::currentUser();
    $expediteur = $current_user->getEmail();
    $destinataire = $form_state->getValue('email');
    $module = 'demo_form_formation';
    $subject = $form_state->getValue('title');
    $content = $form_state->getValue('message');

    \Drupal::service('mon_super_service_demo')->sendMailAndLog($expediteur, $destinataire, $module, $subject, $content);
    $event_submit = new DemoSubmitEvent();
    $event_submit->setSubject($subject);

    $dispatcher = \Drupal::service('event_dispatcher');
    $dispatcher->dispatch('submit_set_message', $event_submit);
  }
}
