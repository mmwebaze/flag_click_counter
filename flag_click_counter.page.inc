<?php

/**
 * @file
 * Contains flag_click_counter.page.inc.
 *
 * Page callback for Flag click counter entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Flag click counter templates.
 *
 * Default template: flag_click_counter.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_flag_click_counter(array &$variables) {
  // Fetch FlagClickCounter Entity Object.
  $flag_click_counter = $variables['elements']['#flag_click_counter'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
