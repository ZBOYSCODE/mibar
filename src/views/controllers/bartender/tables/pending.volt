<div id="bartender_tables_details_render">

    <input type="hidden" id='ultima-revision' value='{{ ultima_revision }}'>
    <input type="hidden" id='categoria-producto' value='{{ categoria_producto }}'>
    
    {{ partial("controllers/bartender/tables/element/pedido") }}
</div>