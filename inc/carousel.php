<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
      <h1 class="visually-hidden">Nova Shopping - Centro Comercial en Rosario</h1>
      <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
       <div class="carousel-item active">
        <img src="img/home-1.jpg" class="d-block w-100" 
                title="Eventos y actividades mensuales"
                alt="Galería comercial con techo curvo y mensaje sobre eventos y actividades mensuales."> 
            <p id="desc-detallada-1" class="visually-hidden">
                Interior de un centro comercial con tiendas a ambos lados del pasillo principal y escaleras mecánicas. El contenido promociona eventos y actividades mensuales e invita a conocer novedades.
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
                  title="Variedad de locales"
                  alt="Centro comercial con múltiples niveles y mensaje sobre variedad de locales disponibles."> 
              <p id="desc-detallada-2" class="visually-hidden">
                  Vista interior de un shopping con personas circulando entre distintos locales comerciales conectados por escaleras mecánicas. La diapositiva destaca la diversidad de rubros disponibles.
              </p>
          <div class="carousel-caption">
             <h2>VARIEDAD DE LOCALES A TU DISPOSICIÓN</h2>
             <p>Numerosos locales de todo tipo de rubro</p>
             <p><a href="index.php?vista=localsList" class="btn btn-warning mt-3">Ver locales del shopping</a></p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/home-3.jpg" class="d-block w-100" 
                  title="Cine y patio de comidas"
                  alt="Interior de shopping con escaleras mecánicas y mensaje sobre cine, patio de comidas y promociones."> 
              <p id="desc-detallada-3" class="visually-hidden">
                  Imagen del interior de un centro comercial de varios niveles con locales abiertos y escaleras mecánicas centrales. La diapositiva promociona la oferta de cine, patio de comidas y promociones semanales.
              </p>
          <div class="carousel-caption">
            <h2>CINE, PATIO DE COMIDAS Y MÁS</h2>
            <p>Variedad de promociones todas las semanas</p>
            <p><a href="index.php?vista=promocionesList" class="btn btn-warning mt-3">Ver promociones del shopping</a></p>
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