<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * ItemsTypes Model
 *
 * @method \App\Model\Entity\ItemsType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemsType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemsType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemsType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemsType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemsType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemsType findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTypesTable extends Table
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

        $this->table('items_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog.Auditable');
        $this->addBehavior('Search.Search');
        $this->searchManager()
                ->value('id')
                ->add('q', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'mode' => 'or',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => [$this->aliasField('name'), $this->aliasField('id')]
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
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->dateTime('deleted')
                ->allowEmpty('deleted');

        $validator
                ->integer('item_classification_id')
                ->allowEmpty('item_classification_id', 'create');

        $validator
                ->allowEmpty('name', 'create');

        $validator
                ->allowEmpty('item', 'create');

        return $validator;
    }

}
