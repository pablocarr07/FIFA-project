<?php

namespace App\Model\Table;

use App\Model\Entity\Group;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * Groups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentGroups
 * @property \Cake\ORM\Association\HasMany $ChildGroups
 * @property \Cake\ORM\Association\HasMany $Users
 */
class GroupsTable extends Table {

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

        $this->table('groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('AuditLog.Auditable');
        $this->addBehavior('Search.Search');

        $this->belongsTo('ParentGroups', [
            'className' => 'Groups',
            'foreignKey' => 'parent_id'
        ]);

        $this->belongsTo('ImmediateBoss', [
            'foreignKey' => 'immediate_boss_id',
            'joinType' => 'LEFT',
            'className' => 'Users',
            'propertyName' => 'ImmediateBoss'
        ]);

        $this->hasMany('ChildGroups', [
            'className' => 'Groups',
            'foreignKey' => 'parent_id'
        ]);

        $this->hasMany('GroupsUsers', [
            'className' => 'GroupsUsers',
            'foreignKey' => 'group_id'
        ]);

        $this->belongsToMany('Users', [
            'foreignKey' => 'group_id',
            'targetForeignKey' => 'user_id',
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
                    'field' => [$this->aliasField('name'), $this->aliasField('Budget'), 'ParentGroups.name']
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
                ->numeric('budget')
                ->requirePresence('budget', 'create')
                ->notEmpty('budget');

        $validator
                ->integer('lft')
                ->allowEmpty('lft');

        $validator
                ->integer('rght')
                ->allowEmpty('rght');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentGroups'));
        return $rules;
    }

    //groupUsers

    public function getGroupUsers($nodeId, $output = false) {

        $groups = $this->find('threaded', [
                    'contain' => ['ParentGroups', 'ChildGroups', 'Users']
                ])->where(['groups.id = ' => $nodeId])->toArray();

        if (!empty($output)) {
            $output = [];
        }

        foreach ($groups as $group) {
            foreach ($group->users as $user) {
                $output[] = ['identification' => $user->identification, 'name' => $user->name, 'group' => $group->name];
            }
            foreach ($group->child_groups as $child) {
                $output = array_merge($output, $this->getGroupUsers($child->id, $output));
            }
        }
        return $output;
    }

    public function getGroup($nodeId, $output = false) {

        $groups = $this->find('threaded', [
                    'contain' => ['ParentGroups', 'ChildGroups']
                ])->where(['groups.id = ' => $nodeId])->toArray();

        if (!empty($output)) {
            $output = [];
        }

        foreach ($groups as $group) {
            $output[] = ['id' => $group->id, 'name' => $group->name];

            foreach ($group->child_groups as $child) {
                print_r($child);
                die();
                $output = array_merge($output, $this->getGroupUsers($child->id, $output));
            }
        }
        return $output;
    }

}
