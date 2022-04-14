<?php

namespace Drupal\site_location_time;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class to manage guest account creation.
 */
class GetSiteLocationTime {

  use StringTranslationTrait;

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The Site location timezone config object.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs a new OrderCompleteRegistrationSubscriber object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    $this->config = $this->configFactory->get('site_location_time.settings');
  }

  /**
   * Get TimeZone and the location.
   */
  public function getTimeLocation() {
    return [
      'country' => $this->config->get('country'),
      'city' => $this->config->get('city'),
      'time_zone' => $this->config->get('time_zone'),
    ];
  }

}
