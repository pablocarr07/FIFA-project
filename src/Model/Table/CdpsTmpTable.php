<?php
namespace App\Model\Table;

use App\Model\Entity\CdpsTmp;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CdpsTmp Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Loads
 */
class CdpsTmpTable extends Table
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

        $this->table('cdps_tmp');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Loads', [
            'foreignKey' => 'load_id'
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
            ->integer('numero_documento')
            ->allowEmpty('numero_documento');

        $validator
            ->dateTime('fecha_de_registro')
            ->allowEmpty('fecha_de_registro');

        $validator
            ->dateTime('fecha_de_creacion')
            ->allowEmpty('fecha_de_creacion');

        $validator
            ->allowEmpty('tipo_de_cdp');

        $validator
            ->allowEmpty('estado');

        $validator
            ->allowEmpty('dependencia');

        $validator
            ->allowEmpty('dependencia_descripcion');

        $validator
            ->allowEmpty('rubro');

        $validator
            ->allowEmpty('descripcion');

        $validator
            ->allowEmpty('fuente');

        $validator
            ->allowEmpty('recurso');

        $validator
            ->allowEmpty('sit');

        $validator
            ->numeric('valor_inicial')
            ->allowEmpty('valor_inicial');

        $validator
            ->numeric('valor_operaciones')
            ->allowEmpty('valor_operaciones');

        $validator
            ->numeric('valor_actual')
            ->allowEmpty('valor_actual');

        $validator
            ->numeric('saldo_comprometer')
            ->allowEmpty('saldo_comprometer');

        $validator
            ->allowEmpty('objeto');

        $validator
            ->integer('solicitud_cdp')
            ->allowEmpty('solicitud_cdp');

        $validator
            ->allowEmpty('compromisos');

        $validator
            ->allowEmpty('cuentas_por_pagar');

        $validator
            ->allowEmpty('obligaciones');

        $validator
            ->allowEmpty('ordenes_de_pago');

        $validator
            ->allowEmpty('reintegros');

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
        //$rules->add($rules->existsIn(['load_id'], 'Loads'));
        return $rules;
    }
}
