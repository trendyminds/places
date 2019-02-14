<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\fields;

use trendyminds\places\Places;
use trendyminds\places\assetbundles\Places\PlacesAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class PlacesField extends Field
{
    // Public Properties
    // =========================================================================
    public $layout = [
        'place',
        'street',
        'city',
        'state',
        'zip',
        'country',
        'lat',
        'lng',
    ];

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('places', 'Places');
    }

    /**
     * @inheritdoc
     */
    public static function hasContentColumn(): bool
    {
        return false;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return parent::rules();
    }

    public function afterElementSave(ElementInterface $element, bool $isNew)
    {
        Places::$plugin->placesService->savePlace($this, $element);
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return Places::$plugin->placesService->getPlace($this, $element, $value);
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        Craft::$app->getView()->registerAssetBundle(PlacesAsset::class);

        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        Craft::$app->getView()->registerJs("new window.PlacesField('#{$namespacedId}-field')");

        return Craft::$app->getView()->renderTemplate(
            'places/_components/fields/PlacesField_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }
}
