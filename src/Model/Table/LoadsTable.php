<?php
namespace App\Model\Table;

use App\Model\Entity\Load;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
use AuditLog\Model\Table\CurrentUserTrait;

/**
 * Loads Model
 *
 * @property \Cake\ORM\Association\HasMany $Cdps
 * @property \Cake\ORM\Association\HasMany $CdpsTmp
 * @property \Cake\ORM\Association\HasMany $Compromisos
 * @property \Cake\ORM\Association\HasMany $CompromisosTmp
 */
class LoadsTable extends Table
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

        $this->table('loads');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog.Auditable');
        $this->addBehavior('Search.Search');

        $this->hasMany('Cdps', [
            'foreignKey' => 'load_id'
        ]);
        $this->hasMany('CdpsTmp', [
            'foreignKey' => 'load_id'
        ]);
        $this->hasMany('Compromisos', [
            'foreignKey' => 'load_id'
        ]);
        $this->hasMany('CompromisosTmp', [
            'foreignKey' => 'load_id'
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
                    'field' => [$this->aliasField('identification')]
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('cdp', 'create')
            ->notEmpty('cdp');

        $validator
            ->requirePresence('compromiso', 'create')
            ->notEmpty('compromiso');

        $validator
            ->boolean('support')
            ->allowEmpty('support');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
    
    public function afterSave($entity, $options = []) {
        $compromisos = $this->connection()->query('select insert_compromisos("' . $options->id . '") compromiso')->fetchAll('assoc');
        $cdps = $this->connection()->query('select insert_cdps("' . $options->id . '") cdp')->fetchAll('assoc');

        // if ($compromisos[0]['compromiso'] and $cdps[0]['cdp']) {}
        
        $this->Cdps->deleteAll('load_id !="' . $options->id . '"');
        $this->Compromisos->deleteAll('load_id !="' . $options->id . '"');
        $this->CdpsTmp->deleteAll('1');
        $this->CompromisosTmp->deleteAll('1');
    }
    
    public function getLastId(){
       $query = $this->find()->order(['Loads.created' =>'desc'])->first();
	   if($query)
       return $query->id;
    }

}
