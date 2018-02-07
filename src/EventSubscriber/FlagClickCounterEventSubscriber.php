<?php

namespace Drupal\flag_click_counter\EventSubscriber;

use Drupal\flag\Controller\ActionLinkController;
use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FlagClickCounterEventSubscriber implements EventSubscriberInterface
{

    protected $flagClickCounterService;

    public function __construct(FlagClickCounterServiceInterface $flagClickCounterService)
    {
        $this->flagClickCounterService = $flagClickCounterService;
    }

    public function linkFlag(FilterControllerEvent $event)
    {

        $closure = $event->getController();
        $reflection = new \ReflectionFunction($closure);
        $parameters = $reflection->getStaticVariables();

        if ($parameters['controller'][0] instanceof ActionLinkController && $parameters['controller'][1] == 'flag') {
            $entityDetails = [];
            $flaggableEntityType = $parameters['arguments'][0]->getFlaggableEntityTypeId();

            $flaggableEntityTypeId = $parameters['arguments'][1];
            array_push($entityDetails, $flaggableEntityType, $flaggableEntityTypeId);

            $flag_id = $parameters['arguments'][0]->id();

            if ($this->flagClickCounterService->isFlagCountable($flag_id)) {
                $this->flagClickCounterService->countFlag($flag_id, $entityDetails);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        $events[KernelEvents::CONTROLLER][] = ['linkFlag'];
        return $events;
    }
}