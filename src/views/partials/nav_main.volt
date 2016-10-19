<header>
     <nav class="navbar navbar-fixed-top navbar-background">
        <div class="card">
            <div class="navbar-header">
                <button class="navbar-toggle pull-left" data-toggle="collapse" data-target="#menu">
                    <i class="menu-bars fa fa-bars" aria-hidden="true"></i>                   
                </button>
                <a href="" class="pull-right" title="Ir a Inicio">
                    {{ image("img/mibar.png", "alt":"Logo", "class":"nav-logo img-responsive") }}
                </a>
                <a href="" class="nav-menu-cart pull-right" data-callName="ordersButton" data-url="menu/myOrders">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="nav-menu-cart-cont carro-compra">0</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav navbar-left nav-ul">
                    <li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
                    <li><a href=""><i class="fa fa-list-alt"></i> Menú</a></li>
                    <li><a href=""><i class="fa fa-calculator"></i> Mi Cuenta</a></li>
                    <li><a href=""><i class="fa fa-shopping-cart"></i> Mis Pedidos</a></li>
                    <li><a href="{{ url( 'session/logout') }}"><i class="glyphicon glyphicon-log-out"></i> Salir </a></li>
                </ul>
            </div>                   
        </div>
    </nav> 
</header>