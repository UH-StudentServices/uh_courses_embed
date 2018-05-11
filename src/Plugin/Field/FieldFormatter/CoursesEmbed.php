<?php

namespace Drupal\uh_courses_embed\Plugin\Field\FieldFormatter;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FormatterInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the courses embed field formatter.
 *
 * @FieldFormatter(
 *   id = "uh_courses_embed",
 *   label = @Translation("Courses Embed"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class CoursesEmbed extends FormatterBase implements FormatterInterface {

  public static function defaultSettings() {
    $settings = parent::defaultSettings();
    $settings['language_attribute'] = 'current';
    return $settings;
  }

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      // We don't support yet multiple values
      if ($delta > 0) {
        break;
      }
      $element[$delta]['#markup'] = '<div id="course-app-root" data-organization="' . $item->value . '"></div>';
    }
    $element['#attached']['library'] = 'uh_courses_embed/courses_app';

    return $element;
  }

  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    $form['language_attribute'] = array(
      '#title' => $this->t('Language attribute'),
      '#type' => 'select',
      '#options' => $this->languageLabels(),
      '#default_value' => $this->getSetting('language_attribute'),
      '#description' => $this->t('Select where language attribute value is going to be passed from.'),
      '#required' => TRUE,
    );
    return $form;
  }

  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = new FormattableMarkup('<strong>@label: </strong>@value', ['@label' => $this->t('Language attribute'), '@value' => $this->languageLabel($this->getSetting('language_attribute'))]);
    return $summary;
  }

  /**
   * Returns set of language labels defining the source of mounting language.
   * @return array
   */
  protected function languageLabels() {
    return [
      'current' => $this->t('Current language'),
      'default' => $this->t('Default site language'),
      'field' => $this->t('Field language'),
      'entity' => $this->t('Entity language'),
    ];
  }

  /**
   * Returns the label for given machine-readable value.
   *
   * @param string $value
   *   Machine readable format of the label value.
   *
   * @return mixed
   *   Returns the human readable value (label).
   */
  protected function languageLabel($value = 'current') {
    $values = $this->languageLabels();
    if (!empty($values[$value])) {
      return $values[$value];
    }
    return $values['current'];
  }
}
