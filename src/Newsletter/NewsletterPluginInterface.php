<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Newsletter\NewsletterPluginInterface
 */

namespace Drupal\newsletter_field\Newsletter;

/**
 * The interface for all the Newsletter plugins.
 */
interface NewsletterPluginInterface {

  /**
   * Subscribes a mail to a list id. It also sends additional data, like first
   * and last name, etc.
   *
   * @param string $mail
   *  The mail to subscribe
   *
   * @param string $list_id
   *  The id of the list to which the mail will be subscribed.
   *
   * @param array $additional_data
   *  An array with any additional data to be sent to the newsletter service.
   */
  public function subscribe($mail, $list_id = '', array $additional_data = []);
}
