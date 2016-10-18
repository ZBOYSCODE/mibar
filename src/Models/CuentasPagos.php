<?php
namespace App\Models;

class CuentasPagos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $pago_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $cuenta_id;

    

    /**
     * Initialize method for model.
     */
    public function initialize()
    {   
        $this->hasMany('id', __NAMESPACE__.'\CuentasPagos', 'pago_id', ['alias' => 'CuentasPagos']);
        $this->belongsTo('pago_id', __NAMESPACE__.'\Pagos', 'id', ['alias' => 'Pagos']);
        $this->belongsTo('cuenta_id', __NAMESPACE__.'\Cuentas', 'id', ['alias' => 'Cuentas']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cuentas_pagos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cuentas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cuentas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
