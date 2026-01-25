<style>
    /* 1. Control the wrapper to prevent growth and center it */
    .input-wrapper {
        position: relative;
        width: 100%;
        max-width: 350px; /* Increased to 350px to make inputs bigger/standard */
        margin: 0 auto;   /* This centers the input on the screen */
    }

    /* 2. Custom Input Style (applies to both text and password) */
    .custom-dark-input {
        background-color: #212529 !important;
        color: white !important;
        border: 1px solid #0d6efd;
        border-radius: 50px !important;
        padding-left: 20px;
        padding-right: 20px; /* Standard padding */
        text-align: center;  /* Keeps the text/dots centered inside the pill */
        width: 100%;         /* Fills the wrapper */
        height: 50px;        /* Optional: Makes the input taller/bigger */
    }

    /* Specific padding for password to accommodate the eye icon */
    .password-padding {
        padding-right: 45px !important;
    }

    .custom-dark-input:focus {
        background-color: #212529 !important;
        color: white !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* 3. Eye Icon Positioning */
    .eye-btn {
        position: absolute;
        right: 15px;      /* Distance from the right edge */
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        cursor: pointer;
        padding: 0;
        z-index: 10;
        color: #6c757d;
        display: flex;
        align-items: center;
    }
</style>

<section id="about" class="about">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <form action="" method="POST" class="form" autocomplete="on" style="padding: 20px;">
                    <h1 class="text-center" style="margin-bottom: 30px;">INICIO DE SESIÓN</h1>

                    <div class="mb-3 text-center">
                        <label for="nombreUsuarioLogin">Correo electrónico:</label>
                        <div class="input-wrapper">
                            <input 
                                id="nombreUsuarioLogin" 
                                class="form-control custom-dark-input" 
                                type="email" 
                                name="nombreUsuario" 
                                placeholder="alguien@ejemplo.com" 
                                maxlength="70" 
                                required 
                                aria-describedby="emailLoginHelp">
                        </div>
                        <small id="emailLoginHelp" class="form-text text-muted" style="margin-top: 5px; display:block;">Introduce un correo válido.</small>
                    </div>

                    <div class="mb-3 text-center">
                        <label for="claveUsuarioLogin">Contraseña:</label>
                        
                        <div class="input-wrapper">
                            <input 
                                id="claveUsuarioLogin" 
                                class="form-control custom-dark-input password-padding" 
                                type="password" 
                                name="claveUsuario" 
                                pattern="[a-zA-Z0-9$@.-]{7,100}" 
                                maxlength="100" 
                                placeholder="********" 
                                required 
                                aria-describedby="passwordLoginHelp">

                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('claveUsuarioLogin', 'toggleIconLogin')" 
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña" 
                                tabindex="-1">
                                <i id="toggleIconLogin" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                        
                        <small id="passwordLoginHelp" class="form-text text-muted" style="margin-top: 5px; display:block;">La contraseña debe tener al menos 7 caracteres.</small>
                    </div>

                    <div class="text-center" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-primary" value="Ingresar" href="">Confirmar</button>
                        <p style="margin-top: 15px;">
                            <a href="index.php?vista=signUp" aria-label="Crear una nueva cuenta">Crear Cuenta</a>
                        </p>
                    </div>

                    <?php
                        if(isset($_POST['nombreUsuario']) && isset($_POST['claveUsuario'])){ 
                            require_once "./php/main.php";
                            require_once "./php/loginUser.php";
                        }
                    ?>

                </form>

                <script>
                    function togglePasswordVisibility(inputId, iconId) {
                        const input = document.getElementById(inputId);
                        const icon = document.getElementById(iconId);
                        
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</section>