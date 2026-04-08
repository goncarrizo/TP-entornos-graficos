# Trabajo Práctico Final - Entornos Gráficos

Sistema web académico de gestión de reservas de vuelos desarrollado para UTN FRRO.

La implementación principal para entrega y ejecución en XAMPP está en [xampp_php/README.md](xampp_php/README.md).

## Resumen del proyecto

El sistema modela una plataforma de aerolínea con los siguientes roles:

- Administrador
- CEO de aerolínea
- Usuario registrado
- Usuario no registrado

## Alcance funcional

- Búsqueda y visualización de vuelos y aerolíneas para visitantes.
- Registro y autenticación de usuarios con sesión PHP.
- Reserva y cancelación de vuelos con reglas de negocio.
- Panel de administración para aerolíneas, novedades y promociones.
- Panel de CEO para vuelos, promociones y reportes.
- Paginación, validaciones, protección de rutas y envío de mails.

## Tecnologías

- PHP
- MySQL
- Bootstrap 5
- JavaScript
- jQuery
- XAMPP

## Documentación incluida

- [README del proyecto PHP/XAMPP](xampp_php/README.md)
- [Informe final académico](xampp_php/INFORME_FINAL.md)
- [Script SQL](xampp_php/sql/schema.sql)

## Criterios destacados para evaluación

- Separación por capas y código modular.
- Uso de sesiones para autenticación y control de acceso.
- CRUD completo con validaciones del lado cliente y servidor.
- Manejo de errores y sanitización de entradas.
- Diseño responsive y estructura accesible.

## Recomendación de entrega

Para la defensa, conviene presentar primero el flujo general del sistema, luego mostrar el login, la protección por roles, el CRUD y las reglas de negocio principales.
