# Entrega UTN - Checklist de Cumplimiento (PHP + XAMPP)

Este documento valida la implementacion oficial ubicada en `xampp_php/` contra la consigna de la catedra.

## Tecnologias obligatorias

- HTML5: vistas en `xampp_php/app/views/pages/*.php`
- CSS3: `xampp_php/public/assets/css/styles.css`
- Bootstrap: incluido en layouts/parciales de vistas
- JavaScript: `xampp_php/public/assets/js/app.js`
- jQuery: cargado en `xampp_php/app/views/partials/footer.php`
- PHP sin frameworks: `xampp_php/app/*`
- MySQL: conexion en `xampp_php/app/config/config.php`
- XAMPP: despliegue en `xampp_php/public`

## Requisitos tecnicos obligatorios

- ABMC/CRUD en PHP:
  - Vuelos: `FlightController.php`
  - Aerolineas: `AdminController.php`
  - Promociones: `AdminController.php`, `CeoController.php`
  - Novedades: `AdminController.php`
- Validacion cliente (JS): `xampp_php/public/assets/js/app.js`
- Validacion servidor (PHP): `xampp_php/app/helpers/validation.php` + controladores
- Sesiones:
  - `session_start()`: `xampp_php/app/config/config.php`
  - `$_SESSION`: `xampp_php/app/controllers/AuthController.php`
  - `session_destroy()`: `xampp_php/app/controllers/AuthController.php`
- Login y registro: `AuthController.php` + `views/pages/login.php`
- Encriptacion MD5: `md5()` en registro/login y seeds SQL
- Paginacion: `paginate()` en `xampp_php/public/index.php` (seccion novedades)
- Envio de mails: `xampp_php/app/helpers/mail.php` (mail real o fallback local)
- Conexion MySQL: `xampp_php/app/core/Database.php`

## Base de datos

Script oficial: `xampp_php/sql/schema.sql`

Tablas del dominio implementadas:

- users
- airlines
- flights
- promotions
- reservations
- news

Incluye PK, FK y relaciones entre entidades.

## Funcionalidades

- Registro de usuario
- Login/logout
- Buscar vuelos
- Reservar vuelos
- Cancelar reservas
- Ver historial
- Panel administrador
- Panel CEO

## Pasos de ejecucion para defensa

1. Iniciar Apache y MySQL en XAMPP.
2. Copiar `xampp_php` a `htdocs`.
3. Importar `xampp_php/sql/schema.sql`.
4. Abrir `http://localhost/xampp_php/public/index.php?page=home`.
5. Probar login con:
   - `admin@tp.com / 123456`
   - `ceo@tp.com / 123456`
   - `cliente@tp.com / 123456`

## Nota

El repositorio mantiene una variante Node.js como historico, pero la entrega academica requerida por catedra es la version PHP/XAMPP de esta checklist.
