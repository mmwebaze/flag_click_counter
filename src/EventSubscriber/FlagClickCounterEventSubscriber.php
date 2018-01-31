<?php
namespace Drupal\flag_click_counter\EventSubscriber;

use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FlagClickCounterEventSubscriber implements EventSubscriberInterface {

    protected $flagClickCounterService;

    public function __construct(FlagClickCounterServiceInterface $flagClickCounterService) {
        $this->flagClickCounterService = $flagClickCounterService;
    }

    public function flag(GetResponseEvent $event){
        $request = $event->getRequest();
        $path = $event->getRequest()->getPathInfo();
        $path_array = explode('/', $path);

        if (isset($path_array['2']) && $path_array['2'] == 'flag') {
            $flag_id = $path_array[3];
            $query = $request->query->get('destination');
            $entityDetails = explode('/', $query);
            $this->flagClickCounterService->countFlag($flag_id, $entityDetails);
          //  drupal_set_message($query);
        }

    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $events[KernelEvents::REQUEST][] = ['flag'];
        return $events;
    }
}