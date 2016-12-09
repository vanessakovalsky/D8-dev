<?php

/**
 * @file
 * Contains \Drupal\Random\Plugin\Field\FieldFormatter\RandomDefaultFormatter.
 */

namespace Drupal\demo_formation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Random_default' formatter.
 *
 * @FieldFormatter(
 *   id = "Random_default",
 *   label = @Translation("Random text"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class RandomFieldFormatter extends FormatterBase
{
public static function defaultSettings() {
  return array(
    'my_form_field' => '',
      ) + parent::defaultSettings();
  }

  public function settingsForm(array $form, FormStateInterface $form_state){
      $form = parent::settingsForm($form, $form_state);
      $form['my_form_field'] = array(
        '#type' => 'textfield',
        '#title' => t('Mon champ de settings'),
        '#description' => t('Mon champ qsfhoghlghlgfhklqgsfhkflsq'),
        '#default_value' => $this->getSetting('my_form_field')
      );
      return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $settings = $this->getSettings();

    $summary[] = t('Displays the random string.');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = array();
    $my_field = $this->getSetting('my_form_field');

    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = array(
        '#type' => 'markup',
        '#markup' => '<div class="ma-classe">'. $my_field .$item->value.'</div>',
      );
    }

    return $element;
  }
}
