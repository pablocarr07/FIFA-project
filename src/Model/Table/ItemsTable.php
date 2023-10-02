<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * Items Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ItemsClassifications
 * @property \Cake\ORM\Association\BelongsToMany $Cdprequests
 * @property \Cake\ORM\Association\BelongsToMany $Types
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTable extends Table
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

        $this->table('items');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        
        
        $this->addBehavior('AuditLog.Auditable');
        $this->addBehavior('Search.Search');

        $this->belongsTo('ItemsClassifications', [
            'foreignKey' => 'item_classification_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Cdprequests', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'cdprequest_id',
            'joinTable' => 'cdprequests_items'
        ]);
        $this->belongsToMany('Types', [
            'foreignKey' => 'id',
            'targetForeignKey' => 'type_id',
            'joinTable' => 'items_types'
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
                    'field' => [$this->aliasField('name'), $this->aliasField('id'),'ItemsClassifications.name']
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('item', 'create')
            ->notEmpty('item');

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
        $rules->add($rules->existsIn(['item_classification_id'], 'ItemsClassifications'));

        return $rules;
    }
}
