<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CdpsTmp Entity.
 *
 * @property string $id
 * @property string $load_id
 * @property \App\Model\Entity\Load $load
 * @property int $numero_documento
 * @property \Cake\I18n\Time $fecha_de_registro
 * @property \Cake\I18n\Time $fecha_de_creacion
 * @property string $tipo_de_cdp
 * @property string $estado
 * @property string $dependencia
 * @property string $dependencia_descripcion
 * @property string $rubro
 * @property string $descripcion
 * @property string $fuente
 * @property string $recurso
 * @property string $sit
 * @property float $valor_inicial
 * @property float $valor_operaciones
 * @property float $valor_actual
 * @property float $saldo_comprometer
 * @property string $objeto
 * @property int $solicitud_cdp
 * @property string $compromisos
 * @property string $cuentas_por_pagar
 * @property string $obligaciones
 * @property string $ordenes_de_pago
 * @property string $reintegros
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class CdpsTmp extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
