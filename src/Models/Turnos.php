<?php

namespace App\Models;

class Turnos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var time
     */
    public $hora_inicio;

    /**
     *
     * @var time
     */
    public $hora_termino;

    /**
     *
     * @var string
     */
    public $descripcion;


    /**
     * Initialize method for model.
     */

    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__.'\FuncionarioMesa', 'turno_id', array('alias' => 'FuncionarioMesa'));
        
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'turnos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Roles[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Roles
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
