# Guia corta - mejoras de prioridad baja y mantenimiento

## 1) Mejoras de UX/UI aplicadas

- Iconografia simple con SVG propio en botones y tarjetas principales.
- Microanimaciones suaves en cards, botones y dropdowns.
- Seccion de ayuda con preguntas frecuentes.
- Pagina de contacto con formulario y validacion basica cliente/servidor.
- Mejora de accesibilidad: foco visible, aria-current en nav activa y respeto por prefers-reduced-motion.
- Microcopy optimizado para que acciones y estados sean mas claros.
- Pagina interna de estado del sistema para administracion.

## 2) Esquema SQL revisado

Se incorporaron mejoras no destructivas en `xampp_php/sql/schema.sql`:

- Nuevos campos en usuarios: `phone`, `document_number`, `birthdate`, `last_login_at`.
- Indices para busqueda de vuelos por ruta/fecha/precio/asientos.
- Indices para historial y estado de reservas.
- Bloque de `ALTER TABLE` para actualizar bases existentes sin reinstalar.

## 3) Mantenimiento tecnico verificado

- Enlaces revisados con rutas internas basadas en `BASE_URL` y `index.php?page=...`.
- Separacion por responsabilidad mantenida:
  - Controladores: `xampp_php/app/controllers`
  - Modelos: `xampp_php/app/models`
  - Vistas: `xampp_php/app/views`
  - Helpers: `xampp_php/app/helpers`
- Estilos centralizados en una hoja principal: `xampp_php/public/assets/css/styles.css`.
- Flujo de autenticacion unificado en `AuthController` y validadores comunes en `validation.php`.
- Ajustes responsive y paginacion mobile mejorada para pantallas chicas.

## 4) Despliegue en XAMPP

1. Copiar proyecto actualizado:
   `sudo cp -R /Users/joa/TP-entornos-graficos/xampp_php /Applications/XAMPP/xamppfiles/htdocs/`
2. Si vas a recrear base: importar `xampp_php/sql/schema.sql`.
3. Abrir:
   `http://localhost/xampp_php/public/index.php?page=home`

## 5) Rutas nuevas utiles

- Ayuda: `?page=faq`
- Contacto: `?page=contact`
- Estado del sistema (admin): `?page=system_status`
