<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CdptimelineFixture
 *
 */
class CdptimelineFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cdptimeline';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'binary', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created_by' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cdpsstates_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cdprequest_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'commentary' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'cdp_idx' => ['type' => 'index', 'columns' => ['cdprequest_id'], 'length' => []],
            'usuario_idx' => ['type' => 'index', 'columns' => ['created_by'], 'length' => []],
            'estado cdp_idx' => ['type' => 'index', 'columns' => ['cdpsstates_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'cdp' => ['type' => 'foreign', 'columns' => ['cdprequest_id'], 'references' => ['cdprequests', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'estado cdp' => ['type' => 'foreign', 'columns' => ['cdpsstates_id'], 'references' => ['cdpsstates', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'usuario' => ['type' => 'foreign', 'columns' => ['created_by'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'id' => 'f06ee48b-53f2-4184-b148-2fb9e3adf451',
            'created_by' => 1,
            'cdpsstates_id' => 1,
            'cdprequest_id' => 1,
            'commentary' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => '2016-12-19 14:59:47',
            'modified' => '2016-12-19 14:59:47',
            'deleted' => '2016-12-19 14:59:47'
        ],
    ];
}
