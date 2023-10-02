<?php
namespace AuditLog\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditDelta Entity.
 */
class AuditDelta extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'audit_id' => true,
        'property_name' => true,
        'old_value' => true,
        'new_value' => true,
        'audit' => true,
    ];
}
