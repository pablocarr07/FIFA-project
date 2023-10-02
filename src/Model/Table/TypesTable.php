<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * Types Model
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
class TypesTable extends Table
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

        $this->table('types');
        $this->primaryKey('id');
        $this->displayField('name');

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

        return $validator;
    }

}
