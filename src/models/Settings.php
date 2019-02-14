<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\models;

use trendyminds\places\Places;

use Craft;
use craft\base\Model;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    public $googleMapsKey = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['googleMapsKey', 'string'],
            ['googleMapsKey', 'default', 'value' => '']
        ];
    }
}
