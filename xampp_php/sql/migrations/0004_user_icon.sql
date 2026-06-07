-- Migracion 0004: agregar icono/avatar seleccionable por usuario

USE airarg_db;

ALTER TABLE users
  ADD COLUMN user_icon VARCHAR(64) NULL DEFAULT NULL;

