<?php
namespace App\Models;

use Phalcon\Mvc\Model\Validator\Email as Email;

class Funcionarios extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=50, nullable=false)
     */
    public $apellido;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $email;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $telefono;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $rol_id;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                [
                    'field'    => 'email',
                    'required' => true,
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__.'\Cuentas', 'funcionario_id', ['alias' => 'Cuentas']);
        $this->hasMany('id', __NAMESPACE__.'\Mesas', 'funcionario_id', ['alias' => 'Mesas']);
        $this->hasMany('id', __NAMESPACE__.'\Pagos', 'funcionario_id', ['alias' => 'Pagos']);
        $this->hasMany('id', __NAMESPACE__.'\ProducPromoPedidos', 'funcionario_id', ['alias' => 'ProducPromoPedidos']);
        $this->hasMany('id', __NAMESPACE__.'\FuncionarioMesa', 'funcionario_id', ['alias' => 'FuncionarioMesa']);        
        $this->belongsTo('rol_id', __NAMESPACE__.'\Roles', 'id', ['alias' => 'Roles']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'funcionarios';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Funcionarios[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Funcionarios
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
