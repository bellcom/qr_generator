<?php

namespace Drupal\qr_generator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends ControllerBase {
	public function custom_redirect(Request $request) {
		$incoming_url = $request->get('incoming_url');

    $query = \Drupal::entityQuery('qr_generator')
      ->condition('status', 1)
      ->condition('incoming_url__uri', 'internal:/' . $incoming_url);

    $entity_id = $query->execute();

    $entity = entity_load('qr_generator', $entity_id[1]);

    $entity->newVisit();
    $entity->save();

		return new TrustedRedirectResponse($entity->getOutgoingURL()->getUrl()->toString());
	}
}
