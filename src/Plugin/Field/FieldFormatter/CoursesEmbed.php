<?php

namespace Drupal\uh_courses_embed\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FormatterInterface;

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
}
