<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cdptimeline Entity
 *
 * @property string|resource $id
 * @property int $created_by
 * @property int $cdpsstates_id
 * @property int $cdprequest_id
 * @property string $commentary
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Cdpsstate $cdpsstate
 * @property \App\Model\Entity\Cdprequest $cdprequest
 */
class Cdptimeline extends Entity
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
        'id' => false
    ];
}
