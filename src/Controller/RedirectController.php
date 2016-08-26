<?php

namespace Drupal\qr_generator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use \Drupal\qr_generator\Entity\QRGenerator;

class RedirectController extends ControllerBase {
	public function custom_redirect(Request $request) {
    $id = QRGenerator::getIDByIncomingURL($request->get('incoming_url'));

    $entity = QRGenerator::load($id);
    $entity->increaseURLRedirectCount($entity->id());

    return $entity->redirect();
	}
}
