# Guia de configuracion completa (XAMPP + MySQL) - TP Entornos Graficos

Esta guia deja funcionando la version PHP ubicada en `xampp_php/`.

## 1) Prerrequisitos

- XAMPP instalado (Apache + MySQL)
- MySQL instalado (ya lo tenes)
- Proyecto clonado en tu maquina

## 2) Iniciar servicios

1. Abri **XAMPP Control Panel**.
2. Inicia **Apache**.
3. Inicia **MySQL**.
4. Verifica en navegador:
   - `http://localhost` (debe responder Apache)
   - `http://localhost/phpmyadmin` (debe abrir phpMyAdmin)

## 3) Copiar el proyecto PHP a htdocs

En macOS, segun como instalaste XAMPP, `htdocs` suele estar en:

- `/Applications/XAMPP/htdocs`

Copia la carpeta `xampp_php` completa dentro de `htdocs`.

Estructura esperada:

- `/Applications/XAMPP/htdocs/xampp_php/public/index.php`
- `/Applications/XAMPP/htdocs/xampp_php/app/...`
- `/Applications/XAMPP/htdocs/xampp_php/sql/schema.sql`

## 4) Crear la base e importar esquema

### Opcion A: phpMyAdmin

1. Entra a `http://localhost/phpmyadmin`.
2. Crea una base llamada **airarg_db**.
3. Selecciona esa base.
4. Ve a **Importar**.
5. Sube el archivo:
   - `xampp_php/sql/schema.sql`
6. Ejecuta la importacion.

### Opcion B: consola MySQL

```bash
mysql -u root -p
CREATE DATABASE airarg_db;
USE airarg_db;
SOURCE /Applications/XAMPP/htdocs/xampp_php/sql/schema.sql;
```

Si tu usuario `root` no tiene password, al pedir `-p` presiona Enter.

## 5) Configurar conexion a DB

Archivo:

- `xampp_php/app/config/config.php`

Valores esperados por defecto:

- `DB_HOST = 127.0.0.1`
- `DB_PORT = 3306`
- `DB_NAME = airarg_db`
- `DB_USER = root`
- `DB_PASS = ''` (vacio)

Si tu MySQL usa otra clave/puerto/usuario, ajustalo ahi.

## 6) Probar la aplicacion

URL base recomendada:

- `http://localhost/xampp_php/public/index.php?page=home`

Paginas utiles:

- Home: `?page=home`
- Login: `?page=login`
- Vuelos: `?page=flights`
- Reservas: `?page=reservations`
- Perfil: `?page=profile`
- Admin: `?page=admin`
- CEO: `?page=ceo`

Ejemplos directos:

- `http://localhost/xampp_php/public/index.php?page=login`
- `http://localhost/xampp_php/public/index.php?page=admin`

## 7) Usuarios de prueba

- `admin@tp.com` / `123456`
- `ceo@tp.com` / `123456`
- `cliente@tp.com` / `123456`

## 8) Problemas comunes y solucion

### Error de conexion a MySQL

- Revisa usuario/password/puerto en `xampp_php/app/config/config.php`.
- Verifica que MySQL este iniciado en XAMPP.
- Confirma que la base `airarg_db` exista.

### Access denied for user 'root'@'localhost' (using password: YES)

Este error significa que el servidor responde, pero la clave del usuario no coincide.

En macOS es muy comun tener dos MySQL distintos:

- MySQL del sistema (por ejemplo `/usr/local/mysql/bin/mysqld`)
- MySQL de XAMPP

Si el MySQL del sistema esta activo, podrias estar conectando a ese servidor en vez del de XAMPP.

Pasos recomendados:

1. Detene el MySQL del sistema (si esta activo).
2. Inicia MySQL desde XAMPP.
3. Reintenta conexion con usuario `root` y password vacio (valor por defecto de XAMPP).
4. Si usas la version Node.js, en `.env` coloca `DB_PASSWORD=` (vacio) cuando uses MySQL de XAMPP por defecto.
5. Si queres usar tu MySQL del sistema, ajusta `DB_PASSWORD` con la clave real de ese root o crea un usuario nuevo para la app.

### 404 o pagina no encontrada

- Revisa que la carpeta este realmente en `htdocs/xampp_php`.
- Usa la URL exacta con `public/index.php?page=home`.

### Pantalla en blanco o error PHP

- Revisa logs de Apache/PHP en XAMPP.
- Verifica que el archivo `schema.sql` se haya importado sin errores.

### Puerto ocupado

- Si Apache o MySQL no arrancan, cambia puertos desde XAMPP Config.
- Si cambiaste MySQL a otro puerto, actualiza `DB_PORT` en config.

### MySQL queda en "Starting..." y no pasa a verde

1. En XAMPP, presiona **Stop All**.
2. Cierra XAMPP.
3. Abre XAMPP nuevamente con permisos de administrador (si macOS lo pide).
4. Inicia primero **MySQL Database** y espera 10 a 20 segundos.
5. Si sigue en "Starting...", revisa el log:
   - XAMPP > Manage Servers > selecciona MySQL > **Configure** > abre log/error log.
6. Caso frecuente: puerto 3306 ocupado por otra instancia MySQL.
   - Solucion A: detene la otra instancia MySQL del sistema.
   - Solucion B: cambia el puerto de XAMPP MySQL a 3307.
7. Si usas 3307, actualiza tambien `DB_PORT` en `xampp_php/app/config/config.php`.

## 9) Checklist final

- Apache iniciado
- MySQL iniciado
- `xampp_php` copiado en `htdocs`
- DB `airarg_db` creada
- `schema.sql` importado
- Credenciales correctas en `config.php`
- URL `index.php?page=home` responde

---

Si despues queres, puedo agregarte una segunda guia para ejecutar tambien la version Node.js/Express del mismo repo en paralelo (sin chocar puertos con XAMPP).
