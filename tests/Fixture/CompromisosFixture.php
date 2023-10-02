<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompromisosFixture
 *
 */
class CompromisosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'load_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'fecha_de_registro' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'fecha_de_creacion' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'estado' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'dependencia' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'dependencia_descripcion' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'rubro' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'descripcion' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'fuente' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'recurso' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'situacion' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_inicial' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'valor_operaciones' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'valor_actual' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'saldo_por_utilizar' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'tipo_identificacion' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'identificacion' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'nombre_razon_social' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'medio_de_pago' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_cuenta' => ['type' => 'string', 'length' => 40, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_cuenta' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'estado_cuenta' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'entidad_nit' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'entidad_descripcion' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'solicitud_cdp' => ['type' => 'integer', 'length' => 5, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cdp' => ['type' => 'integer', 'length' => 5, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'compromisos' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cuentas_por_pagar' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'obligaciones' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ordenes_de_pago' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'reintegros' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'fecha_documento_soporte' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'tipo_documento_soporte' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_documento_soporte' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'observaciones' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'uploaded_file' => ['type' => 'index', 'columns' => ['load_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'loads_fk' => ['type' => 'foreign', 'columns' => ['load_id'], 'references' => ['loads', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
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
            'id' => 'd899b0bd-9065-441d-8eec-d0048316e08e',
            'load_id' => '9319d710-2341-4ee3-84b3-633f140bab28',
            'fecha_de_registro' => '2016-06-16 15:47:17',
            'fecha_de_creacion' => '2016-06-16 15:47:17',
            'estado' => 'Lorem ipsum dolor sit amet',
            'dependencia' => 'Lorem ip',
            'dependencia_descripcion' => 'Lorem ipsum dolor sit amet',
            'rubro' => 'Lorem ipsum d',
            'descripcion' => 'Lorem ipsum dolor sit amet',
            'fuente' => 'Lorem ipsum dolor ',
            'recurso' => 'Lorem ipsum dolor sit amet',
            'situacion' => 'Lorem ip',
            'valor_inicial' => 1,
            'valor_operaciones' => 1,
            'valor_actual' => 1,
            'saldo_por_utilizar' => 1,
            'tipo_identificacion' => 'Lorem ipsum dolor sit amet',
            'identificacion' => 'Lorem ip',
            'nombre_razon_social' => 'Lorem ipsum dolor sit amet',
            'medio_de_pago' => 'Lorem ipsum dolor sit amet',
            'tipo_cuenta' => 'Lorem ipsum dolor sit amet',
            'numero_cuenta' => 'Lorem ipsum dolor ',
            'estado_cuenta' => 'Lorem ipsum dolor ',
            'entidad_nit' => 'Lorem ip',
            'entidad_descripcion' => 'Lorem ipsum dolor sit amet',
            'solicitud_cdp' => 1,
            'cdp' => 1,
            'compromisos' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'cuentas_por_pagar' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'obligaciones' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'ordenes_de_pago' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'reintegros' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'fecha_documento_soporte' => '2016-06-16 15:47:17',
            'tipo_documento_soporte' => 'Lorem ipsum dolor sit amet',
            'numero_documento_soporte' => 'Lorem ip',
            'observaciones' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-06-16 15:47:17',
            'modified' => '2016-06-16 15:47:17'
        ],
    ];
}
