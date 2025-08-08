<?php

namespace Drupal\appointment_date_prepopulate\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'plain_text_date' widget.
 *
 * @FieldWidget(
 *   id = "plain_text_date",
 *   label = @Translation("Plain Text Date"),
 *   field_types = {
 *     "datetime"
 *   }
 * )
 */
class PlainTextDateWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // Get the current value or default to an empty string.
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';

    // Define the text input field.
    $element['value'] = [
      '#type' => 'textfield',
      '#title' => t('Appointment Date'),
      '#default_value' => $value,
      '#description' => t('Enter the appointment date in the format YYYY-MM-DD.'),
      '#size' => 20,
      '#maxlength' => 10,
      '#required' => TRUE,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function validate(array &$element, FormStateInterface $form_state, array &$complete_form, FieldItemListInterface $items, $delta) {
    $value = $form_state->getValue(['field_appointment_date', $delta, 'value']);

    // Validate the date format (YYYY-MM-DD).
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
      $form_state->setError($element, t('Please enter the date in the format YYYY-MM-DD.'));
    } else {
      // Optionally, check if the date is a valid date.
      $date_parts = explode('-', $value);
      if (!checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
        $form_state->setError($element, t('The date you entered is not a valid date.'));
      }
    }
  }
}
