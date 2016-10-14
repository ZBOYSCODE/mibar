<?php
namespace App\Models;

class SubcategoriaProductos extends \Phalcon\Mvc\Model
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
    public $categoria_producto_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $nombre;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Productos', 'subcategoria_id', ['alias' => 'Productos']);
        $this->belongsTo('categoria_producto_id', 'CategoriaProductos', 'id', ['alias' => 'CategoriaProductos']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'subcategoria_productos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SubcategoriaProductos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SubcategoriaProductos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
