<?php

namespace Drupal\qr_generator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class QRDownloadController extends ControllerBase {
  public function download(Request $request) {

    $img_not_found = array(
      'data' => array('#markup' => t('Image not found!'))
    );

    $tid = $request->get('tid');
    $qr_img = File::load($tid);

    if (!$qr_img) {
      return $img_not_found;
    }

    $file_uri = $qr_img->getFileUri();
    $file_base = \Drupal::service('file_system')->basename($file_uri);
    $file_path = \Drupal::service('file_system')->realpath($file_uri);

    if (file_exists($file_path)) {
      header('Cache-Control: private');
      header('Content-Type: application/stream');
      header('Content-Length: ' . $qr_img->getSize());
      header('Content-Disposition: attachment; filename=' . $file_base);

      readfile($file_path);
      exit();
    } else {
      return $img_not_found;
    }
  }
}
