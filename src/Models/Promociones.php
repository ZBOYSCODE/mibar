<?php

class Promociones extends \Phalcon\Mvc\Model
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
    public $nombre;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $tipo_promo_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $precio;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Pedidos', 'promocion_id', ['alias' => 'Pedidos']);
        $this->hasMany('id', 'ProdPromo', 'promocion_id', ['alias' => 'ProdPromo']);
        $this->belongsTo('tipo_promo_id', 'TipoPromo', 'id', ['alias' => 'TipoPromo']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'promociones';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Promociones[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Promociones
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
