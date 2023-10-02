<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CdprequestsItemsTasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CdprequestsItems
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 *
 * @method \App\Model\Entity\CdprequestsItemsTask get($primaryKey, $options = [])
 * @method \App\Model\Entity\CdprequestsItemsTask newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CdprequestsItemsTask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CdprequestsItemsTask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CdprequestsItemsTask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CdprequestsItemsTask[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CdprequestsItemsTask findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CdprequestsItemsTasksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('cdprequests_items_tasks');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CdprequestsItems', [
            'foreignKey' => 'cdprequest_item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['cdprequest_item_id'], 'CdprequestsItems'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));

        return $rules;
    }
}
