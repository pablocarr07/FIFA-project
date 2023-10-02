<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CdprequestsTaksFixture
 *
 */
class CdprequestsTaksFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'cdprequest_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'taks_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'cdprequest_id' => ['type' => 'index', 'columns' => ['cdprequest_id'], 'length' => []],
            'taks_id' => ['type' => 'index', 'columns' => ['taks_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'cdprequests_taks_ibfk_2' => ['type' => 'foreign', 'columns' => ['taks_id'], 'references' => ['tasks', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'cdprequests_taks_ibfk_1' => ['type' => 'foreign', 'columns' => ['cdprequest_id'], 'references' => ['cdprequests', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'cdprequest_id' => 1,
            'taks_id' => 1,
            'created' => '2017-03-07 14:27:50',
            'modified' => '2017-03-07 14:27:50',
            'deleted' => '2017-03-07 14:27:50'
        ],
    ];
}
