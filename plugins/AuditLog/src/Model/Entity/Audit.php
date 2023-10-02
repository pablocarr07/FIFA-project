<?php
namespace AuditLog\Model\Entity;

use Cake\ORM\Entity;

/**
 * Audit Entity.
 */
class Audit extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'event' => true,
        'model' => true,
        'entity_id' => true,
        'json_object' => true,
        'description' => true,
        'source_id' => true,
        'delta_count' => true,
        'source_ip' => true,
        'source_url' => true,
        'entity' => true,
        'source' => true,
        'audit_deltas' => true,
    ];
}
