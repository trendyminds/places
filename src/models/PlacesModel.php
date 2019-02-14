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
use craft\helpers\Template;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class PlacesModel extends Model
{
    public $elementId;
    public $fieldId;
    public $handle;
    public $place;
    public $street;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $lat;
    public $lng;

    public function __construct($attributes = [], array $config = [])
    {
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                if (property_exists($this, $key)) {
                    $this[$key] = $value;
                }
            }
        }

        parent::__construct($config);
    }

    /**
     * @inheritDoc BaseModel::populateModel()
     *
     * @param mixed $attributes
     *
     * @return PlacesModel
     */
    public static function populateModel($attributes)
    {
        return parent::populateModel($attributes);
    }
}
