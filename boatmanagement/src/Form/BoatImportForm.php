<?php

namespace Drupal\boatmanagement\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;


/**
 * Class BoatImportForm.
 *
 * @package Drupal\boatmanagement\Form
 */
class BoatImportForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'boat_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $validators = array(
      'file_validate_extensions' => array('csv'),
      'file_validate_size' => array(file_upload_max_size()),
    );
    $form['fichier_csv'] = [
      '#type' => 'managed_file',
      '#title' => t('Choose  File'),
      '#upload_location' => 'public://tmp',
      '#description' => t('upload file'),
      '#states' => array(
        'visible' => array(
          ':input[name="File_type"]' => array('value' => t('Upload Your File')),
        ),
      ),
      '#upload_validators' => $validators,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $file_id = $form_state->getValue('fichier_csv');
    $file = File::load($file_id[0]);
    $uri = $file->getFileUri();
    $line_max = 1000;
    $handle = @fopen($uri, "r");
    // start count of imports for this upload
    $send_counter = 0;
    while ($row = fgetcsv($handle, $line_max, ',')) {
      // $row is an array of elements in each row
      // e.g. if the first column is the email address of the user, try something like
      $row_data = explode(';', $row[0]);
      $boat = Node::create([
        'uid' => 1,
        'revision' => 0,
        'status' => TRUE,
        'promote' => 0,
        'created' => time(),
        'langcode' => 'fr',
        'title' => $row_data[0],
        'type' => 'bateau'
      ]);
      $boat->set('body', $row_data[1]);

      $boat->save();
    }
      drupal_set_message('Les bateaux ont été créé');
  }
}
