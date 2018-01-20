<?php

namespace Drupal\flag_click_counter\Controller;


use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\flag\Controller\ActionLinkController;
use Drupal\flag\FlagInterface;
use Drupal\flag\FlagServiceInterface;
use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FlagClickCounterController extends ActionLinkController {
    protected $flagClickCounterServive;
    protected $currentUser;

    public function __construct(FlagClickCounterServiceInterface $flagClickCounterServive, AccountInterface $current_user, FlagServiceInterface $flag, RendererInterface $renderer){
        parent::__construct($flag, $renderer);
        $this->flagClickCounterServive = $flagClickCounterServive;
        $this->currentUser = $current_user;
    }
    /**
     * {@inheritdoc}
     */
    public function flag(FlagInterface $flag, $entity_id, Request $request) {

        $this->flagClickCounterServive->flag($flag->id(), $entity_id, $request, $this->currentUser->id());

        return parent::flag($flag, $entity_id, $request);
    }
    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('flag_click_counter.service'),
            $container->get('current_user'),
            $container->get('flag'),
            $container->get('renderer')
        );
    }
}