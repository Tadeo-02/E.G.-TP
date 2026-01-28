# TODO

## Documentación

1. Revisar y corregir informe según comentarios.

## Código

1. [X] Mejorar diseño del email de contacto (agregar campos correo y asunto).
2. [] Corregir símbolos en filtros (problema de acentos y codificación UTF-8).
    -  X   <meta charset="UTF-8"> en head.php
    -  X   @charset "UTF-8";/*! en bootstrap.min.css
    -      Chequear configuracion UTF-8 en la DB
3. [] Revisar funcionamiento y sentido del filtro por nombre, agregar paginación si es necesario.
4. [] Mostrar promociones vencidas como no disponibles o no mostrarlas.
5. [] Asegurar correcta visualización de símbolos en todos los navegadores.
6. [X] Agregar opción para visualizar contraseñas al ingresarlas.
7. [] Implementar confirmación de registro de cliente por correo electrónico.
8. [] Validar filtros por fecha (no permitir años inválidos, máximo 4 caracteres).
9. [] Corregir funcionamiento de los filtros de fecha.
10. [] Evitar que clientes seleccionen promociones no disponibles.
11. [] Evitar que un cliente solicite la misma promoción más de una vez.
12. [] Permitir a clientes ver y modificar su perfil en campos permitidos.
13. [] Mejorar accesibilidad: navegación por teclado y lector de pantalla.
14. [] Agregar nombres alternativos a imágenes para accesibilidad.
    - Las imagenes ya tienen el atributo ALT con una descripcion apropiada, no se si pifio la mina o quiere algo más
    - Actualice los atributos  aria-describedby que no tenía un texto genérico hecho con IA con el mismo contenido que el ALT pero dudo q sea eso
15. [] Proveer credenciales de prueba para dueños y administradores (no solamente en README).
