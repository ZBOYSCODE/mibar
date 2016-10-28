<header>
    <nav class="navbar navbar-fixed-top navbar-background">
        <div class="card">
            <div class="navbar-header">
                <button class="navbar-toggle pull-left" data-toggle="collapse" data-target="#menu">
                    <i class="menu-bars fa fa-bars" aria-hidden="true"></i>
                </button>
                <a href="" class="pull-right">
                    {{ image("img/avatars/default.png", "alt":"Avatar", "class":"nav-avatar img-responsive") }}
                </a>
            </div>
            <div class="collapse navbar-collapse" id="menu">


                <ul class="nav navbar-nav navbar-left nav-ul">
                    <li><a href=""><i class="fa fa-bell-o"></i> Ordenes</a></li>
                    <li><a href="{{ url( 'session/logout') }}"><i class="glyphicon glyphicon-log-out"></i> Salir </a></li>
                </ul>


            </div>
        </div>
    </nav>
</header>