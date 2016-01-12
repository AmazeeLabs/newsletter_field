<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Newsletter\NewsletterBase
 */

namespace Drupal\newsletter_field\Newsletter;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The base class for all the newsletter plugins.
 */
abstract class NewsletterBase implements NewsletterPluginInterface, ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static();
  }
}
