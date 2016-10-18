<?php
namespace App\Models;

class Cuentas extends \Phalcon\Mvc\Model
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
    public $cliente_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $mesa_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $pedido_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $funcionario_id;


    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $estado;
    

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__.'\Pedidos', 'cuenta_id', ['alias' => 'Pedidos']);
        $this->hasMany('id', __NAMESPACE__.'\CuentasPagos', 'cuenta_id', ['alias' => 'CuentasPagos']);
        $this->belongsTo('cliente_id', __NAMESPACE__.'\Clientes', 'id', ['alias' => 'Clientes']);
        $this->belongsTo('funcionario_id', __NAMESPACE__.'\Funcionarios', 'id', ['alias' => 'Funcionarios']);
        $this->belongsTo('mesa_id', __NAMESPACE__.'\Mesas', 'id', ['alias' => 'Mesas']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cuentas';
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
