<?

namespace Drupal\demmitv_drupal_module\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\demmitv_drupal_module\Controller\Views;

/**
 * Locations controller.
**/
class UsersController extends ControllerBase {

  /**
   * Dashboard
  **/
  public function dashboard() {

    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    // var_dump($user);

    $view = \Drupal\views\Views::getView('my_sketches');
    // var_dump( $view );
    $view->setDisplay('default');
    $view->setArguments(array($user->id()));
    $view->preExecute();
    $view->execute();
    $rendered = $view->render();
    $output = \Drupal::service('renderer')->render($rendered);

    return [
      ['#markup' => $output]
    ];

    // return [
    //   '#type' => 'view',
    //   '#name' => 'all_sketches',
    //   '#display_id' => 'block',
    // ];

    // return [
    //   '#theme'    => 'users_dashboard',
    //   // '#location' => $location,
    //   // '#request'  => $request,
    // ];
  }

  /**
   * show()
  **/
  public function show( $location_slug, Request $request ) {

    $location = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
      'type' => 'location',
      'field_slug' => $location_slug,
    ]);
    $location = $location[ array_keys($location)[0] ];

    // var_dump($location->title->value);

    return [
      '#theme'    => 'ish_locations_show',
      '#location' => $location,
      '#request'  => $request,
    ];
  }

}
