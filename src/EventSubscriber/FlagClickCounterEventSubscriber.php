<?php
namespace Drupal\flag_click_counter\EventSubscriber;

use Drupal\flag\Controller\ActionLinkController;
use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FlagClickCounterEventSubscriber implements EventSubscriberInterface{

    protected $flagClickCounterService;
    public function __construct(FlagClickCounterServiceInterface $flagClickCounterService){
        $this->flagClickCounterService = $flagClickCounterService;
    }

    public function flag(GetResponseEvent $event){
        $request = $event->getRequest();
        $path = $event->getRequest()->getPathInfo();
        $path_array = explode('/',$path);

        if ($path_array['2'] == 'flag'){
            $flag_id = $path_array[3];

            if ($this->flagClickCounterService->isFlagCountable($flag_id)){
                $query = $request->query->get('destination');
                $entityDetails = explode('/', $query);
                $this->flagClickCounterService->countFlag($flag_id, $entityDetails);
            }
        }
    }
    public function linkFlag(FilterControllerEvent $event){
        $controller = $event->getController();

        if (!is_array($controller)) {
            drupal_set_message('**Kernal event controller**');
            return;
        }

            //drupal_set_message('Kernal event controller'.$controller->name());
        if ($controller instanceof ActionLinkController){
            drupal_set_message('Kernal event controller');
        }


    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
       // $events[KernelEvents::REQUEST][] = ['flag'];
        $events[KernelEvents::CONTROLLER][] = ['linkFlag'];
        return $events;
    }
}