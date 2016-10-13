<?php

namespace App\Models;

class Favorites extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $table;

    /**
     *
     * @var integer
     */
    public $register_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('user_id', __NAMESPACE__.'\Users', 'id', array('alias' => 'Users'));
        $this->belongsTo('register_id', __NAMESPACE__.'\Diagnostics', 'id', array('alias' => 'Diagnostics'));
        $this->belongsTo('register_id', __NAMESPACE__.'\Drugs', 'id', array('alias' => 'Drugs'));
        $this->belongsTo('register_id', __NAMESPACE__.'\Exams', 'id', array('alias' => 'Exams'));
        $this->belongsTo('register_id', __NAMESPACE__.'\Process', 'id', array('alias' => 'Process'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'favorites';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Favorites[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Favorites
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
