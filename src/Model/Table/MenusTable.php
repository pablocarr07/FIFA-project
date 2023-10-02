<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \Cake\ORM\Association\HasMany $ChildMenus
 * @property \Cake\ORM\Association\BelongsToMany $Roles
 *
 * @method \App\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \App\Model\Entity\Menu newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Menu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Menu[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Menu findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class MenusTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('menus');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentMenus', [
            'className' => 'Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'menu_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'roles_menus'
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
                ->requirePresence('link', 'create')
                ->notEmpty('link');

        $validator
                ->boolean('visible')
                ->allowEmpty('visible');

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
        // $rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));
        return $rules;
    }

    function afterSave($event, $entity, $options) {
        $datas = $this->find()->contain(['Roles']);
        $acls = [];
        foreach ($datas as $data) {
            if (!filter_var($data->link, FILTER_VALIDATE_URL) and $data->link != '#') {

                $link = explode('/', $data->link);
                $alias = [];
                foreach ($data->roles as $role) {
                    $alias[] = $role->alias;
                }
                $acls[ucwords($link[0])][$link[1]] = implode(',', $alias) . ';';
            }
        }

        $file_acl = '';
        foreach ($acls as $key => $acl) {
            $persimos = '';
            foreach ($acl as $k => $data) {
                $persimos.=$k . ' = ' . $data . PHP_EOL;
            }
            $file_acl.='[' . $key . ']' . PHP_EOL;
            $file_acl.=$persimos;
        }

        $file = fopen(getcwd()."/config/acl.ini", "w");
        $file_acl.= '[Menus]' . PHP_EOL . '* = admin' . PHP_EOL;
        $file_acl.= '[Home]' . PHP_EOL . 'login,index,logout,profile,exportExcel = *' . PHP_EOL;
        fwrite($file, $file_acl . PHP_EOL);
        fclose($file);
    }

}
