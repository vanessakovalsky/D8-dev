# Exercice 3 : Création d'un bloc et travail avec les BDD

Cet exercice a pour objectifs :
* De créer un bloc custom et de choisir où l'afficher
* De calculer l'aire d'un bateau à partir d'informations enregistrées dans les champs du contenu

## Créer un bloc custom qui ne s'affichera que sur les contenus de type Bateau

* Nous allons utilier la console pour générer un type de bloc 
```
vendor/bin/drupal generate:plugin:block
```
* Une fois le bloc crée afficher le depuis l'interface sur les noeuds de type bateau dans la région de votre choix (via l'interface d'administration)
  
## Calcul d'aire à partir des données du champs

* Le bloc custom que nous avons créé contiendra le calcul de l'aire du bateau (en prenant l'hypothèse que le bateau est rectangulaire, donc le calcul est largeur * longueur)
* Pour cela nous utilisons le service entity.type.manager qui nous permet d'aller récupérer des informations sur une entité et ainsi d'obtenir la valeur des champs de l'entité
* Voici le code de la fonction build qui renvoit le résultat du calcul
```
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
      $node = $this->requestStack->getCurrentRequest()->attributes->get('node');
      $largeur = $node->get('field_largeur')->getValue()[0]['value'];
      $longueur = $node->get('field_longueur')->getValue()[0]['value'];
      $aire = $longueur * $largeur;
      $build['calcul_aire_block']['#markup'] = 'L\'aire du bateau est égale à :'.$aire;
    return $build;
  }
```
* Afin d'utliser les deux services (request_stack permettant d'accèder à la requête et ses paramètres et entity_type.manager), nous devons les injecter dans le constructeur de notre plugin block
 ```php
  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;
  /**
   * Symfony\Component\HttpFoundation\RequestStack definition.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;
  /**
   * Constructs a new CalculAireBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
	RequestStack $request_stack
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->requestStack = $request_stack;
  }
 ```
