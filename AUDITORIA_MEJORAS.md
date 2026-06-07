# Checklist — Auditoría de mejoras (AirARG)

Fecha: 7 de junio de 2026

## Crítico
- [x] Implementar helper `app/helpers/csrf.php` con `csrf_token()` y `check_csrf()`.
- [x] Incluir meta CSRF en `app/views/partials/header.php` y inyección automática en formularios POST (JS).
- [x] Validar CSRF centralmente en `xampp_php/public/index.php` para todas las peticiones POST.
- [ ] Migrar `md5()` a `password_hash()`/`password_verify()` y ampliar `users.password_hash` a `VARCHAR(255)`.
- [x] Configurar cookies de sesión seguras (`secure`, `httponly`, `SameSite`) en `app/config/config.php`.

## Alto
- [ ] Añadir meta Open Graph y canonical en `app/views/partials/header.php`.
- [ ] Generar `sitemap.xml` (estático o dinámico) y añadir `robots.txt` en `xampp_php/public/`.
- [ ] Reemplazar imágenes críticas remotas por assets locales en `public/assets/images/`.
- [ ] Optimizar imágenes (WebP/AVIF) y `preload` de fuentes críticas.

## Medio
- [ ] Añadir `aria-live="polite"` en el contenedor de flash messages.
- [ ] Implementar rotación/alerta para `tmp/mail.log` y evaluar integración SMTP.
- [ ] Añadir rate-limiting para login (IP-based throttle/basic lockout).
- [ ] Definir y aplicar políticas CSP mínimas.
- [ ] Añadir pruebas e2e básicas (registro, login, búsqueda, reserva).

## Bajo
- [ ] Mejorar foco visible y estilos `:focus-visible` para accesibilidad.
- [ ] Añadir sitemap interno y mapa de contenidos en `INFORME_ESPECIFICACION.md`.
- [ ] Preparar checklist de QA y casos de prueba documentados.

## Acciones inmediatas automatizadas (hechas)
- [x] Añadido `app/helpers/csrf.php`.
- [x] Requerido `helpers/csrf.php` en `app/bootstrap.php`.
- [x] Meta CSRF añadido en `app/views/partials/header.php`.
- [x] Inyección de token en formularios POST mediante JS en `app/views/partials/footer.php`.
- [x] Validación central CSRF en `xampp_php/public/index.php`.
- [x] Configuración de cookies seguras en `app/config/config.php`.

## Notas y próximos pasos
- [ ] Migración segura de contraseñas (recomendado ejecutar en ventana de mantenimiento).
- [ ] Revisión manual de cada formulario sensible para confirmar token y validaciones.
- [ ] Priorizar reemplazo de imágenes externas que fallan por políticas ORB.

Si quieres, implemento ahora la migración de contraseñas o genero `sitemap.xml` y `robots.txt`.
