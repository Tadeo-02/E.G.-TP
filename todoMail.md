# Pendientes — Sistema de Emails con Resend

## En el hosting / deploy

- [ ] **Verificar PHP 8.1+** — el SDK de Resend lo requiere
- [ ] **Ejecutar `composer install`** en el servidor (descarga `resend/resend-php`)
- [ ] **Configurar DNS del dominio en Resend**
  - Agregar el dominio en https://resend.com/domains
  - Agregar los registros TXT, DKIM y SPF que te dé Resend
  - Esperar a que se verifique
- [ ] **Crear `.env`** en la raíz del proyecto con:
  ```env
  APP_URL=https://tudominio.com
  RESEND_API_KEY=re_xxxxxxxxxxxx
  MAIL_FROM="NovaShopping <noreply@tudominio.com>"
  ```
  O en su defecto definir esas mismas variables como variables de entorno reales del server (nginx/Apache).

## En local / testing

- [ ] **Verificar que `.env` local tenga los valores correctos**
  - `APP_URL=http://localhost:8080` (o el puerto que uses)
  - `RESEND_API_KEY` con una key válida (podés usar `re_...` de prueba en Resend o crear una key de desarrollo)
  - `MAIL_FROM` con un dominio verificado en Resend (para testing podés usar `onboarding@resend.dev`)
- [ ] **Ejecutar `composer install`** para generar `vendor/` y el autoloader
- [ ] **Probar cada flujo que envía correos**:

| Flujo | Archivo | Función |
|---|---|---|
| Registro de usuario | `php/saveUser.php` | `enviarCorreoVerificacion()` |
| Cambio de email | `php/cliente/updateProfile.php` | `enviarCorreoCambioEmail()` |
| Reset de contraseña | `php/solicitarResetPassword.php` | `enviarCorreoResetPassword()` |
| Newsletter | `php/newsletterSubscribe.php` | `enviarVerificacionNewsletter()` |

## Si algo falla

- [ ] Revisar `error_log` del servidor (los errores del mailer se loguean ahí)
- [ ] Verificar que `composer install` se haya ejecutado y exista `vendor/autoload.php`
- [ ] Verificar que `RESEND_API_KEY` sea correcta y el dominio esté verificado en Resend
- [ ] Verificar que `APP_URL` apunte al dominio correcto con `https://`

## Obsoleto

- `php/mailConfig.php` — ya no se usa, reemplazado por `.env` + `php/config.php`
- `php/PHPMailer/` — se puede eliminar (ya no se utiliza), pero no molesta si queda
