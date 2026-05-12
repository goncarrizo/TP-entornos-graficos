# Despliegue en Render (Docker)

Esta guía te ayuda a desplegar la app `xampp_php` en Render usando el `Dockerfile` incluido.

1. Subir el repo a GitHub.
2. En Render, crea un nuevo **Web Service** y selecciona "Docker" como método de deploy.
   - Indica el `Root Directory` como `xampp_php` si Render no detecta automáticamente.
3. Render hará build del `Dockerfile` y expondrá la app en una URL pública.
4. Crea una **Managed Database** MySQL en Render y restaura tu `dump.sql`.
5. En el servicio web, agrega variables de entorno:
   - `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `APP_URL` (p. ej. https://mi-app.onrender.com)
6. Revisa los logs en el Dashboard si algo falla.

## Integración con GitHub (deploy automático)

1. En GitHub, crea los secrets del repositorio:
   - `RENDER_API_KEY` — tu API key de Render (Dashboard -> Account -> API Keys)
   - `RENDER_SERVICE_ID` — el ID del servicio Web en Render (srv-...)
2. Al pushear a `main`, el workflow `.github/workflows/deploy_render.yml` enviará una petición a la API de Render para iniciar un deploy.

Nota: Alternativamente podes usar la integración nativa de Render con GitHub para que haga deploy automáticamente al pushear.

## Exportar e importar la base de datos

Incluí `scripts/export_dump.sh` para generar un `dump.sql` local:

```bash
# Exportar DB local
./scripts/export_dump.sh root '' airarg_db dump.sql
```

Importá el `dump.sql` en la Managed DB de Render desde tu cliente MySQL o desde el panel del proveedor.

## Pasos resumidos finales

1. Subir el repo a GitHub (push).
2. Crear servicio Web en Render (Docker) apuntando a `xampp_php` o usar el `Dockerfile` en la raíz del servicio.
3. Crear Managed MySQL y restaurar `dump.sql`.
4. Configurar secrets en GitHub (`RENDER_API_KEY` y `RENDER_SERVICE_ID`).
5. Push a `main` → GitHub Actions lanzará el deploy o Render hará deploy automático.


Notas:
- El `Dockerfile` ya apunta `DocumentRoot` a `public/`.
- Para pruebas locales, usa `docker-compose up --build` y abre `http://localhost:8080`.
