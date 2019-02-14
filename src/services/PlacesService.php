<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\services;

use trendyminds\places\Places;

use Craft;
use craft\base\Component;

use trendyminds\places\fields\PlacesField;
use trendyminds\places\records\PlacesRecord;
use trendyminds\places\models\PlacesModel;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class PlacesService extends Component
{
    // Public Methods
    // =========================================================================
    public function savePlace(PlacesField $field, $element)
    {
        $data = $element->getFieldValue($field->handle);

        if (!$data) {
            return false;
        }

        // If we don't have a "place" then remove all the additional content
        if ($data['place'] === "") {
            $data['street'] = NULL;
            $data['city'] = NULL;
            $data['state'] = NULL;
            $data['zip'] = NULL;
            $data['country'] = NULL;
            $data['lat'] = NULL;
            $data['lng'] = NULL;
        }

        $record = PlacesRecord::findOne([
            'elementId' => $element->id,
            'fieldId'   => $field->id,
        ]);

        if (!$record) {
            $record = new PlacesRecord;
            $record->elementId = $element->id;
            $record->fieldId   = $field->id;
        }

        $record->setAttribute('place',   $data['place']);
        $record->setAttribute('street',  $data['street']);
        $record->setAttribute('city',    $data['city']);
        $record->setAttribute('state',   $data['state']);
        $record->setAttribute('zip',     $data['zip']);
        $record->setAttribute('country', $data['country']);
        $record->setAttribute('lat',     $data['lat']);
        $record->setAttribute('lng',     $data['lng']);

        return $record->save();
    }

    public function getPlace(PlacesField $field, $element, $value)
    {
        if (!$element) {
            return false;
        }

        $record = PlacesRecord::findOne([
            'elementId' => $element->id,
            'fieldId'   => $field->id,
        ]);

        if (is_array($value)) {
            $model = new PlacesModel($value);
        } else if ($record) {
            $model = new PlacesModel($record->getAttributes());
        } else {
            $model = new PlacesModel();
        }

        $model->handle = $field->handle;

        return $model;
    }
}
