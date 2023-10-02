<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * Cdprequests Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Groups
 * @property \Cake\ORM\Association\BelongsToMany $Items
 *
 * @method \App\Model\Entity\Cdprequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cdprequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cdprequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cdprequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cdprequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cdprequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cdprequest findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CdprequestsTable extends Table
{

    use SoftDeleteTrait;
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

        $this->table('cdprequests');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog.Auditable');
        $this->addBehavior('Fifa');

        $this->addBehavior('Search.Search');

        $this->addBehavior('Xety/Cake3Upload.Upload', [
            'fields' => [
                'soprtecdp' => [
                    'path' => 'uploads/cdprequests/:id/:md5',
                    'overwrite' => true,
                ]
            ]
        ]);

        $this->belongsTo('Applicants', [
            'foreignKey' => 'applicant_id',
            'joinType' => 'LEFT',
            'className' => 'Users',
            'propertyName' => 'Applicants'
        ]);

        $this->belongsTo('Created_by', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT',
            'className' => 'Users',
            'propertyName' => 'Created_by'
        ]);

        $this->belongsTo('States', [
            'foreignKey' => 'state',
            'joinType' => 'LEFT',
            'className' => 'Cdpsstates',
            'propertyName' => 'State'
        ]);

        $this->belongsTo('Movement_types', [
            'foreignKey' => 'movement_type',
            'joinType' => 'LEFT',
            'className' => 'Cdpsmovementtype',
            'propertyName' => 'Movement_types'
        ]);

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsToMany('Items', [
            'foreignKey' => 'cdprequest_id',
            'targetForeignKey' => 'item_id',
            'joinTable' => 'cdprequests_items'
        ]);

        $this->hasMany('Timeline', [
            //cdprequest_id
            //'foreignKey' => 'cdprequest_id',
            //'targetForeignKey' => '',
            'joinTable' => 'cdptimeline',
            'className' => 'cdptimeline'
        ]);

        $this->searchManager()
            ->value('id')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => [
                    $this->aliasField('identification'),
                    $this->aliasField('name'),
                    $this->aliasField('email'),
                    'Groups.name',
                    'Types.name'
                ]
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
            ->integer('applicant_id')
            ->requirePresence('applicant_id', 'create')
            ->notEmpty('applicant_id');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->integer('movement_type')
            ->requirePresence('movement_type', 'create')
            ->notEmpty('movement_type');

        $validator
            ->requirePresence('justification', 'create')
            ->notEmpty('justification');

        $validator
            ->requirePresence('object', 'create')
            ->notEmpty('object');

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
        // $rules->add($rules->existsIn(['applicant_id'], 'Applicants'));
        // $rules->add($rules->existsIn(['created_by'], 'Created_by'));
        // $rules->add($rules->existsIn(['group_id'], 'Groups'));
        // $rules->add($rules->existsIn(['state'], 'States'));
        // $rules->add($rules->existsIn(['movement_type'], 'Movement_types'));
        return $rules;
    }
}
