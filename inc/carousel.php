<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
       <div class="carousel-item active">
          <img src="img/home-1.jpg" class="d-block w-100" alt="Fachada Nova Shopping" aria-describedby="desc-detallada-1">
          <p id="desc-detallada-1" class="visually-hidden">
            El centro comercial Nova presenta una arquitectura moderna con tres niveles, iluminación LED decorativa y zonas verdes en la entrada principal.
          </p>
          <div class="carousel-caption">
            <h2>EL SHOPPING QUE BUSCAS</h2>
                <p>Diferentes eventos y actividades todos los meses</p>
                <?php if(isset($_SESSION['codUsuario']) && $_SESSION['codUsuario']!=""){ ?>
                    <p><a href="index.php?vista=novedadesList&page=" class="btn btn-warning mt-3">Ver novedades del shopping</a></p>
                <?php } else { ?>
                    <p><a href="index.php?vista=login" class="btn btn-warning mt-3">Inicia sesión para ver las novedades</a></p>
                <?php } ?>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/home-2.jpg" class="d-block w-100" 
                alt="Pasillo del shopping con variedad de locales comerciales" 
                aria-describedby="desc-detallada-2">
            <p id="desc-detallada-2" class="visually-hidden">
              El pasillo principal es amplio y luminoso, con pisos de porcelanato brillante. 
              Se observan vitrinas modernas de tiendas de ropa, calzado y accesorios a ambos lados, con señalética clara en el techo indicando las salidas de emergencia.
            </p>
          <div class="carousel-caption">
             <h2>VARIEDAD DE LOCALES A TU DISPOSICIÓN</h2>
             <p>Numerosos locales de todo tipo de rubro</p>
             <p><a href="vistas/localsList.php?page=" class="btn btn-warning mt-3">Ver locales del shopping</a></p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/home-3.jpg" class="d-block w-100" 
                alt="Área de entretenimiento del shopping con cine y patio de comidas" 
                aria-describedby="desc-detallada-3">
            <p id="desc-detallada-3" class="visually-hidden">
              Vista del tercer nivel donde se encuentra el complejo de cines con carteleras digitales. 
              Adyacente está el patio de comidas con mesas de madera, sillas coloridas y diversas opciones gastronómicas que incluyen comida rápida, helados y café.
            </p>
          <div class="carousel-caption">
            <h2>CINE, PATIO DE COMIDAS Y MÁS</h2>
            <p>Variedad de promociones todas las semanas</p>
            <p><a href="vistas/promocionesList.php?page=" class="btn btn-warning mt-3">Ver promociones del shopping</a></p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
</div>