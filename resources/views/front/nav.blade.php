<header id="header" class="header header-transparent header-layout1">
    <nav class="navbar navbar-expand-lg sticky-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.html">
          <img src="assets/images/logo/LogoDeliveryLight.png" class="logo-light" alt="logo">
          <img src="assets/images/logo/LogoDeliveryDark.png" class="logo-dark" alt="logo">
        </a>
        <button class="navbar-toggler" type="button">
          <span class="menu-lines"><span></span></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavigation">
          <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav__item with-dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle nav__item-link active">{{Auth::user()->username}}</a>
                    <ul class="dropdown-menu">
                    <li class="nav__item"><a href="{{ route('logout') }}" class="nav__item-link" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Cerrar Sesion</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    <li class="nav__item"><a href="home-gourmet.html" class="nav__item-link">Ajustes</a></li>
                    </ul>
                </li>
            @else
                <li class="nav__item"><a href="/login" class="nav__item-link">Iniciar Sesion</a></li>
                <li class="nav__item"><a href="#" class="nav__item-link">Registrarse</a></li>
            @endauth
          </ul>
        </div>
        <div class="navbar-actions-wrap">
          <div class="navbar-actions d-flex align-items-center">
            <a href="#" class="navbar__action-btn search-popup-trigger"><i class="fa fa-search"></i></a>
            <a href="#" class="navbar__action-btn navbar__action-btn-cart">
                <i class="icon-cart"></i><span class="cart__label">3</span>
              </a>
              <div class="cart-popup">
                <ul class="list-unstyled">
                @for ($i = 0; $i < 2; $i++)
                   <li class="cart-item">
                    <div class="cart__item-img"><img src="assets/images/shop/grid/1.jpg" alt="thumb"></div>
                    <div class="cart__item-content">
                      <h6 class="cart__item-title">1/4 Pollo a la brasa</h6>
                      <div class="cart__item-detail">S/. 8.00</div>
                      <i class="cart__item-delete">&times;</i>
                    </div><!-- /.cart-item-content -->
                  </li>
                @endfor


                </ul>
                <div class="cart-subtotal">
                  <span>Total:</span>
                  <span class="color-theme">S/ 16.00</span>
                </div><!-- /.cart-subtotal -->
                <div class="cart-action d-flex justify-content-between">
                  <a href="#" class="btn btn__primary btn__hover2">Ver Pedidos</a>
                  <a href="#" class="btn btn__white">Finalizar</a>
                </div><!-- /.cart-action -->
              </div><!-- /.cart-popup -->
          </div>
        </div>
      </div>
    </nav>
</header>
