<?php

class Reservas extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(type="string", length=250, nullable=false)
     */
    public $descripcion;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $fecha;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $monto_garantia;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $estado_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('cliente_id', 'Clientes', 'id', ['alias' => 'Clientes']);
        $this->belongsTo('estado_id', 'Estados', 'id', ['alias' => 'Estados']);
        $this->belongsTo('mesa_id', 'Mesas', 'id', ['alias' => 'Mesas']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'reservas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Reservas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Reservas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
