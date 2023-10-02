<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cdptimeline Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cdpsstates
 * @property \Cake\ORM\Association\BelongsTo $Cdprequests
 *
 * @method \App\Model\Entity\Cdptimeline get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cdptimeline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cdptimeline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cdptimeline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cdptimeline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cdptimeline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cdptimeline findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CdptimelineTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('cdptimeline');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cdpsstates', [
            'foreignKey' => 'cdpsstates_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cdprequests', [
            'foreignKey' => 'cdprequest_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Created_by', [
            'foreignKey' => 'created_by',
            'joinType' => 'INNER',
            'className' => 'Users',
            'propertyName' => 'Created_by'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->allowEmpty('id', 'create');

        $validator
                ->integer('created_by')
                ->requirePresence('created_by', 'create')
                ->notEmpty('created_by');

        $validator
                ->allowEmpty('commentary');

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
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['cdpsstates_id'], 'Cdpsstates'));
        $rules->add($rules->existsIn(['cdprequest_id'], 'Cdprequests'));
        return $rules;
    }

}
