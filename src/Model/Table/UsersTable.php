<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
* Users Model
*
* @property \Cake\ORM\Association\BelongsTo $TypesIdentification
* @property \Cake\ORM\Association\BelongsTo $Types
* @property \Cake\ORM\Association\BelongsTo $Charges
* @property \Cake\ORM\Association\BelongsToMany $Roles
*/
class UsersTable extends Table {

  use SoftDeleteTrait;

  use CurrentUserTrait;

  /**
  * Initialize method
  *
  * @param array $config The configuration for the Table.
  * @return void
  */
  public function initialize(array $config) {
    parent::initialize($config);

    $this->table('users');
    $this->displayField('name');
    $this->primaryKey('id');

    $this->addBehavior('Timestamp');
    $this->addBehavior('AuditLog.Auditable', ['habtm' => ['Roles']]);
    $this->addBehavior('Search.Search');

    $this->belongsTo('TypesIdentification', [
      'foreignKey' => 'types_identification_id',
      'joinType' => 'LEFT'
    ]);
    $this->belongsTo('Types', [
      'foreignKey' => 'type_id',
      'joinType' => 'LEFT'
    ]);
    $this->belongsTo('Charges', [
      'foreignKey' => 'charge_id',
      'joinType' => 'LEFT'
    ]);
    $this->belongsToMany('Roles', [
      'foreignKey' => 'user_id',
      'targetForeignKey' => 'role_id',
      'joinTable' => 'roles_users'
    ]);

    $this->hasMany('GroupsUsers', [
      'className' => 'GroupsUsers',
      'foreignKey' => 'user_id'
    ]);

    $this->belongsToMany('Groups', [
      'foreignKey' => 'user_id',
      'targetForeignKey' => 'group_id',
      'joinTable' => 'groups_users'
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
        // 'Groups.name',
        'types.name'
      ]
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
    ->requirePresence('identification', 'create')
    ->notEmpty('identification');

    $validator
    ->requirePresence('name', 'create')
    ->notEmpty('name');

    $validator
    ->email('email')
    ->requirePresence('email', 'create')
    ->notEmpty('email');

    $validator
    ->requirePresence('type_id', 'create')
    ->notEmpty('type_id');

    $validator
    ->requirePresence('charge_id', 'create')
    ->notEmpty('charge_id');

    $validator
    ->allowEmpty('username');

    $validator
    ->allowEmpty('password');

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
    // $rules->add($rules->isUnique(['email']));
    // $rules->add($rules->isUnique(['username']));
    // $rules->add($rules->isUnique(['identification']));
    // $rules->add($rules->existsIn(['types_identification_id'], 'TypesIdentification'));
    // // $rules->add($rules->existsIn(['group_id'], 'Groups'));
    // $rules->add($rules->existsIn(['type_id'], 'Types'));
    // $rules->add($rules->existsIn(['charge_id'], 'Charges'));
    return $rules;
  }

  public function findAuth(Query $query, $options) {
    $query->contain(['Roles', 'Charges']);
    return $query;
  }

  public function validationPassword(Validator $validator) {
    $validator
    ->add('password', [
      'length' => [
        'rule' => ['minLength', 6],
        'message' => 'La contraseña debe tener al menos 6 caracteres',
      ]
    ])
    ->add('passwordRepeat', [
      'match' => [
        'rule' => ['compareWith', 'password'],
        'message' => 'Las contraseñas no coinciden',
      ]
    ])
    ->notEmpty('passwordRepeat');

    return $validator;
  }

  public function validationCahngePassword(Validator $validator) {
    $validator
    ->add('passwordActual', 'custom', [
      'rule' => function($value, $context) {
        $user = $this->get($context['data']['id']);
        if ($user) {
          if ((new DefaultPasswordHasher)->check($value, $user->password)) {
            return true;
          }
        }
        return false;
      },
      'message' => 'La Contraseña Actual no coincide',])
      ->notEmpty('passwordActual')
      ->add('password', [
        'length' => [
          'rule' => ['minLength', 6],
          'message' => 'La contraseña debe tener al menos 6 caracteres',
        ]
      ])
      ->add('passwordRepeat', [
        'match' => [
          'rule' => ['compareWith', 'password'],
          'message' => 'Las contraseñas no coinciden',
        ]
      ])
      ->notEmpty('passwordRepeat');

      return $validator;
    }

  }
