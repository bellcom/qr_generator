<?php

/**
 * @file
 * Contains qr_generator.page.inc.
 *
 * Page callback for QR Code entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for QR Code templates.
 *
 * Default template: qr_generator.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_qr_generator(array &$variables) {
  // Fetch QRGenerator Entity Object.
  $qr_generator = $variables['elements']['#qr_generator'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
