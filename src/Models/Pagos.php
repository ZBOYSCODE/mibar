<?php
namespace App\Models;

class Pagos extends \Phalcon\Mvc\Model
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
    public $descuento_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $fecha;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $medio_pago;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $funcionario_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $subtotal;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $Total;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Cuentas', 'pago_id', ['alias' => 'Cuentas']);
        $this->belongsTo('descuento_id', 'Descuentos', 'id', ['alias' => 'Descuentos']);
        $this->belongsTo('funcionario_id', 'Funcionarios', 'id', ['alias' => 'Funcionarios']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pagos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pagos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pagos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
