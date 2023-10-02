<?php
namespace App\Model\Table;

use App\Model\Entity\Compromiso;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Compromisos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Loads
 */
class CompromisosTable extends Table
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

        $this->table('compromisos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Loads', [
            'foreignKey' => 'load_id'
        ]);
        
        /*$this->belongsTo('Cdps', [
            'foreignKey' => 'numero_documento',
            'propertyName'=>'cdp',
            'joinType' => 'INNER'
        ]);*/
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
            ->dateTime('fecha_de_registro')
            ->allowEmpty('fecha_de_registro');

        $validator
            ->dateTime('fecha_de_creacion')
            ->allowEmpty('fecha_de_creacion');

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
            ->allowEmpty('situacion');

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
            ->numeric('saldo_por_utilizar')
            ->allowEmpty('saldo_por_utilizar');

        $validator
            ->allowEmpty('tipo_identificacion');

        $validator
            ->allowEmpty('identificacion');

        $validator
            ->allowEmpty('nombre_razon_social');

        $validator
            ->allowEmpty('medio_de_pago');

        $validator
            ->allowEmpty('tipo_cuenta');

        $validator
            ->allowEmpty('numero_cuenta');

        $validator
            ->allowEmpty('estado_cuenta');

        $validator
            ->allowEmpty('entidad_nit');

        $validator
            ->allowEmpty('entidad_descripcion');

        $validator
            ->integer('solicitud_cdp')
            ->allowEmpty('solicitud_cdp');

        $validator
            ->integer('cdp')
            ->allowEmpty('cdp');

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

        $validator
            ->dateTime('fecha_documento_soporte')
            ->allowEmpty('fecha_documento_soporte');

        $validator
            ->allowEmpty('tipo_documento_soporte');

        $validator
            ->allowEmpty('numero_documento_soporte');

        $validator
            ->allowEmpty('observaciones');

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
        $rules->add($rules->existsIn(['load_id'], 'Loads'));
        return $rules;
    }
}
