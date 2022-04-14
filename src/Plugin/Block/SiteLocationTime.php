<?php

namespace Drupal\site_location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\site_location_time\GetSiteLocationTime;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SiteLocationTime' block.
 *
 * @Block(
 *   id = "site_location_time_block",
 *   admin_label = @Translation("Site Location Time"),
 *
 * )
 */
class SiteLocationTime extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Site location services.
   *
   * @var \Drupal\site_location_time\GetSiteLocationTime
   */
  protected $siteLocationTime = NULL;

  /**
   * Static create function provided by the ContainerFactoryPluginInterface.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site_location_time')
    );
  }

  /**
   * BlockBase plugin constructor that's expecting the create().
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, GetSiteLocationTime $siteLocationTime) {
    // Instantiate the BlockBase parent first.
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    // Save the service passed to this constructor via dependency injection.
    $this->siteLocationTime = $siteLocationTime;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $details = $this->siteLocationTime->getTimeLocation();
    $country = $details['country'];
    $city = $details['city'];
    $time_zone = $details['time_zone'];
    $now = DrupalDateTime::createFromTimestamp(time());
    $now->setTimezone(new \DateTimeZone($time_zone));

    $build['#markup'] = $this->t('
      Time is <b>@time</b> at <b>@city</b> of <b>@country</b>', [
        '@country' => $country,
        '@city' => $city,
        '@time' => $now->format('jS M Y - H:i A'),
      ]
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return ['site_location_time_cache'];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
