-- Migracion 0003: ampliar users.password_hash a VARCHAR(255) para password_hash()

USE airarg_db;

ALTER TABLE users MODIFY COLUMN password_hash VARCHAR(255) NOT NULL;

-- Opcional: re-hashear cuentas con MD5 no es seguro sin conocer passwords; se soporta migracion al login.
