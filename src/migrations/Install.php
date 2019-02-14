<?php
/**
 * Places plugin for Craft CMS 3.x
 *
 * Geocode your content using Google's Place Autocomplete field
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2019 TrendyMinds
 */

namespace trendyminds\places\migrations;

use trendyminds\places\Places;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    TrendyMinds
 * @package   Places
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            Craft::$app->db->schema->refresh();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%places_places}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%places_places}}',
                [
                    'id' => $this->primaryKey(),
                    'elementId' => $this->integer()->notNull(),
                    'fieldId' => $this->integer()->notNull(),
                    'place' => $this->string(),
                    'street' => $this->string(),
                    'city' => $this->string(),
                    'state' => $this->string(),
                    'zip' => $this->string(),
                    'country' => $this->string(),
                    'lat' => $this->decimal(12, 8),
                    'lng' => $this->decimal(12, 8),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull()->defaultValue(1),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(null, '{{%places_places}}', ['elementId']);
        $this->createIndex(null, '{{%places_places}}', ['fieldId']);

        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(null, '{{%places_places}}', ['elementId'], '{{%elements}}', ['id'], 'CASCADE');
        $this->addForeignKey(null, '{{%places_places}}', ['fieldId'],   '{{%fields}}',   ['id'], 'CASCADE');
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%places_places}}');
    }
}
