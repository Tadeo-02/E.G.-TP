<!-- FOOTER-->
<section id="contact" class="contact section-padding bg-light">
    <div class="container-fluid p-0">
        
      <div class="row g-0 footerDiv">
            <!-- FORMULARIO BOTTOM -->
            <div class="col-md-6 p-4">
                <h4>ESCRIBENOS</h4>
                <form action="#" class="bg-light p-4 m-auto">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input class="form-control" placeholder="Ingrese su nombre" required="" type="text">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input class="form-control" placeholder="Ingrese su dirección de correo electrónico" required="" type="email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="Escriba aquí el mensaje" required="" rows="4"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-lg btn-block mt-3" type="button">Enviar</button>
                    </div>
                </form>
            </div>            
            <!-- INFO BOTTOM -->
            <div class="col-md-6 p-4">
                <div class="bg-light p-4 contactoBottom">
                  
                    <h4><i class="fa-solid fa-map"></i> Dónde estamos</h4>
                    <p><i class="fa-solid fa-map-pin"></i> Tero Volado 2530, Rosario, Santa Fe, Argentina</p>
                    <p><i class="fa-solid fa-phone"></i> Telefeno: 341 0344 0555</p>
                    <h4> <i class="fa-solid fa-clock"></i> Horarios </h4>
                    <ul>
                        <li><p><b>Locales:</b> Lunes a Domngo de 10hs a 21hs</p></li>
                        <li><p><b>Patio de Comidas:</b> Lunes a Domingo desde las 8hs hasta las 00hs</p></li>
                        <li><p><b>Cine:</b> Martes a Domingo desde las 12hs hasta las 1hs</p></li>
                    </ul>
                </div>
            </div>
            <!-- NEWSLETTER  -->
              <div class="col-md-6 p-4">
                <div class="bg-light p-4 contactoBottom">
                    <h4>NEWSLETTER</h4>
                    <p>Recibe las últimas noticias y ofertas especiales</p>
                    <div class="input-group">
                        <form action="./php/newsletter.php" method="POST">
                            <input type="text" class="form-control" placeholder="Ingrese su email" aria-label="Ingrese su email" aria-describedby="button-addon2" name="email">
                            <input type="hidden" name="mensaje" value="Usted ha sido suscripto al Newsletter de Nova Shopping. Gracias por elegirnos"> <br>
                            <input type="hidden" name="asunto" value="Newsletter Nova Shopping"> <br>
                            <button class="btn btn-warning" type="submit" id="button-addon2"  name="botonAnashe">Suscribirse</button>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>            
    </div>
</section>

<footer class="bg-dark p-2 text-center">
    <div class="container">
        <p class="text" style="color: #ffca2c">Todos los derechos reservados</p>
    </div>
</footer>
