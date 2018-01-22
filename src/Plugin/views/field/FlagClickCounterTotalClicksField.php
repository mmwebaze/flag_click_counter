<?php
namespace Drupal\flag_click_counter\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @ViewsField("flag_click_counter_total_clicks")
 */
class FlagClickCounterTotalClicksField extends FieldPluginBase{
    /**
     * {@inheritdoc}
     */
    protected function defineOptions(){
        $options = parent::defineOptions();
        $options['flag_click_counter'] = array('default' => 'flag_click_counter');
        return $options;
    }
    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state) {
        //$form['relationship']['#default_value'] = $this->options['relationship'];

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
    public function render(ResultRow $values) {}

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('flag_click_counter.service')
        );
    }
}