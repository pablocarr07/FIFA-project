<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CdprequestsItemsFixture
 *
 */
class CdprequestsItemsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cdprequest_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'value' => ['type' => 'decimal', 'length' => 13, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'resource_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'items_idx' => ['type' => 'index', 'columns' => ['item_id'], 'length' => []],
            'cdprequests_idx' => ['type' => 'index', 'columns' => ['cdprequest_id'], 'length' => []],
            'resources_idx' => ['type' => 'index', 'columns' => ['resource_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'cdprequests' => ['type' => 'foreign', 'columns' => ['cdprequest_id'], 'references' => ['cdprequests', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'items' => ['type' => 'foreign', 'columns' => ['item_id'], 'references' => ['items', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resources' => ['type' => 'foreign', 'columns' => ['resource_id'], 'references' => ['resources', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'item_id' => 1,
            'cdprequest_id' => 1,
            'value' => 1.5,
            'resource_id' => 1,
            'created' => '2016-12-18 17:25:20',
            'modified' => '2016-12-18 17:25:20',
            'deleted' => '2016-12-18 17:25:20'
        ],
    ];
}
