# TP Entornos Graficos - Entrega UTN (Entornos Graficos)

Este repositorio esta organizado exclusivamente para la entrega academica UTN con PHP + MySQL en XAMPP:

- HTML5
- CSS3
- Bootstrap
- JavaScript
- jQuery
- PHP (sin framework)
- MySQL
- XAMPP

La version oficial para presentar esta en [xampp_php](xampp_php).

## Estructura para la entrega

- [xampp_php](xampp_php): implementacion MVC completa en PHP
- [xampp_php/public/index.php](xampp_php/public/index.php): front controller y router
- [xampp_php/app](xampp_php/app): controladores, modelos, helpers y vistas
- [xampp_php/sql/schema.sql](xampp_php/sql/schema.sql): script SQL de la entrega
- [xampp_php/sql/migrations](xampp_php/sql/migrations): migraciones incrementales de base de datos
- [GUIA_XAMPP_MYSQL_PASO_A_PASO.md](GUIA_XAMPP_MYSQL_PASO_A_PASO.md): guia operativa de XAMPP
- [ENTREGA_UTN_XAMPP.md](ENTREGA_UTN_XAMPP.md): checklist de cumplimiento contra consigna

## Version oficial (PHP + XAMPP)

### Requisitos

- Apache y MySQL levantados en XAMPP

### Configuracion

1. Copiar la carpeta PHP a htdocs

```bash
sudo cp -R /Users/joa/TP-entornos-graficos/xampp_php /Applications/XAMPP/xamppfiles/htdocs/
```

2. Cargar base de datos oficial

```bash
/Applications/XAMPP/xamppfiles/bin/mysql -h 127.0.0.1 -P 3306 -u root --password='' -e "CREATE DATABASE IF NOT EXISTS airarg_db;"
/Applications/XAMPP/xamppfiles/bin/mysql -h 127.0.0.1 -P 3306 -u root --password='' airarg_db < xampp_php/sql/schema.sql
```

3. Verificar credenciales en [xampp_php/app/config/config.php](xampp_php/app/config/config.php)

### Ejecucion

- Home: http://localhost/xampp_php/public/index.php?page=home
- Login: http://localhost/xampp_php/public/index.php?page=login

## Usuarios de prueba

- admin@tp.com / 123456
- ceo@tp.com / 123456
- cliente@tp.com / 123456

## Alcance funcional implementado

- Registro y login
- Sesiones con `session_start()`, `$_SESSION`, `session_destroy()`
- ABMC para entidades principales (segun rol)
- Busqueda de vuelos y paginacion
- Reserva y cancelacion de reservas
- Panel Admin y panel CEO
- Envio de mails (con fallback local)
