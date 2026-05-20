# Migraciones de base de datos

Este directorio contiene migraciones SQL incrementales para el esquema de `airarg_db`.

## Uso

1. Crear o seleccionar la base de datos:

```sql
CREATE DATABASE IF NOT EXISTS airarg_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE airarg_db;
```

2. Ejecutar las migraciones en orden numérico:

```bash
mysql -u root -p airarg_db < xampp_php/sql/migrations/0001_init_schema.sql
mysql -u root -p airarg_db < xampp_php/sql/migrations/0002_reservation_approval_support.sql
```

> Para entornos XAMPP en Windows, reemplazar `mysql` por la ruta de `C:\xampp\mysql\bin\mysql.exe`.

## Convenciones

- Cada archivo comienza con un número secuencial de 4 dígitos.
- No se deben modificar migraciones ya publicadas; si se necesita un ajuste, agregar una nueva migración.
- El archivo `0001_init_schema.sql` representa el esquema inicial completo.
- Las migraciones posteriores deben ser incrementales y seguras para ejecutarse en bases con estado parcial.

## Recomendación para contribuyentes

- Si agregás una nueva tabla o columna, crea un nuevo archivo `00XX_descripcion.sql`.
- Documentá el propósito de la migración en el encabezado del archivo.
- Para compartir un estado limpio, el `schema.sql` puede seguir usándose como export completo.
