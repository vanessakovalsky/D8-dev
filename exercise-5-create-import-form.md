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


- Ajouter les contenus bateau à partir du fichier