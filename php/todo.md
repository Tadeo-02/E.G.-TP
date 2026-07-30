# Plan de limpieza — PHP

> Actualizado: julio 2026 — todos los items completados.

## Grupo 1: SQL Injection → Prepared Statements (alta prioridad)

Migrar de interpolación directa a `$conn->prepare()` + `bind_param()`.

| # | Archivo | Líneas | Detalle | Estado |
|---|---------|--------|---------|--------|
| 1A | `admin/altaLocales.php` | 26, 35 | `SELECT nombreLocal` y `INSERT INTO locales` | ✅ |
| 1B | `admin/editarLocales.php` | 20, 29 | `SELECT nombreLocal` y `UPDATE locales SET` | ✅ |
| 1C | `admin/altaNovedades.php` | 20, 46 | `SELECT textoNovedad` e `INSERT INTO novedades` | ✅ |
| 1D | `admin/editarNovedades.php` | 36 | `UPDATE novedades SET` | ✅ |
| 1E | `dueñoLocal/savePromociones.php` | 46 | `INSERT INTO promociones` | ✅ |
| 1F | `loginUser.php` | 27 | `SELECT * FROM usuarios` | ✅ |
| 1G | `listaLocales.php` | 17, 20, 26-27 | Filtros `LIKE`, `rubroLocal =`, `$where` dinámico | ✅ |
| 1H | `listaPromociones.php` | 42-46, 70 | Cláusulas WHERE con `$diaDesde`, `$diaHasta` | ✅ |
| 1I | `listaNovedades.php` | 17-35 | WHERE con `$hoy`, LIMIT | ✅ |
| 1J | `vencimientoPromociones.php` | 7-8 | WHERE con `$hoy` | ✅ |
| 1K | `dueñoLocal/reporteDescuento.php` | 13, 67-68 | `$codDueño`, `$codPromo` | ✅ |
| 1L | `dueñoLocal/listaSolicitudDescuentos.php` | 15, 71-72 | `$codDueño`, `$codPromo` | ✅ |
| 1M | `cliente/saveSolicitudPromoCliente.php` | 17, 37 | `SELECT * FROM uso_promociones`, INSERT | ✅ |
| 1N | `cliente/listaMisDescuentos.php` | 28, 31, 35 | WHERE `$codCliente` | ✅ |
| 1O | `buscador.php` | — | Sin consultas SQL — solo valida módulo y guarda en sesión | ✅ |
| — | `saveUser.php` | 48 | `INSERT INTO usuarios` | ✅ |
| — | `admin/aprobarSolicitudCuenta.php` | 17, 30 | UPDATE solicitudes_cambio, UPDATE usuarios | ✅ |
| — | `admin/denegarSolicitudCuenta.php` | 15, 28 | UPDATE solicitudes_cambio, UPDATE usuarios | ✅ |
| — | `admin/denegarPromocion.php` | 18, 31 | UPDATE solicitudes, UPDATE promociones | ✅ |
| — | `dueñoLocal/aprobarSolicitudDescuentoCliente.php` | 17, 31 | UPDATE solicitudes, INSERT INTO descuentos_cliente | ✅ |
| — | `dueñoLocal/DenegarSolicitudDescuentoCliente.php` | 15 | UPDATE solicitudes | ✅ |
| — | `cliente/utilizarDescuento.php` | 19, 42, 55 | SELECT + INSERT + UPDATE | ✅ |

## Grupo 2: XSS (alta prioridad)

| # | Archivo | Línea | Detalle | Estado |
|---|---------|-------|---------|--------|
| 2 | `disp-message.php` | 9 | `echo "<p>" . $message . "</p>"` → `htmlspecialchars($message)` | ✅ |

## Grupo 3: Bugs (alta prioridad)

| # | Archivo | Línea | Detalle | Estado |
|---|---------|-------|---------|--------|
| 3 | `listaPromociones.php` | 24 | `$condicionesw` (minúscula) → `$condicionesW` (mayúscula) | ✅ |
| 4 | `listaPromociones.php` | 41 | `!empty($diaDesde && !empty($diaHasta))` → `!empty($diaDesde) && !empty($diaHasta)` | ✅ |

## Grupo 4: Open Redirect (alta prioridad)

Agregar validación de `$_SERVER['HTTP_REFERER']` contra el host propio.

| # | Archivo | Líneas | Estado |
|---|---------|--------|--------|
| 5M | **Función helper** `redirigirSeguro()` en `main.php` | — | ✅ |
| 5A | `admin/altaLocales.php` | 19, 30, 42-44 | ✅ |
| 5B | `admin/editarLocales.php` | 13, 24, 36-38 | ✅ |
| 5C | `admin/altaNovedades.php` | 13, 24, 32, 39, 53-55 | ✅ |
| 5D | `admin/editarNovedades.php` | 14, 24, 31, 43-45 | ✅ |
| 5E | `admin/aprobarSolicitudCuenta.php` | 20-22 | ✅ |
| 5F | `admin/denegarSolicitudCuenta.php` | 20-22 | ✅ |
| 5G | `admin/denegarPromocion.php` | 23-25 | ✅ |
| 5H | `dueñoLocal/aprobarSolicitudDescuentoCliente.php` | 36-38 | ✅ |
| 5I | `dueñoLocal/DenegarSolicitudDescuentoCliente.php` | 20-22 | ✅ |
| 5J | `cliente/saveSolicitudPromoCliente.php` | 23, 32, 49 | ✅ |
| 5K | `cliente/mensajePromocion.php` | 23 | ✅ |
| 5L | `cliente/utilizarDescuento.php` | 14, 29, 53, 101 | ✅ |

## Grupo 5: Código muerto (media prioridad)

| # | Archivo | Líneas | Contenido | Estado |
|---|---------|--------|-----------|--------|
| 6A | `admin/altaNovedades.php` | 64-103 | Ya no existe — archivo reducido tras refactor | ✅ |
| 6B | `dueñoLocal/listaSolicitudDescuentos.php` | 162-222 | ~60 líneas de HTML de tabla comentado | ✅ |
| 6C | `main.php` | 4-7 | Bloque de conexión InfinityFree comentado | ✅ |
| 6D | `cliente/saveSolicitudPromoCliente.php` | 53-89 | 37 líneas en blanco al final | ✅ |

## Grupo 6: Regex inválido (media prioridad)

`[a-zA-Z0-9$@.-]{7,100}` → `[a-zA-Z0-9\$@.\-]{7,100}`

| # | Archivo | Línea | Estado |
|---|---------|-------|--------|
| 7A | `loginUser.php` | 16 | ✅ |
| 7B | `procesarResetPassword.php` | 29 | ✅ |
| 7C | `saveUser.php` | 35 | ✅ |

## Grupo 7: Varios (media prioridad)

| # | Archivo | Detalle | Estado |
|---|---------|---------|--------|
| 8 | `.env` | Sincronizado con `.env.example` — OK | ✅ |
| 9 | `loginUser.php:44` | Agregar `exit()` tras el bloque `if(headers_sent())` | ✅ |

## Tests de regresión

| Archivo | Pruebas | Estado |
|---------|---------|--------|
| `tests/test_bugs.php` | 8 tests — bugs, exit(), regex escapado | ✅ |
| `tests/test_redirigirSeguro.php` | 7 tests — URL validation | ✅ |
| `tests/test_regex.php` | 15 tests — password regex + escapado | ✅ |
| `tests/test_xss.php` | 36 tests — XSS, SQLi (con listaNovedades.php, vencimientoPromociones.php, saveUser.php), Open Redirect scan | ✅ |
