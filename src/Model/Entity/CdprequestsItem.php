<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CdprequestsItem Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $cdprequest_id
 * @property float $value
 * @property int $resource_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Cdprequest $cdprequest
 * @property \App\Model\Entity\Resource $resource
 */
class CdprequestsItem extends Entity
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
