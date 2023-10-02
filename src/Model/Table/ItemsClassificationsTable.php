<?php
namespace App\Model\Table;

use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;
use Cake\ORM\Behavior\TreeBehavior;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * ItemsClassifications Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ItemsTypes
 * @property \Cake\ORM\Association\BelongsTo $ParentItemsClassifications
 * @property \Cake\ORM\Association\HasMany $ChildItemsClassifications
 *
 * @method \App\Model\Entity\ItemsClassification get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemsClassification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemsClassification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemsClassification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemsClassification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemsClassification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemsClassification findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsClassificationsTable extends Table
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

        $this->addBehavior('Tree');

        $this->addBehavior('AuditLog.Auditable');
        //  $this->addBehavior('Tree');
        $this->addBehavior('Search.Search');

        $this->table('items_classifications');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentItemsClassifications', [
            'className' => 'ItemsClassifications',
            'foreignKey' => 'parent_id'
        ]);

        $this->belongsTo('ItemsTypes', [
            'foreignKey' => 'item_type_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('ChildItemsClassifications', [
            'className' => 'ItemsClassifications',
            'foreignKey' => 'parent_id'
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
                    'field' => [$this->aliasField('name'), $this->aliasField('id'),'ItemsTypes.name', 'ParentItemsClassifications.name']
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
            ->requirePresence('item_type_id', 'create')
            ->notEmpty('item_type_id');

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
        $rules->add($rules->existsIn(['item_type_id'], 'ItemsTypes'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentItemsClassifications'));
        return $rules;
    }
}
