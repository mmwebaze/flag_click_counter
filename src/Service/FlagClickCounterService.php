<?php

namespace Drupal\flag_click_counter\Service;


use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\flag\FlagService;
use Symfony\Component\HttpFoundation\Request;

class FlagClickCounterService implements FlagClickCounterServiceInterface {
    protected $flagService;
    protected $entityTypeManager;
    protected $currentUser;
    protected $connection;

    /**
     * Constructs a new FlagClickCounterService object.
     */
    public function __construct(FlagService $flag, AccountInterface $current_user,
                                EntityTypeManagerInterface $entity_type_manager, Connection $connection) {
        $this->flagService = $flag;
        $this->currentUser = $current_user;
        $this->entityTypeManager = $entity_type_manager;
        $this->connection = $connection;
    }
    public function flag($flag, $entity, Request $request, array $entities){

    }
}