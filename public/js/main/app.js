window.App = (function($, win, doc, undefined) {


    //seteamos el valor de los inputs con id fecha
    var fecha_servidor =  $("#fecha").val();

    //si no esta seteado sacamos la fecha de hoy del cliente.
    if(typeof fecha_servidor === "undefined")
        fecha_servidor = new Date();

    uiInit = function () {
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: ' <Atrás',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            setDate: fecha_servidor,
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            minDate: 0,
            yearSuffix: ''
        };


        $.datepicker.setDefaults($.datepicker.regional['es']);


        $('.datepicker').datepicker({
            startDate: '-3d',
            onSelect: function (dateText, inst) {
                $(this).prev('input').val(dateText);
                $(this).change();
            }
        });

        $('.chosen-select').chosen({width: "100%"});

        $('[data-toggle="tooltip"]').tooltip();


        $('#since').datepicker();
        $('#until').datepicker();


    },

    animations = function () {

        $(document).on('click', ".btnAjax", function () {

            $(this).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Cargando..')
                .attr('disabled', 'disabled');
        });
    },


    stopAnimation = function (animation_name, btn, html) {

        if( typeof html == 'undefined' )
            html = "";

        switch(animation_name) {
            case "btnAjax":
                if(html != null){
                    btn.html(html)
                        .prop("disabled", false);
                }
                else if(html != null &&  html == ""){
                    btn.html("Repetir")
                        .prop("disabled", false);
                }
                break;
            default:
                return;

        }

    }




    return {
        init: function() {
            uiInit();
            animations();
        },
        stopAnimation: function(e, btn, html) {
            stopAnimation(e, btn, html);
        }
    };
}(jQuery, this, document));


$(window.App.init);



