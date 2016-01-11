<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Newsletter\NewsletterPluginInterface
 */

namespace Drupal\newsletter_field\Newsletter;


interface NewsletterPluginInterface {

  /**
   * Subscribes a mail.
   *
   * This is ajust a placeholder, it will change for sure.
   */
  public function subscribe($mail, array $additional_data = []);
}
