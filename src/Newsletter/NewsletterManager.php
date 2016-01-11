<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Newsletter\NewsletterManager
 */

namespace Drupal\newsletter_field\Newsletter;


use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class NewsletterManager extends DefaultPluginManager implements NewsletterManagerInterface {

  /**
   * Constructs a new \Drupal\newsletter_field\Newsletter\NewsletterManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Newsletter', $namespaces, $module_handler, 'Drupal\newsletter_field\Newsletter\NewsletterPluginInterface', 'Drupal\newsletter_field\Newsletter\Annotation\Newsletter');

    // Do we need this alter?
    $this->alterInfo('newsletter_service');

    $this->setCacheBackend($cache_backend, 'newsletter_plugins');
  }

}
