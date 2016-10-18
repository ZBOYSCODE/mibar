<?php
namespace App\Models;

class Pedidos extends \Phalcon\Mvc\Model
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
    public $cuenta_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $producto_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $promocion_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $precio;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $comentario;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $estado_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__.'\ProducPromoPedidos', 'pedido_id', ['alias' => 'ProducPromoPedidos']);
        $this->belongsTo('cuenta_id', __NAMESPACE__.'\Cuentas', 'id', ['alias' => 'Cuentas']);
        $this->belongsTo('estado_id', __NAMESPACE__.'\Estados', 'id', ['alias' => 'Estados']);
        $this->belongsTo('producto_id', __NAMESPACE__.'\Productos', 'id', ['alias' => 'Productos']);
        $this->belongsTo('promocion_id', __NAMESPACE__.'\Promociones', 'id', ['alias' => 'Promociones']);
    }

    public function beforeValidationOnCreate()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }    

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pedidos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pedidos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pedidos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
