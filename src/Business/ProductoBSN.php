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
        public function GetProductsbyCategory($param) {

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

    }
