<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
//use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * CdprequestsItems Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Items
 * @property \Cake\ORM\Association\BelongsTo $Cdprequests
 * @property \Cake\ORM\Association\BelongsTo $Resources
 *
 * @method \App\Model\Entity\CdprequestsItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\CdprequestsItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CdprequestsItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CdprequestsItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CdprequestsItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CdprequestsItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CdprequestsItem findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CdprequestsItemsTable extends Table
{
    
    //use SoftDeleteTrait;
    use CurrentUserTrait;    

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->table('cdprequests_items');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog.Auditable');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cdprequests', [
            'foreignKey' => 'cdprequest_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Resources', [
            'foreignKey' => 'resource_id'
        ]);
         $this->belongsTo('Taks', [
            'foreignKey' => 'task_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->decimal('value')
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['cdprequest_id'], 'Cdprequests'));
        $rules->add($rules->existsIn(['resource_id'], 'Resources'));
        return $rules;
    }
}
