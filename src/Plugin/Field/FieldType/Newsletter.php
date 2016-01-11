<?php

/**
 * @file
 *  Contains Drupal\newsletter_field\Plugin\Field\FieldType\Newsletter
 */

namespace Drupal\newsletter_field\Plugin\Field\FieldType;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\BooleanItem;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter_field\Newsletter\NewsletterManagerInterface;
use Drupal\newsletter_field\Newsletter\NewsletterPluginInterface;


/**
 * @FieldType(
 *   id = "newsletter",
 *   label = @Translation("Newsletter"),
 *   description = @Translation("An entity field containing a boolean value."),
 *   default_widget = "newsletter_checkbox",
 *   default_formatter = "boolean",
 * )
 */
class Newsletter extends BooleanItem implements FieldItemInterface {

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::fieldSettingsForm($form, $form_state);
    $element['mail_field'] = array(
      '#type' => 'textfield',
      '#title' => t('Mail field'),
      '#description' => t('Please input the field name (machine name) which is used as the e-mail for the newsletter subscription.'),
      '#required' => TRUE,
      '#default_value' => $this->getSetting('mail_field'),
    );
    $element['newsletter_fields_map'] = array(
      '#type' => 'textarea',
      '#title' => t('Newsletter fields map'),
      '#description' => t('Please input the list of fields which should be sent to the newsletter service, one per line. Each line should be formatted like <em>source_field_name</em>|<em>newsletter_field_name</em>.'),
      '#default_value' => $this->getSetting('newsletter_fields_map'),
    );
    // @todo: is it possible to inject the newsletter manager here?
    /* @var NewsletterManagerInterface $manager */
    $manager = \Drupal::getContainer()->get('plugin.manager.newsletter');
    $newsletter_definitions = $manager->getDefinitions();
    $options = array();
    foreach($newsletter_definitions as $newsletter_definition) {
      $options[$newsletter_definition['id']] = $newsletter_definition['label'];
    }

    $element['newsletter_service'] = array(
      '#type' => 'select',
      '#options' => $options,
      '#title' => t('Newsletter service'),
      '#required' => TRUE,
      '#default_value' => $this->getSetting('newsletter_service'),
      '#description' => t('Please choose which newsletter service you want to use.'),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return array(
      'mail_field' => '',
      'newsletter_fields_map' => '',
      'newsletter_service' => '',
    ) + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function postSave($update) {
    // If we want to subscribe to the newsletter, we do it now.
    // @todo: should we restrict this action to only when the entity is created?
    if ($this->value) {
      $newsletter_plugin_id = $this->getSetting('newsletter_service');
      if (!empty($newsletter_plugin_id)) {
        // Prepare the mail and the additional fields to be sent to the
        // newsletter service.
        $entity = $this->getEntity();
        $mail_key = $this->getSetting('mail_field');
        $mail = $entity->{$mail_key}->value;

        // Prepare the additional data.
        $additional_data = array();
        $newsletter_fields_map = $this->getSetting('newsletter_fields_map');
        if (!empty($newsletter_fields_map)) {
          $list = explode("\n", $newsletter_fields_map);
          $list = array_map('trim', $list);
          $list = array_filter($list, 'strlen');
          foreach ($list as $item) {
            $words = explode('|', $item);
            // $words[0] will contain our field name and $words[1] will contain
            // the corresponding newsletter field.
            if (isset($entity->{$words[0]})) {
              // @todo: handle cases when we there is a different name for the
              // value column, not just 'value'.
              $additional_data[$words[1]] = $entity->{$words[0]}->value;
            }
          }
        }

        // And finally create the newsletter plugin and subscribe the mail.
        // @todo: is it possible to inject the newsletter manager here?
        /* @var NewsletterManagerInterface $manager */
        $manager = \Drupal::getContainer()->get('plugin.manager.newsletter');

        // @todo: we have to instantiate the plugin with all the configuration.
        /* @var NewsletterPluginInterface $newsletter_plugin */
        $newsletter_plugin = $manager->createInstance($newsletter_plugin_id);

        $newsletter_plugin->subscribe($mail, $additional_data);
      }
    }
    else {
      // @todo: we could also un-subscribe here.
    }
  }
}
