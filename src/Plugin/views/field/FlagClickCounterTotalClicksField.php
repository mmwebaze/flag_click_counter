<?php
namespace Drupal\flag_click_counter\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\flag_click_counter\Service\FlagClickCounterServiceInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @ViewsField("flag_click_counter_counts")
 */
class FlagClickCounterTotalClicksField extends FieldPluginBase{
    protected $flagClickCounterService;
    public function __construct(array $configuration, $plugin_id, $plugin_definition, FlagClickCounterServiceInterface $flagClickCounterService) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->flagClickCounterService = $flagClickCounterService;
    }
    /**
     * {@inheritdoc}
     */
    protected function defineOptions(){
        $options = parent::defineOptions();

        return $options;
    }
    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state) {

        parent::buildOptionsForm($form, $form_state);
    }
    /**
     * {@inheritdoc}
     */
    public function query() {

    }
    /**
     * {@inheritdoc}
     */
    public function render(ResultRow $values) {

      $user = $this->flagClickCounterService->getEntityById($values->flagging_node_field_data_id, 'flagging');
      $count = $this->flagClickCounterService->getCount($values->nid, $user->getOwnerId());

        return $count;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('flag_click_counter.service')
        );
    }
}