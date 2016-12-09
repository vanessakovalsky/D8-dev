<?php
namespace Drupal\demoformation\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\ResultRow;

/**
 * @ViewsField("random_field")
 *
*/

class RandomField extends FieldPluginBase{
  public function query(){

  }

  protected function defineOptions(){
    $options = parent::defineOptions();
    $options['random'] = array('default' => '42');
    return $options;
  }

    public function buildOptionsForm(&$form, FormStateInterface $form_state){
      $form['random'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Valeur du random'),
        '#default_value' => $this->options['random'],
      );
      parent::buildOptionsForm($form, $form_state);
    }

    public function render(ResultRow $values){
      $random = rand(0, $this->options['random']);
      return $random;
    }
}
