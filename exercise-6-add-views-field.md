# Exercice 6 : Ajouter des informations aux vues

Cet exercice a pour objectifs :
* de déclarer une vue listant mes bateaux dans l'interface
* d'ajouter un champ aire à la vue pour calculer l'aire de chaque bateau


## Créer une vue listant mes bateaux sous la forme d'une page avec l'URL /mes-bateaux
* Dans l'interface aller dans Structure > Views (Vues en français)
* Créer une vue affichant des noeuds de type bateaux, avec un affichage page de type grille.
* Utiliser les relations et les filtres contextuels pour afficher uniquement les bateaux dont l'utilisateur connecté est propriétaire
* Définir une url pour cette page et l'ajouter dans le menu principal.
* Créer un autre utilisateur et le définir comme propriétaire de certains bateaux.
* Se connecter avec ce nouvel utilisateur et vérifier que la vue affiche bien que les bateaux dont l'utilisateur est propriétaire

## Ajouter un champ aire

* Pour ajouter un champ au champ disponible dans vue, il est nécessaire de déclarer un champ pour la forme d'un plugin (comme pour le bloc).
* Pour cela nous utilisons de nouveau la console pour générer la structure :
```
vendor/bin/drupal generate:plugin:views:field 
```
* Il est alors possible de définir plusieurs champs à la fois en répondant yes à la question Do you want to add another field
* Il est possible dans le fichier généré de définir différentes options pour notre champ de vue.
* Dans notre cas, nous remplaçons seulement la fonction de rendu (render):
```
  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    // Return a random text, here you can include your custom logic.
    // Include any namespace required to call the method required to generate
    // the desired output.
    $longueur = $values->_entity->field_longueur->value;
    $largeur = $values->_entity->field_largeur->value;
    $aire = $longueur * $largeur;
    return $aire;
  }
```
* Vous pouvez maintenant (une fois le cache vidé) utilisé ce nouveau champs sur votre vue pour ajouter l'aire à chaque bateau dans votre grille.

-> Félicitation vous savez maintenant utiliser des vues avec des relations et des filtres contextuels et déclarer des nouveaux champs aux vues.