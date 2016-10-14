<?php
namespace App\Models;

class Stock extends \Phalcon\Mvc\Model
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
    public $producto_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $cantidad;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $bodega_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $precio_compra;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('bodega_id', 'Bodegas', 'id', ['alias' => 'Bodegas']);
        $this->belongsTo('producto_id', 'Productos', 'id', ['alias' => 'Productos']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'stock';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stock[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stock
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
