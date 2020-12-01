# Exercise 1 : Déclaration d'un module et gestion de la configuration

Cet exercice a pour objectifs de :
* Créer un premier module
* Exporter la configuration dans le module 

## Créer le module

* Créer un module appeler BoatManagement à l'aide de la console :
```
drupal generate:module
```
* Répondre aux questions posées pour créer le module
* Dans quel dossier s'est créer le module ?
* Quels sont les fichiers qui le compose ?
* Votre module est t'il détécté par l'interface d'admnistration de Drupal ?


## Exporter la configuration 
* Exporter la configuration du type de contenu + de la taxonomie + les champs utilisateurs(l'ensemble des fichiers + les champs)
* Mettre dans le module dans un dossier config/install l'ensemble des fichiers de configurations
/!\ Prendre soin d'enlever dans les fichiers YAML les uuid présents générés par l'UI
