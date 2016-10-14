<?php

class ProdPromo extends \Phalcon\Mvc\Model
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
    public $promocion_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('producto_id', 'Productos', 'id', ['alias' => 'Productos']);
        $this->belongsTo('promocion_id', 'Promociones', 'id', ['alias' => 'Promociones']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'prod_promo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProdPromo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProdPromo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
