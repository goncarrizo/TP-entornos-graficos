# Informe Final Académico - TP Entornos Gráficos (UTN FRRO)

## 1) Uso de sesiones

El sistema utiliza sesiones PHP para mantener autenticado al usuario entre requests HTTP y conservar el contexto de navegación sin exponer información sensible en el navegador.

- Se inicializa con session_start() en la configuracion global.
- Luego del login se guardan en $_SESSION:
  - id_usuario
  - nombre
  - rol
- Tambien se guarda un objeto user para simplificar la vista.
- Las rutas privadas validan sesion y rol antes de permitir acceso.
- El logout elimina datos de sesion y ejecuta session_destroy().

Diferencia con cookies:
- La cookie vive en el cliente.
- La sesion guarda datos sensibles del lado servidor.
- El cliente solo conserva el identificador de sesion.

## 2) Seguridad aplicada

- Consultas preparadas con PDO para evitar inyección SQL.
- Control de acceso por roles (admin, ceo, customer).
- Validaciones en cliente y servidor.
- Mensajes de error controlados y reutilizables.

Contraseña:
- Por requerimiento de cátedra se usa MD5.
- MD5 es un hash irreversible en forma directa.
- Limitación: no es recomendable para producción por debilidad criptográfica.

## 3) Validaciones

Cliente:
- Bootstrap validation en formularios con `required`, `min` y `type`.

Servidor:
- Sanitización de entradas en helpers.
- Verificación de campos obligatorios y tipos en controladores.
- Verificación de permisos y reglas de negocio.

## 4) Acceso restringido

- Usuario no logueado puede ver home, vuelos y novedades.
- Cliente puede reservar, cancelar y ver historial.
- CEO gestiona vuelos, promociones y reportes.
- Admin gestiona aerolíneas, novedades, promociones y reportes globales.

## 5) Reglas de negocio implementadas

- Promoción requiere aprobación de admin.
- La reserva nace pendiente y pasa a confirmada.
- Al reservar se descuentan asientos.
- La cancelación solo es posible hasta 72 horas antes del vuelo.
- Solo una promoción activa por aerolínea.

## 6) Paginación y mails

- Paginación en listado de vuelos y novedades.
- Se usa `mail()` para notificaciones (registro, reserva y cancelación).
- Si `mail()` no está configurado en XAMPP, se guarda un fallback en `tmp/mail.log`.

## 7) Buenas prácticas

- Separación por capas: modelos, controladores, vistas y helpers.
- Nombres descriptivos y estructura mantenible.
- Interfaz responsive con Bootstrap y accesibilidad básica.

## 8) Conclusión

El sistema demuestra el uso integrado de sesiones, autenticación, control de acceso, base de datos relacional, validación de formularios y reglas de negocio propias de una plataforma profesional de reservas.
