<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\records;

use trendyminds\places\Places;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class PlacesRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%places_places}}';
    }
}
