<?php

namespace Drupal\flag_click_counter\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class FlagClickCounterRouteSubscriber.
 *
 * Listens to the dynamic route events.
 */
class FlagClickCounterRouteSubscriber extends RouteSubscriberBase {
    /**
     * {@inheritdoc}
     */
    protected function alterRoutes(RouteCollection $collection) {
        if ($route = $collection->get('flag.action_link_flag')) {
            $route->setDefaults(array(
                '_controller' => '\Drupal\flag_click_counter\Controller\FlagClickCounterController::flag',
            ));
        }
    }
}