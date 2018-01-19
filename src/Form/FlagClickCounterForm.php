<?php

namespace Drupal\flag_click_counter\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Flag click counter edit forms.
 *
 * @ingroup flag_click_counter
 */
class FlagClickCounterForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\flag_click_counter\Entity\FlagClickCounter */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Flag click counter.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Flag click counter.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.flag_click_counter.canonical', ['flag_click_counter' => $entity->id()]);
  }

}
