<?php
    /**
     * Modelo de negocio Productos
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * para el control de los productos
     *
     * @package      MiBar
     * @subpackage   Business
     * @category     Access Business
     * @author       Zenta Group
     */
    namespace App\Business;

    use App\Models\Productos;
    use App\Models\CategoriaProductos;
    use App\Models\SubcategoriaProductos;

    use Phalcon\Mvc\User\Plugin;

    /**
     * Modelo de negocio Productos
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * para el control de los productos
     *
     * @author zenta group
     */
    class ProductoBSN extends Plugin
    {
        /**
         *
         * @var array
         */
        public 	$error;


    /**
     * @author jcocina
     * @param $param    array   id => int
     *                  opcionalmente puede ser una lista de ints
     *                  array(1, 2, 3)
     * @return bool false en caso de error
     */
    public function getProductDetails($param) {
        if ((!isset($param['id']) or !is_int($param['id'])) and sizeof($param) == 0) {
            $this->error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }
        if (isset($param['id']) and is_int($param['id'])) {
            $result = Productos::findFirstById($param['id']);
            if (sizeof($result) == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }
            return $result;
        }
        if (is_array($param) and sizeof($param) > 1) {
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

        /**
         * Lista de categorias
         *
         * retorna el listado de categorías
         *
         * @author Sebastián Silva C
         *
         * @return object
         */
        public function getListCategories() {

            $categorias = CategoriaProductos::find();

            if($categorias->count() == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $categorias;
        }


        /**
         * Lista de categorias por id
         *
         * retorna el listado de categorías
         *
         * @author Jorge Silva A
         *
         * @return object
         */
        public function getListCategoriesByName($param) {

            if(!isset($param["nombre"])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $categoria = CategoriaProductos::findFirst("nombre = '{$param["nombre"]}'");

            if( $categoria == false ) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $categoria;
        }
        
        /**
         * Lista de subcategorías
         *
         * retorna el listado de subcategorías filtradas por categoría
         *
         * @author Sebastián Silva C
         *
         * @param array $param
         * @return object
         */
        public function getListSubCategoriesByCategory($param) {

            if( !isset( $param['categoria_id'] )) {

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $categorias = SubcategoriaProductos::findByCategoriaProductoId($param['categoria_id']);

            if($categorias->count() == 0) {

                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $categorias;
        }
        
        /**
         * Lista de productos 
         *
         * retorna el listado de productos filtrados por categoría
         *
         * @author Sebastián Silva C
         *
         * @return object
         */
        public function getProductsbyCategory($param) {

            if(!isset($param['categoria_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            } 

            $list = Productos::query()
                ->leftJoin('App\Models\SubcategoriaProductos', 'App\Models\Productos.subcategoria_id = Subcategoria.id', 'Subcategoria')
                ->leftJoin('App\Models\CategoriaProductos', 'Subcategoria.categoria_producto_id = CategoriaProductos.id', 'CategoriaProductos')
                ->where("CategoriaProductos.id = {$param['categoria_id']}")
                ->execute();    

            if(!$list){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;   
                return false;
            }
            return $list;
        }

        /**
         * Lista de productos 
         *
         * retorna el listado de productos filtrados por subcategoría
         *
         * @author Sebastián Silva C
         *
         * @return object
         */
        public function GetProductsbySubCategory($param) {

            if( !isset( $param['subcategoria_id'] )) {

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $productos = Productos::findBySubcategoriaId($param['subcategoria_id']);

            if($productos->count() == 0) {

                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $productos;
        }


         /**
         * getPreciosProducto
         *
         * retorna la lista de los precios
         *
         * @author osanmartin
         *
         * @param array $param : array de promociones u objetos
         *                        con el siguiente formato:
         *                          ["es_promocion" => boolean,
         *                           "producto_id" => integer];
         * @return array [id => precio]
         */
        public function getPreciosProducto($param){

            $list = array();

            if( count($param) == 0 ){
                return array();
            }

            foreach ($param as $val) {

                if( ! $val["es_promocion"] ){

                    array_push($list, $val["producto_id"] );
                }
            }

            if(!count($list)){
                return array();
            }

            $list = implode(',', $list);

            $find = "id IN (".$list.")";

            $productos = Productos::find($find);

            
            if(!$productos->count()) {

                return array();

            } else {
                
                $arr = array();
                
                foreach ($productos as $producto) {

                    $arr[$producto->id] = $producto;
                }
            }

            return $arr;
        } 

        /**
         * getPrecioById
         * funcion corta
         * @author Sebastián Silva 
         * @param $id identificador producto 
         */   
        public function getPrecioById($id) {

            $producto = Productos::findFirstById($id);


            if(!$producto) {
                return 0;
            } else {
                return $producto->precio;
            }
        }

        /**
         * getPromocion
         *
         * @author jcocina
         * @param $param['promocion_id'] = ID de promocion
         * @return objeto Promocion
         */
        public function getProducto($param){

            if(!isset($param['producto_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
            }

            if(isset($param['producto_id']))
                $result = Productos::findFirstById($param['producto_id']);

            if(!$result->count()){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $result;
        }
}

