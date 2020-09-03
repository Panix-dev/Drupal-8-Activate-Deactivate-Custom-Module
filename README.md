# Drupal 8 Activate/Deactivate Custom Module

> Publishing and Unpublishing a node from the frontend using ajax.

A custom Drupal 8 module for activating and deactivating a node of content type 'listing' by adding an ajax request to a local menu task link. The link accesses a route defined in the module.routing.yml file and calls a function defined in the Controller to publish or unpublish the current node.


## Table of Contents


> Try `clicking` on each of the `anchor links` below so you can get redirected to the appropriate section.

- [Routing](#routing)
- [Permissions](#permissions)
- [Getting the current Node](#getting-the-current-node)
- [Links Tasks](#links-tasks)
- [Controller](#controller)
- [Contact Details](#contact-details)
- [Inspiration](#inspiration)


## Routing


```php
activate_deactivate.submission_url:
  path: '/activate-deactivate'
  defaults:
    _controller: '\Drupal\activate_deactivate\Controller\ActivateDeactivateController::action'
    _title: 'Our custom Activate/Deactivate functionality'
  methods: [GET]
  requirements:
    _permission: 'my_permission'
    _node_types: 'listing'
```


## Permissions


```php
// inside .yml file
my_permission:
  title: 'Allow user to activate/deactivate'
  description: 'The permissions for the custom module to allow activate/deactivate a listing from the frontend'
```


## Getting the current Node


```php
// inside hook function
$node = \Drupal::routeMatch()->getParameter('node');
// inside controller
$node = \Drupal::entityTypeManager()->getStorage('node')->load($current_id);
```


## Links Tasks


```php
//check if this is a node of the types you want to handle
if($node->bundle() == 'listing' && $user->hasPermission('my_permission')) {
	$data['tabs'][0]['activate_deactivate.submission_url'] = [
	    '#theme' => 'menu_local_task',
	    '#link' => [
	    'title' => t($linkText),
	    'url' => $url
	    ],
	    '#weight' => -1000
	];

	// The tab we're adding is dependent on a user's access to add content.
	$cacheability
	    ->addCacheTags([
	    'user.permissions',
	]);
}
```


## Controller


```php
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
```


## Contact Details


> :computer: [https://pagapiou.com](https://pagapiou.com)

> :email: [hello@pagapiou.com](mailto:hello@pagapiou.com)

> :iphone: [LinkedIn](https://www.linkedin.com/in/agapiou/)

> :iphone: [Instagram](https://www.instagram.com/panos_agapiou/)

> :iphone: [Facebook](https://www.facebook.com/panagiotis.agapiou)


## Inspiration


- **[Traversy Media](https://www.youtube.com/channel/UC29ju8bIPH5as8OGnQzwJyA)**
