<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cdpsmovementtype Model
 *
 * @method \App\Model\Entity\Cdpsmovementtype get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cdpsmovementtype newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cdpsmovementtype[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cdpsmovementtype|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cdpsmovementtype patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cdpsmovementtype[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cdpsmovementtype findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CdpsmovementtypeTable extends Table
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

        $this->table('cdpsmovementtype');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->allowEmpty('description');

        return $validator;
    }
}
