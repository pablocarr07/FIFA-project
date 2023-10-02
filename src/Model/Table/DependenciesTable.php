<?php
namespace App\Model\Table;

use App\Model\Entity\Dependency;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * Dependencies Model
 *
 * @property \Cake\ORM\Association\HasMany $Groups
 */
class DependenciesTable extends Table
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
        

        $this->table('dependencies');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog.Auditable');
        $this->addBehavior('Search.Search');

        $this->hasMany('Groups', [
            'foreignKey' => 'dependency_id'
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
          'field' => [$this->aliasField('name')]
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
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['name']));
        return $rules;
    }
}
