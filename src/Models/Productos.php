<?php
namespace App\Models;

class Productos extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $nombre;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $precio;

    /**
     *
     * @var string
     * @Column(type="string", length=250, nullable=false)
     */
    public $descripcion;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $subcategoria_id;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $codigo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__.'\Pedidos', 'producto_id', ['alias' => 'Pedidos']);
        $this->hasMany('id', __NAMESPACE__.'\ProdPromo', 'producto_id', ['alias' => 'ProdPromo']);
        $this->hasMany('id', __NAMESPACE__.'\ProducPromoPedidos', 'producto_id', ['alias' => 'ProducPromoPedidos']);
        $this->hasMany('id', __NAMESPACE__.'\Stock', 'producto_id', ['alias' => 'Stock']);
        $this->belongsTo('subcategoria_id', __NAMESPACE__.'\SubcategoriaProductos', 'id', ['alias' => 'SubcategoriaProductos']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'productos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Productos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Productos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
