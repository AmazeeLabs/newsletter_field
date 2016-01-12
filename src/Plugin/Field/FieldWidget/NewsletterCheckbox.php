<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Plugin\Field\FieldWidget\NewsletterCheckbox
 */

namespace Drupal\newsletter_field\Plugin\Field\FieldWidget;
use Drupal\Core\Field\Plugin\Field\FieldWidget\BooleanCheckboxWidget;


/**
 * Plugin implementation of the 'newsletter_checkbox' widget.
 *
 * Currently it just extends the boolean checkbox, but we may need some other
 * settings. If not, we can just remove it.
 *
 * @FieldWidget(
 *   id = "newsletter_checkbox",
 *   label = @Translation("Newsletter checkbox"),
 *   field_types = {
 *     "newsletter"
 *   },
 *   multiple_values = FALSE
 * )
 */
class NewsletterCheckbox extends BooleanCheckboxWidget {

}
