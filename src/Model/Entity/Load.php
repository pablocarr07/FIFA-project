<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Load Entity.
 *
 * @property string $id
 * @property string $cdp
 * @property string $compromiso
 * @property bool $support
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property \App\Model\Entity\Cdp[] $cdps
 * @property \App\Model\Entity\CdpsTmp[] $cdps_tmp
 * @property \App\Model\Entity\Compromiso[] $compromisos
 * @property \App\Model\Entity\CompromisosTmp[] $compromisos_tmp
 */
class Load extends Entity
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
