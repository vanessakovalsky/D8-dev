# Exercice 5 : création d'un formulaire d'import

Cet exercice a pour objectifs :
* de créer un formulaire d'import à partir d'un fichier plat
* de créer des noeuds depuis l'API lors de l'import

## Création du formulaire 

* Nous commençons par générer le formulaire vide avec la commande de la console drupal suivante :
```
vendor/bin/drupal generate:form
```
* Attention lors de la réponse aux questions penser à mettre yes sur la question pour le service container (nous allons en avoir besoin pour créer les noeuds par la suite)
* le nom du service est entity.manager
* Pour les champs, nous ajoutons un seul champ de type managed_file 
* Puis nous générons les fichiers.
* Ouvrir le fichier de formulaire et regarder comment est composé le formulaire.
* Il est composé de 5 fonctions :
* * create : permet l'import des services depuis le gestionnaire de service
* * getFormId : renvoit l'identifiant unique du formulaire
* * buildForm : contient les différents champs qui compose votre formulaire
* * validateForm : valide le formulaire lorsqu'il est soumis
* * submitForm : traite le formulaire lorsqu'il a été soumis et que la validation est passée.

* Afin de limiter les fichiers qui peuvent être envoyé on va rajouter des valideurs sur notre champ fichier 
```
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
```
* Ici on déclare les valideurs avec le type de fichier et la taille et on les ajoute dans le tableau de déclaration du champs. Les informations relatives aux options disponibles pour chaque champs sont ici :
https://api.drupal.org/api/drupal/elements/8.9.x 

* Aller à l'URL du formulaire pour vérifier que celui-ci s'affiche correctement


## Créer des noeuds depuis le fichiers importé

* Dans la fonction submit form, nous récupérons et ouvrons le fichier CSV 
* Puis nous créons un noeud pour chaque nouvelle ligne
```
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
      $boat = Node::create([
        'uid' => 1,
        'revision' => 0,
        'status' => TRUE,
        'promote' => 0,
        'created' => time(),
        'langcode' => 'fr',
        'type' => 'bateau'
      ]);
      $boat->setTitle($row_data[0]);
      $boat->set('field_longueur', $row_data[1]);
      $boat->set('field_largeur', $row_data[2]);
      $boat->set('field_hauteur', $row_data[3]);
      $boat->set('field_prix', $row_data[4]);
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
        $boat->field_port->target_id = $port_attache->id();
      }
      $boat->save();
    }
      drupal_set_message('Les bateaux ont été créé');

  }
```
* on vérifie si le terme de taxonomie existe, mais pas le bateau.
* Mettre à jour le code pour vérifier si le bateau exite et le mettre à jour s'il existe plutôt que de le recréer 
* Ajouter également la création d'un utilisateur si l'utilisateur propriétaire présent dans le fichier n'existe pas.
* Utilisez le fichier bateaux_a_importer.csv à la racine du dépôt git pour tester votre formulaire 

-> Félicitation vous savez créer un formulaire et créer des noeuds ou les mettre à jour via l'API des entités.