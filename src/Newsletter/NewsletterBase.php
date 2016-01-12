<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Newsletter\NewsletterBase
 */

namespace Drupal\newsletter_field\Newsletter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The base class for all the newsletter plugins.
 */
abstract class NewsletterBase implements NewsletterPluginInterface, ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static();
  }
}
