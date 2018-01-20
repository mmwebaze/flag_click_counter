<?php

namespace Drupal\flag_click_counter\Controller;


use Drupal\Core\Render\RendererInterface;
use Drupal\flag\Controller\ActionLinkController;
use Drupal\flag\FlagInterface;
use Drupal\flag\FlagServiceInterface;
use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FlagClickCounterController extends ActionLinkController {
    protected $flagClickCounterServive;

    public function __construct(FlagClickCounterServiceInterface $flagClickCounterServive, FlagServiceInterface $flag, RendererInterface $renderer){
        parent::__construct($flag, $renderer);
        $this->flagClickCounterServive = $flagClickCounterServive;
    }
    /**
     * {@inheritdoc}
     */
    public function flag(FlagInterface $flag, $entity_id, Request $request) {
        drupal_set_message('FLag click counter');

        return parent::flag($flag, $entity_id, $request);
    }
    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('flag_click_counter.service'),
            $container->get('flag'),
            $container->get('renderer')
        );
    }
}