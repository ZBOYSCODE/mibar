<div id="pagar-modal" class="menu-products-list-modal modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header card">
                <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-list-alt"></i> Pago</h4>
            </div>
            <div class="row user-details card">

                <div class="col-xs-12 col-md-12">
                    <p class="card-small-font-size">Nº mesa: {{ mesa.numero }} <br>
                    N° cuenta: {{ cuenta }} <br>
                    Cliente: {{ cliente.nombre  }} {% if cliente.apellido != null %}{{ cliente.apellido }}{% endif %} </p>
                </div>
            </div>
            <div class="modal-body">
                <!-- Products -->

                <div class="lista_pedidos">

                    <div class="card">
                        <div class="product-item-modal">
                            <p class="title"><i class="fa fa-glass"></i> Productos/Pedidos</p>
                            {% for producto in productos %}
                                <div class="row">
                                    <div class="col-xs-8 col-md-8">{{ producto.nombre }}</div>
                                    <div class="col-xs-4 col-md-4">${{ utility._number_format(producto.precio) }}</div>
                                </div>
                            {% endfor %}
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="row margin-top-10">
                        <div class="col-md-8 col-xs-8">
                            <p><i class="fa fa-plus"></i> Subtotal:</p>
                        </div>
                        <div id="subtotal" class="col-md-4 col-xs-4">
                            ${{ utility._number_format(subtotal) }}
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-xs-5 col-sm-5 ">
                            <p><i class="fa fa-minus"></i> Descuento:</p>
                        </div>
                        <div class="col-xs-5 col-sm-5 ">
                            <input class="form-control" id="descuento" name="decuento" type="number" placeholder="$ 0">
                        </div>
                        <div class="col-xs-2 col-sm-2 ">
                            <button 
                                class="btn btn-small btn-main pull-right btn-main-margin-bottom-sm" 
                                id="btn-descuento"
                                data-callName='updatePrecio'
                                data-url="{{ url('cashbox/updescuento') }}"
                                data-cuenta="{{ cuenta_id }}"
                                ><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer card">
                <div class="row">
                    <div class="col-xs-8 col-sm-8">
                        <span class="precio-total">Total: <i class="fa fa-usd"></i> <span id="total">{{ utility._number_format(subtotal) }}</span></span>
                    </div>
                    <div class="col-xs-4 col-sm-4">
                        <input id="descuentoinput" type="hidden" value="0">
                        <button id="btn-pagar" class="btn btn-small btn-main pull-right"
                              data-callName="completarPago"
                              data-url="{{ url("cashbox/completarpago") }}"
                              data-cuenta="{{ cuenta_id }}">
                            Pagar
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>