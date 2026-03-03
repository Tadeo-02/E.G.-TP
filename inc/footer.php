<!-- FOOTER-->
<section id="contact" class="contact section-padding bg-light">
    <h2 class="visually-hidden">Contacto</h2>
    <div class="container-fluid p-0">
        
      <div class="row g-0 footerDiv">
            <!-- FORMULARIO BOTTOM -->
            <div class="col-md-6 p-4">
                <h3>Escríbenos</h3> 
                <form action="#" class="bg-light p-4 m-auto needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombreContacto" class="form-label">Nombre</label>
                                <input id="nombreContacto" class="form-control" type="text" placeholder="Juan Pérez" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="telefonoContacto" class="form-label">Teléfono</label>
                                <input id="telefonoContacto" class="form-control" placeholder="+54 341 123 4567" type="tel" pattern="[0-9\s\-\+\(\)]+" title="Solo números, espacios, guiones, + y paréntesis">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="emailContacto" class="form-label">Correo electrónico</label>
                                <input id="emailContacto" class="form-control" placeholder="tu-correo@ejemplo.com" type="email" required aria-describedby="emailError">
                                <div class="invalid-feedback">
                                    Ingrese un correo válido con formato nombre@dominio.com
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="asuntoContacto" class="form-label">Asunto</label>
                                <input id="asuntoContacto" class="form-control" placeholder="Motivo de su consulta" required type="text">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="mensajeContacto" class="form-label">Mensaje</label>
                                <textarea id="mensajeContacto" class="form-control" placeholder="Escriba aquí su consulta o comentario..." required rows="4"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-lg btn-block mt-3" type="submit">Enviar</button> 
                    </div>
                </form>
            </div>      
            <!-- INFO BOTTOM -->
            <div class="col-md-6 p-4">
                <div class="bg-light p-4 contactoBottom">
                  
                    <h3>
                        <i class="fa-solid fa-map" aria-hidden="true"></i>
                        <span>Dónde estamos</span>
                    </h3>
                    <p>
                        <i class="fa-solid fa-map-pin" aria-hidden="true"></i> 
                        <span>Tero Volado 2530, Rosario, Santa Fe</span>
                    </p>
                    <p>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <span>Teléfono: 341 0344 0555</span>
                    </p>
                    <h3>
                        <i class="fa-solid fa-clock" aria-hidden="true"></i>
                        <span>Horarios</span>
                    </h3>
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
                        <div id="newsletterMsg" tabindex="-1"></div>
                        <form id="newsletterForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="emailNewsletter" class="form-label">Correo electrónico</label>
                                <input id="emailNewsletter"
                                    class="form-control"
                                    type="email"
                                    required
                                    placeholder="tu-correo@ejemplo.com">
                                <div class="invalid-feedback">
                                    Se requiere un correo electrónico válido.
                                </div>
                            </div>

                            <button class="btn btn-warning" type="submit">
                                Suscribirse
                            </button>
                        </form>
                </div>
        </div>            
    </div>
</section>

<footer class="bg-dark p-2 text-center">
    <div class="container">
        <p class="text" style="color: #e0a800">Todos los derechos reservados</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletterForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = document.getElementById('emailNewsletter');
        const msgDiv = document.getElementById('newsletterMsg');
        const btn = form.querySelector('button[type="submit"]');
        const email = emailInput.value.trim();

        if (!email) return;

        // Deshabilitar botón mientras se envía
        btn.disabled = true;
        btn.textContent = 'Enviando...';
        msgDiv.innerHTML = '';

        const formData = new FormData();
        formData.append('emailNewsletter', email);

        fetch('php/newsletterSubscribe.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const tipo = data.success ? 'success' : 'danger';
            msgDiv.innerHTML = '<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">'
                + data.message
                + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar mensaje"></button>'
                + '</div>';
            if (data.success) {
                emailInput.value = '';
            }
        })
        .catch(function() {
            msgDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                + 'Error de conexión. Intenta de nuevo más tarde.'
                + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar mensaje"></button>'
                + '</div>';
        })
        .finally(function() {
            btn.disabled = false;
            btn.textContent = 'Suscribirse';
        });
    });
});
</script>
