<?php
namespace App\Models;


use Phalcon\Mvc\Model\Validator\Email as Email;

class Clientes extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $fecha_nacimiento;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $tipo_cliente_id;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        /*$this->validate(
            new Email(
                [
                    'field'    => 'email',
                    'required' => true,
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }*/

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Cuentas', 'cliente_id', ['alias' => 'Cuentas']);
        $this->hasMany('id', 'Reservas', 'cliente_id', ['alias' => 'Reservas']);
        $this->belongsTo('tipo_cliente_id', 'TipoClientes', 'id', ['alias' => 'TipoClientes']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'clientes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clientes[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clientes
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
