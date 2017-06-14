<?php

namespace Drupal\contrats\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormInterfaceBase;
use Drupal\Core\Form\FormStateInterface;

class CalculatorForm extends FormBase {

  public function getFormId(){
    return 'custom-calculator_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['champ1'] =[
      '#type' => 'number',
      '#title' => 'Champ 1'
    ];

    $form['champ2'] =[
      '#type' => 'number',
      '#title' => 'Champ 2'
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Calculer'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

 public function validateForm(array &$form, FormStateInterface $form_state){
   if($form_state->getValue('champ1') > 5){
     $form_state->setErrorByName('champ1', t('La valeur doit être inférieure à 5'));
   }
 }

 public function submitForm(array &$form, FormStateInterface $form_state){
   $soap = new \SoapClient('http://www.dneonline.com/calculator.asmx?WSDL');

   $param = [
     'intA' => $form_state->getValue('champ1'),
     'intB' => $form_state->getValue('champ2'),
   ];

   $response = $soap->__soapCall('Add', [$param]);
   drupal_set_message('Result ' . $response->AddResult);
 }


}
