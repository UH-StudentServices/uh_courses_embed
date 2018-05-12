<?php

namespace Drupal\uh_courses_embed\Plugin\Field\FieldFormatter;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
class CoursesEmbed extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * Language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructs a CoursesEmbed object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   Language manager containing required information for embedding with
   *   proper language codes.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, LanguageManagerInterface $language_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('language_manager')
    );
  }

  /**
   * @inheritdoc
   */
  public static function defaultSettings() {
    $settings = parent::defaultSettings();
    $settings['language_attribute'] = 'current';
    return $settings;
  }

  /**
   * @inheritdoc
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      // We don't support yet multiple values
      if ($delta > 0) {
        break;
      }
      $element[$delta]['#markup'] = '<div id="course-app-root" data-organization="' . $item->value . '" data-language="' . $this->languageAttribute($item, $langcode) . '"></div>';
    }
    $element['#attached']['library'] = 'uh_courses_embed/courses_app';

    return $element;
  }

  /**
   * @inheritdoc
   */
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

  /**
   * @inheritdoc
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = new FormattableMarkup('<strong>@label: </strong>@value', ['@label' => $this->t('Language attribute'), '@value' => $this->languageLabel($this->getSetting('language_attribute'))]);
    return $summary;
  }

  /**
   * Returns the language code for the item that will be used as language
   * attribute value.
   *
   * @param $item
   * @param $langcode
   *
   * @return string
   *   Language code (ISO 639-1 standard).
   */
  protected function languageAttribute($item, $langcode) {
    $value = '';
    switch ($this->getSetting('language_attribute')) {
      case 'current':
        $value = $this->languageManager->getCurrentLanguage()->getId();
        break;
      case 'default':
        $value = $this->languageManager->getDefaultLanguage()->getId();
        break;
      case 'entity':
        $value = $langcode;
        break;
    }

    // If unsupported language code is used, then fallback to current language.
    if (is_null($this->languageManager->getLanguage($value))) {
      return $this->languageManager->getCurrentLanguage()->getId();
    }

    return $value;
  }

  /**
   * Returns set of language labels defining the source of mounting language.
   * @return array
   */
  protected function languageLabels() {
    return [
      'current' => $this->t('Current language'),
      'default' => $this->t('Default site language'),
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
