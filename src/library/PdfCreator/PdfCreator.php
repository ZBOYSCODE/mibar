<?php
/**
 * Created by PhpStorm.
 * User: Jorge Cociña
 * Date: 22-09-2016
 * Time: 10:03
 */

namespace App\library\PdfCreator;

use Phalcon\Mvc\User\Component;
use App\library\Auth\Exception;
use Dompdf\Dompdf;

/**
 * Clase creada para renderisar pdf's
 * @author jcocina
 */
class PdfCreator extends Component
{
    private static $domPdf = null;

    private static function initialize() {
        if(!isset(self::$domPdf) or is_null(self::$domPdf))
        {
            self::$domPdf = new DomPdf();
            self::$domPdf->set_option('chroot', '/public/temp');
            self::$domPdf->set_base_path( __DIR__ ."../../../../public");
        }
    }

    /**
     * metodo para renderizar pdf con base en templates
     * @author jcocina
     * @param $template String  nombre del template
     *                          (debe existir en views/pdftemplates)
     *        $psram    array   array donde los keys son los tags del
     *                          template y el value el valor por el que
     *                          se deben reemplazar
     */
    public function createFromTemplate($template, $param, $pdfname) {

        self::initialize();

        $html = '';
        try{
            $html = file_get_contents(  __DIR__ .
                '/../../views/templates/pdftemplates/' .
                $template .
                '.html');
            if ($html == false) {
               return false;
            }
        } catch (Exception $e) {
            return false;
        }
        $tags = array();
        $values = array();
        foreach ($param as $tag=>$value)
        {
            array_push($tags, '{{' . $tag . '}}');
            array_push($values, $value);
        }
        self::$domPdf->setPaper('letter');

        $html = str_replace($tags, $values, $html);


        self::$domPdf->load_html($html);
        self::$domPdf->render();
        self::$domPdf->stream($pdfname,array('Attachment'=>0));
        
        return true;
    }
}