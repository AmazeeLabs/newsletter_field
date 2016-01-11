<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Newsletter\Annotation\Newsletter
 */

namespace Drupal\newsletter_field\Newsletter\Annotation;


use Drupal\Component\Annotation\Plugin;

/**
 * @Annotation
 */
class Newsletter extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the newsletter.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label = '';

}
