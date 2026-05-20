# Versión PHP / XAMPP

Esta carpeta contiene la implementación MVC del trabajo práctico pensada para ejecutarse con XAMPP.

## Estructura

- `public/index.php`: punto de entrada único y router de páginas y acciones.
- `app/bootstrap.php`: carga configuración, helpers, modelos y controladores.
- `app/config/config.php`: variables base, sesión y conexión a base de datos.
- `app/controllers`: lógica de autenticación, vuelos, reservas, panel admin y panel CEO.
- `app/models`: acceso a datos y consultas del dominio.
- `app/helpers`: sesión, vistas, validación, mail y utilidades.
- `app/views`: páginas HTML/PHP y parciales reutilizables.
- `sql/schema.sql`: esquema completo y datos semilla.
- `sql/migrations/`: migraciones SQL incrementales para crear y actualizar el esquema.
- `INFORME_FINAL.md`: documentación académica del proyecto.

## Funcionalidades

- Registro y login con sesión PHP.
- Perfil de usuario autenticado.
- Búsqueda y paginación de vuelos.
- Reserva y cancelación con validación de reglas de negocio.
- Panel de administrador para aerolíneas, novedades y promociones.
- Panel de CEO para vuelos, promociones y reportes.
- Envío de mails en acciones clave como registro, reserva y cancelación.

## Reglas de negocio

- La reserva descuenta asientos disponibles antes de confirmarse.
- La cancelación sólo se permite con al menos 72 horas de anticipación.
- Las promociones pueden aprobarse o denegarse desde el panel de administrador.
- El acceso a pantallas y acciones está restringido por rol.

## Base de datos

El esquema se crea sobre la base `airarg_db` e incluye:

- Usuarios con rol `admin`, `ceo` o `customer`.
- Aerolíneas.
- Vuelos.
- Promociones con estado y activación.
- Reservas.
- Novedades.

Incluye datos demo para probar el sistema con usuarios de ejemplo y contenido inicial.

## Acceso rápido

Los usuarios de prueba son los mismos del resto del proyecto:

- `admin@tp.com` / `123456`
- `ceo@tp.com` / `123456`
- `cliente@tp.com` / `123456`

## Ejecución

1. Importar `sql/schema.sql` en MySQL.
2. Configurar XAMPP con Apache y MySQL activos.
3. Verificar credenciales en `app/config/config.php`.
4. Servir la carpeta `public` como entrada web.
5. Navegar por `index.php?page=home`, `login`, `flights`, `reservations`, `admin` o `ceo`.