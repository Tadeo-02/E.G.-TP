<style>
    /* 1. The Wrapper acts as the dynamic container */
    .input-wrapper {
        position: relative;
        /* Start with the smaller size */
        width: 200px; 
        max-width: 100%; /* Safety on mobile */
        height: 50px;
        margin: 0 auto; /* Centers the wrapper */
        z-index: 1;
        /* The Animation Logic */
        transition: width 0.4s ease-in-out;
    }

    /* 2. When the user clicks inside the wrapper (focus-within), expand it */
    .input-wrapper:focus-within {
        width: 350px; /* Expands to your desired max width */
    }

    /* 3. The Input just fills the wrapper */
   .custom-dark-input {
        background-color: #212529 !important;
        color: white !important;
        border: 1px solid #0d6efd;
        border-radius: 50px !important;
        
        /*  input to match wrapper exactly */
        width: 100% !important; 
        max-width: 100% !important;
        height: 50px;
        box-sizing: border-box !important; /* Includes padding in the width calculation */
        
        /* Padding for text (left) and icon (right) */
        padding-left: 20px; 
        padding-right: 45px; 
        text-align: center;
    }

    .custom-dark-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        outline: none;
    }

    /* 4. The Eye Icon - Now pinned to the dynamic wrapper */
    .eye-btn {
        position: absolute;
        right: 15px; /* Distance from the edge of the WRAPPER */
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        cursor: pointer;
        z-index: 10;
        color: #6c757d;
        display: flex;
        align-items: center;
     /*impide que la transicion suba el input */   
        height: 24px;
        width: 35px;
        /* line-height: 1; 
        overflow: hidden;
        outline: none !important; */
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