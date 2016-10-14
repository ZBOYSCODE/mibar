<?php

class Mesas extends \Phalcon\Mvc\Model
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
    public $numero;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $seccion;

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
        $this->hasMany('id', 'Cuentas', 'mesa_id', ['alias' => 'Cuentas']);
        $this->hasMany('id', 'Reservas', 'mesa_id', ['alias' => 'Reservas']);
        $this->belongsTo('funcionario_id', 'Funcionarios', 'id', ['alias' => 'Funcionarios']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mesas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Mesas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Mesas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
