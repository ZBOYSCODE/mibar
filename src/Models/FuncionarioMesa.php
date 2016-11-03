<?php

namespace App\Models;

class FuncionarioMesa extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $funcionario_id;

    /**
     *
     * @var integer
     */
    public $mesa_id;

    /**
     *
     * @var integer
     */
    public $turno_id;

    /**
     *
     * @var datetime
     */
    public $fecha;


    /**
     * Initialize method for model.
     */

    public function initialize()
    {
        $this->belongsTo('funcionario_id', __NAMESPACE__.'\Funcionarios', 'id', ['alias' => 'Funcionarios']);
        $this->belongsTo('mesa_id', __NAMESPACE__.'\Mesas', 'id', array('alias' => 'Mesas'));
        $this->belongsTo('turno_id', __NAMESPACE__.'\Turnos', 'id', array('alias' => 'Turnos'));

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'funcionario_mesa';
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
