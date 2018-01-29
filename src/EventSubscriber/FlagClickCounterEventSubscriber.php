<?php
namespace Drupal\flag_click_counter\EventSubscriber;

use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
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
        //drupal_set_message(json_encode(explode('/',$path)));
        $path_array = explode('/',$path);

        if ($path_array['2'] == 'flag'){
            $flag_id = $path_array[3];
            $query = $request->query->get('destination');
            $entityDetails = explode('/', $query);
            $this->flagClickCounterService->countFlag($flag_id, $entityDetails);



            drupal_set_message($query);
        }
        else{
            drupal_set_message('do nothing this is unflag');
        }

        //http://learning.dd:8083/flag/flag/dhis2_vm/22?destination=node/22&token=bnTD7MY_6TQCnbBYdNfunmX4za1aGgHjZQ5dbwKI1V0


    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $events[KernelEvents::REQUEST][] = ['flag'];
        return $events;
    }
}