# Installer Drupal et le configurer

Cet exercice a pour but d'installer Drupal sur votre machine, et de créer la configuration nécessaire pour la suite des exercices.

## Pré-requis

* Avoir un serveur web (apache, nginx, autre) installé et configuré
* Avoir la version de PHP installée et fonctionnelle correspondant à la version de Drupal que vous souhaitez installé, voir ici : https://www.drupal.org/docs/system-requirements 
* Avoir une base de données installée et configurée 
* Installer composer : https://getcomposer.org/download/ 

## Installation de Drupal

* Télécharger Drupal avec composer :
```
composer create-project drupal/recommended-project:8.9.10 mydir
```
* Dans le dossier lancer la commande d'installation pour récupérer l'ensemble des composants du coeur :
```
composer install
```
* Ouvrir votre navigateur et se rendre à l'adresse de votre site :
http://localhost/mydir
* A partir du dossier web, suivre les étapes d'installation

## Création de la configuration

* Créer une taxomie Port d'attachement avec les champs :
* * Nom du port (text)
* * Ville (code postal + nom de la ville)
* * Pays (liste de Pays)
* Créer un type de contenu dans l'UI appeler Boat
* Ajouter les champs suivants :
* * Nom du bateau (text)
* * Longueur du bateau (number)
* * Largeur du bateau (number)
* * Hauteur (number)
* * Prix (number)
* * Photos (images)
* * Port d'attachement (taxonomie libre)
* * Propriétaire (utilisateur)
* Ajouter aux utilisateurs un champ Nom et un champ prenom (les deux sont des textes)

## Installation des outils nécessaires :
* Installer la drupal console : 
https://drupalconsole.com/docs/fr/getting/composer
* Installer drush (optionnel):
https://www.drush.org/install/ 
