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
     * @Column(type="integer", length=11, nullable=false)
     */
    public $pago_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $estado;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $bar_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Pedidos', 'cuenta_id', ['alias' => 'Pedidos']);
        $this->belongsTo('bar_id', 'Bares', 'id', ['alias' => 'Bares']);
        $this->belongsTo('cliente_id', 'Clientes', 'id', ['alias' => 'Clientes']);
        $this->belongsTo('funcionario_id', 'Funcionarios', 'id', ['alias' => 'Funcionarios']);
        $this->belongsTo('mesa_id', 'Mesas', 'id', ['alias' => 'Mesas']);
        $this->belongsTo('pago_id', 'Pagos', 'id', ['alias' => 'Pagos']);
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
