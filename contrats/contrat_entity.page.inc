<?php

/**
 * @file
 * Contains contrat_entity.page.inc.
 *
 * Page callback for Contrat entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Contrat entity templates.
 *
 * Default template: contrat_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_contrat_entity(array &$variables) {
  // Fetch ContratEntity Entity Object.
  $contrat_entity = $variables['elements']['#contrat_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
