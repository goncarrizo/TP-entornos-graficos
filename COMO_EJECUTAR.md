# Cómo ejecutar el sistema AirARG

## Requisitos previos

- **XAMPP instalado** en `/Applications/XAMPP/` (macOS)
- **Apache** y **MySQL** funcionando
- **PHP 8.2+** configurado

## Método 1: Usando el gestor gráfico de XAMPP (Recomendado)

### Paso 1: Abrir el gestor de XAMPP
```bash
open /Applications/XAMPP/manager-osx.app
```

### Paso 2: Iniciar los servicios
En la ventana del gestor:
1. Haz clic en **"Start"** para **Apache**
2. Haz clic en **"Start"** para **MySQL**

Espera a que ambos muestren estado **"Running"** (verde).

### Paso 3: Acceder a la aplicación

Abre tu navegador en:
```
http://127.0.0.1/xampp_php/public/
```

---

## Método 2: Usando el script de deploy (Automático)

### Paso 1: Asegurar que Apache y MySQL estén corriendo
```bash
ps aux | grep -E "(httpd|mysqld)" | grep -v grep
```

### Paso 2: Ejecutar el script de sincronización
```bash
cd /Users/joa/TP-entornos-graficos
bash deploy_xampp.sh
```

Este script:
- Sincroniza archivos del proyecto con `rsync`
- Verifica que la URL está activa
- Confirma el deploy exitoso

### Paso 3: Acceder a la aplicación
```
http://127.0.0.1/xampp_php/public/
```
http://localhost/TP-entornos-graficos/xampp_php/public/index.php

---

## Método 3: Manual con comandos de terminal

### Paso 1: Iniciar Apache
```bash
sudo /Applications/XAMPP/xamppfiles/bin/apachectl start
```

### Paso 2: Iniciar MySQL
```bash
/Applications/XAMPP/xamppfiles/bin/mysql.server start
```

### Paso 3: Sincronizar archivos
```bash
rsync -a --delete /Users/joa/TP-entornos-graficos/xampp_php/ \
  /Applications/XAMPP/xamppfiles/htdocs/xampp_php/
```

### Paso 4: Verificar que está corriendo
```bash
curl -s http://127.0.0.1/xampp_php/public/index.php | head -20
```

### Paso 5: Abrir en navegador
```
http://127.0.0.1/xampp_php/public/
```

---

## Verificar estado de los servicios

### Ver si Apache está corriendo
```bash
ps aux | grep httpd | grep -v grep
```

### Ver si MySQL está corriendo
```bash
ps aux | grep mysqld | grep -v grep
```

### Revisar logs de Apache (si hay errores)
```bash
tail -20 /Applications/XAMPP/xamppfiles/logs/error_log
```

---

## Detener los servicios

### Detener Apache
```bash
sudo /Applications/XAMPP/xamppfiles/bin/apachectl stop
```

### Detener MySQL
```bash
/Applications/XAMPP/xamppfiles/bin/mysql.server stop
```

---

## URLs disponibles

**Base:** `http://localhost/xampp_php/public/` (o `http://127.0.0.1/xampp_php/public/`)

| Funcionalidad | URL |
|---|---|
| Home | `/` |
| Buscar vuelos | `?page=flights` |
| Login | `?page=login` |
| Registro | `?page=register` |
| Panel de usuario | `?page=profile` |
| Noticias | `?page=news` |
| FAQ | `?page=faq` |
| Contacto | `?page=contact` |
| Panel Admin | `?page=admin` |
| Panel CEO | `?page=ceo` |

---

## Troubleshooting

### Error: "Port already in use"
Alguien más está usando el puerto 80. Cambia en Apache config o termina el proceso:
```bash
sudo lsof -i :80
sudo kill -9 <PID>
```

### Error: "Connection refused"
Apache no está corriendo. Reinicia con:
```bash
sudo /Applications/XAMPP/xamppfiles/bin/apachectl restart
```

### MySQL no conecta
Reinicia MySQL:
```bash
/Applications/XAMPP/xamppfiles/bin/mysql.server restart
```

### Archivos no se actualizan
Ejecuta el deploy:
```bash
bash deploy_xampp.sh
```

---

## Notas importantes

- Los archivos se sirven desde `/Applications/XAMPP/xamppfiles/htdocs/xampp_php/`
- La aplicación usa sesiones PHP (cookies)
- Limpia cache del navegador si ves cambios viejos
- Para desarrollo, es recomendable usar el Método 1 (gestor gráfico)

