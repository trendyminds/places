<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\assetbundles\Places;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

use trendyminds\places\Places;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class PlacesAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@trendyminds/places/assetbundles/places";
        $key = Places::$plugin->settings->googleMapsKey;

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            "Places.css"
        ];

        $this->js = [
            "https://maps.googleapis.com/maps/api/js?key={$key}&libraries=places",
            "Places.js",
        ];

        parent::init();
    }
}
