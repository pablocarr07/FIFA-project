<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cdprequest Entity
 *
 * @property int $id
 * @property int $cdp
 * @property int $applicant_id
 * @property int $created_by
 * @property int $group_id
 * @property int $state
 * @property int $movement_type
 * @property string $value_letter
 * @property float $value_number
 * @property string $justification
 * @property string $object
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\User $Applicants
 * @property \App\Model\Entity\User $Created_by
 * @property \App\Model\Entity\Cdpsstate $State
 * @property \App\Model\Entity\Cdpsmovementtype $Movement_types
 * @property \App\Model\Entity\Group $group
 */
class Cdprequest extends Entity
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
