<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places;

use trendyminds\places\services\PlacesService as PlacesServiceService;
use trendyminds\places\models\Settings;
use trendyminds\places\fields\PlacesField as PlacesFieldField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Places
 *
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 *
 * @property  PlacesServiceService $placesService
 */
class Places extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Places
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = PlacesFieldField::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('places', PlacesVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'places',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'places/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
