# TP Final Entornos Gráficos - Implementación PHP + MySQL para XAMPP

Proyecto académico orientado a la defensa oral y práctica en UTN FRRO.

## 1. Objetivo del sistema

Desarrollar una plataforma de reservas de vuelos con distintos perfiles de usuario, aplicando buenas prácticas de desarrollo web, separación por capas, validación de datos y control de acceso por roles.

## 2. Tecnologías utilizadas

- PHP 8+
- MySQL
- Bootstrap 5
- JavaScript
- jQuery
- XAMPP

## 3. Estructura general

El proyecto sigue una organización tipo MVC:

- `app/`: lógica de negocio, controladores, modelos y vistas.
- `public/`: punto de entrada web, CSS y JS públicos.
- `sql/`: script de base de datos.

## 4. Instalación en XAMPP

1. Copiar la carpeta `xampp_php` dentro de `htdocs`.
2. Iniciar Apache y MySQL desde XAMPP.
3. Abrir phpMyAdmin y ejecutar `sql/schema.sql`.
4. Verificar credenciales de base en `app/config/config.php`.
5. Abrir la aplicación en navegador.

URL sugerida:

- `http://localhost/TP-entornos-graficos/xampp_php/public/index.php?page=home`

## 5. Usuarios de prueba

- Administrador: `admin@tp.com` / `123456`
- CEO: `ceo@tp.com` / `123456`
- Cliente: `cliente@tp.com` / `123456`

## 6. Funcionalidades implementadas

### Visitante no autenticado

- Ver vuelos
- Ver aerolíneas
- Ver novedades

### Usuario registrado

- Registro con validación
- Login y logout con sesiones
- Búsqueda de vuelos
- Reserva de vuelos
- Cancelación con regla de 72 horas
- Historial de reservas

### CEO

- ABMC de vuelos
- ABMC de promociones
- Reportes de ventas y ocupación

### Administrador

- ABMC de aerolíneas
- Aprobación y denegación de promociones
- ABMC de novedades
- Reportes del sistema

## 7. Manejo de sesiones

El sistema usa `session_start()` al inicio de la configuración para mantener el estado de autenticación.

Datos guardados en sesión:

- `id_usuario`
- `nombre`
- `rol`

La sesión se utiliza para proteger páginas privadas y para mostrar información contextual del usuario.

Al cerrar sesión, el sistema limpia `$_SESSION` y ejecuta `session_destroy()`.

### Sesiones vs cookies

- Una cookie almacena datos en el navegador.
- Una sesión guarda el estado en el servidor y solo expone un identificador al cliente.
- Para autenticación, la sesión es más apropiada porque reduce la exposición de datos sensibles.

## 8. Seguridad y validaciones

- Validación del lado cliente con Bootstrap.
- Validación del lado servidor en controladores.
- Sanitización de entradas.
- Consultas con PDO y sentencias preparadas.
- Control de acceso por rol.

## 9. Contraseñas con MD5

Por requisito académico, las contraseñas se guardan y comparan con `md5()`.

### Qué conviene explicar en la defensa

- MD5 es un hash de una sola vía.
- No permite recuperar la contraseña original de forma directa.
- No es una solución moderna para producción, pero sirve para demostrar el concepto de hash en un TP.

## 10. Base de datos

Tablas incluidas:

- users
- airlines
- flights
- promotions
- reservations
- news

Relaciones principales:

- `flights.airline_id` -> `airlines.id`
- `reservations.user_id` -> `users.id`
- `reservations.flight_id` -> `flights.id`
- `promotions.airline_id` -> `airlines.id`

## 11. Paginación y mails

- Paginación en listados de vuelos y novedades.
- Envío de mails con `mail()` para registro y reservas.
- Si el servidor local no tiene correo configurado, el sistema registra un fallback en archivo de log.

## 12. Recomendaciones para presentación oral

Al exponer el TP conviene mostrar:

1. Estructura del proyecto.
2. Login y control de sesiones.
3. Protección de rutas por rol.
4. Un CRUD completo.
5. Reglas de negocio de reservas.
6. Base de datos y relaciones.
7. Paginación y validaciones.
8. Mecanismo de mails.

## 13. Material adicional

- Informe final: [INFORME_FINAL.md](INFORME_FINAL.md)
- Script SQL: [sql/schema.sql](sql/schema.sql)
