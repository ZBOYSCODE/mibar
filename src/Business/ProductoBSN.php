<?php

namespace App\Business;


use Phalcon\Mvc\User\Plugin;
use App\Models\Productos;

class ProductoBSN extends Plugin
{
    /**
     *
     * @var array
     */
    public 	$error;

    public function getProductDetails($param) {
        if (!is_int($param) and sizeof($param) == 0) {
            $this->error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }
        if (is_int($param)) {
            $result = Productos::findFirstById($param);
            if (sizeof($result) == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }
            return $result;
        }
        if (is_array($param)) {
            $where = "id in (" .$param[0] . ")";
            for ($i = 1; $i < sizeof($param) - 1; $i++) {
                $where = str_replace(')', ', ' . $param[$i] . ')', $where);
            }
            $result = Productos::find($where);
            if ($result->count() == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }
            return $result;
        }

        $this->error[] = $this->errors->UNKNOW;
        return false;
    }
}