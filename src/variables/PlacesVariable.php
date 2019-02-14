<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\variables;

use trendyminds\places\Places;

use Craft;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class PlacesVariable
{
  public function hasKey()
  {
    return Places::$plugin->settings->googleMapsKey !== "";
  }
}
