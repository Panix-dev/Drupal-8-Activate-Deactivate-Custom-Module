<?php

namespace Drupal\activate_deactivate\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ActivateDeactivateController {

    public function action(Request $request) {

      $current_id = $request->query->get('current_id');
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($current_id);
      // $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

      // Check if it is a node
      if ($node instanceof \Drupal\node\NodeInterface) {
        // We also have the node object right here
        $nid = $node->id();

        if ($node->isPublished()) {
          $node->setUnpublished();
          $node->save();
          $response = 'u';
        }
        else {
          $node->setPublished();
          $node->save();
          $response = 'p';
        }
      } else {
        $response = "error";
      }

      return new JsonResponse($response);

    }

}