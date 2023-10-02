<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CdprequestsTak Entity
 *
 * @property int $id
 * @property int $cdprequest_id
 * @property int $taks_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Cdprequest $cdprequest
 * @property \App\Model\Entity\Task $task
 */
class CdprequestsTak extends Entity
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
