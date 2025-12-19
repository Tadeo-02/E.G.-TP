<!-- FOOTER-->
<section id="contact" class="contact section-padding bg-light">
    <div class="container-fluid p-0">
        
      <div class="row g-0 footerDiv">
            <!-- FORMULARIO BOTTOM -->
            <div class="col-md-6 p-4">
                <h3>ESCRIBENOS</h3>
                <form action="#" class="bg-light p-4 m-auto">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombreContacto" class="visually-hidden">Nombre</label>
                                <input id="nombreContacto" class="form-control" placeholder="Ingrese su nombre" required type="text">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="emailContacto" class="visually-hidden">Correo electrónico</label>
                                <input id="emailContacto" class="form-control" placeholder="Ingrese su correo" required type="email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="mensajeContacto" class="visually-hidden">Mensaje</label>
                                <textarea id="mensajeContacto" class="form-control" placeholder="Escriba aquí" required rows="4"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-lg btn-block mt-3" type="submit">Enviar</button> 
                    </div>
                </form>
            </div>      
            <!-- INFO BOTTOM -->
            <div class="col-md-6 p-4">
                <div class="bg-light p-4 contactoBottom">
                  
                    <h3><i class="fa-solid fa-map"></i> Dónde estamos</h3>
                    <p><i class="fa-solid fa-map-pin"></i> Tero Volado 2530, Rosario, Santa Fe, Argentina</p>
                    <p><i class="fa-solid fa-phone"></i> Telefeno: 341 0344 0555</p>
                    <h3> <i class="fa-solid fa-clock"></i> Horarios </h3>
                    <dl>
                        <dt>Locales:</dt>
                        <dd>Lunes a Domingo de 10hs a 21hs</dd>
                        <dt>Patio de Comidas:</dt>
                        <dd>Lunes a Domingo desde las 8hs hasta las 00hs</dd>
                        <dt>Cine:</dt>
                        <dd>Martes a Domingo desde las 12hs hasta las 1hs</dd>
                    </dl>

                </div>
            </div>
            <!-- NEWSLETTER  -->
                <div class="col-md-6 p-4">
                    <div class="bg-light p-4 contactoBottom">
                        <h3>NEWSLETTER</h3>
                        <p>Recibe las últimas noticias y ofertas especiales</p>
                        <div class="input-group">
                            <form onsubmit="event.preventDefault(); alert('Funcionalidad deshabilitada.');">
                                <label for="emailNewsletter" class="visually-hidden">Email para newsletter</label>
                                <input id="emailNewsletter" type="email" class="form-control" placeholder="Ingrese su email" name="email" required>
                                <br>
                                <button class="btn btn-warning" type="submit" id="button-addon2">Suscribirse</button>
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
