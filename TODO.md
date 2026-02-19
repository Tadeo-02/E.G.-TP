# TODO

## Documentación

1. Revisar y corregir informe según comentarios.

## Código

1.  [x] Mejorar diseño del email de contacto (agregar campos correo y asunto).
2.  [x] Corregir símbolos en filtros (problema de acentos y codificación UTF-8).
    - X `<meta charset="UTF-8">` en head.php
    - X `@charset "UTF-8";/*! en bootstrap.min.css`
    - X `Content-Type text/html; charset=UTF-8` Header devuelto en la web
    -      Chequear configuracion UTF-8 en la DB
3.  [x] Revisar funcionamiento y sentido del filtro por nombre, agregar paginación si es necesario. (Filtro y paginación ya están y andan. Se agregó boton de toggle ASC/DESC)
4.  [x] Mostrar promociones vencidas como no disponibles o no mostrarlas. (ya está validado para no mostrarlas desde la query; listaPromociones 50-55)
5.  [x] Asegurar correcta visualización de símbolos en todos los navegadores.
    - X Son las mismas medidas que el punto 2
6.  [x] Agregar opción para visualizar contraseñas al ingresarlas.
7.  [] Implementar confirmación de registro de cliente por correo electrónico.
8.  [x] Validar filtros por fecha (no permitir años inválidos, máximo 4 caracteres).
9.  [x] Corregir funcionamiento de los filtros de fecha.
10. [X?] Evitar que clientes seleccionen promociones no disponibles.
11. [x] Evitar que un cliente solicite la misma promoción más de una vez.
12. [] Permitir a clientes ver y modificar su perfil en campos permitidos.
13.1 [x] Mejorar accesibilidad: navegación por teclado.
13.2 [] Mejorar accesibilidad: lector de pantalla.
14. [x] Agregar nombres alternativos a imágenes para accesibilidad.
    - Las imagenes ya tienen el atributo ALT con una descripcion apropiada
    - Agregado atributo 'title' a todas las imágenes para mostrar tooltip al pasar el mouse
    - Aplicado en carousel del home (3 imágenes) y lista de locales
15. [] Proveer credenciales de prueba para dueños y administradores (no solamente en README).
