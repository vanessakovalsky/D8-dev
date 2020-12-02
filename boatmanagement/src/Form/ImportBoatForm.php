<?php

namespace Drupal\boatmanagement\Form;

use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Class ImportBoatForm.
 */
class ImportBoatForm extends FormBase {

  /**
   * Drupal\Core\Entity\EntityManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;
  /**
   * Constructs a new ImportBoatForm object.
   */
  public function __construct(
    EntityManagerInterface $entity_manager
  ) {
    $this->entityManager = $entity_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'import_boat_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $validators = array(
      'file_validate_extensions' => array('csv'),
      'file_validate_size' => array(file_upload_max_size()),
    );
    $form['fichier_csv_import'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Fichier CSV Import'),
      '#weight' => '0',
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
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $file_id = $form_state->getValue('fichier_csv_import');
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
      if(isset($row_data[0]) && !empty($row_data[0]) ) {
        $boat_value = $this->entityManager->getStorage('node')->loadByProperties(['title'=> $row_data[0]]);
      }
      if (isset($boat_value) && !empty($boat_value)) {
          $boat = reset($boat_value);
      }
      else {
        $boat = Node::create([
          'uid' => 1,
          'revision' => 0,
          'status' => true,
          'promote' => 0,
          'created' => time(),
          'langcode' => 'en',
          'type' => 'bateau'
        ]);
      }
      $boat->setTitle($row_data[0]);
      $boat->set('field_longueur', [$row_data[1]]);
      $boat->set('field_largeur', [$row_data[2]]);
      $boat->set('field_hauteur', [$row_data[3]]);
      $boat->set('field_prix', [$row_data[4]]);

      //On vérifie si le terme de taxonomie existe
      if(!empty($row_data[5])){
        $port = $row_data[5];
        $term = $this->entityManager->getStorage('taxonomy_term')->loadByProperties(['name' => $port]);
        if(isset($term) && !empty($term)){
          //On rattache le terme au champs du bateau
          $port_attache = reset($term);
        }
        else {
          //On cree le terme de taxo
          $port_attache = Term::create([
            'name' => $port,
            'vid' => 'ports',
          ])->save();
        }
        $boat->field_port->target_id = $port_attache;
      }

      $boat->save();
    }
    \Drupal::messenger()->addMessage(t('Les bateaux ont été créés.'), 'info');
  }

}
