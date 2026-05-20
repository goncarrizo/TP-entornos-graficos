# Backend Integration Test Report

## Resumen de la prueba

Se ejecutó una prueba de flujo completo contra la aplicación web local en:
`http://localhost/TP-entornos-graficos/xampp_php/public/index.php`

Se verificaron los siguientes flujos principales:
- Login como CEO (`ceo@tp.com` / `123456`)
- Acceso al panel CEO
- Creación de una propuesta de aerolínea (`TestAir`, código `TES`)
- Logout
- Login como Admin (`admin@tp.com` / `123456`)
- Acceso al panel admin
- Aprobación de la propuesta de aerolínea
- Verificación de que la solicitud cambió a `approved`

## Resultados

- [x] Página principal accesible `HTTP 200`
- [x] Login CEO exitoso
- [x] Panel CEO cargado correctamente
- [x] Propuesta de aerolínea creada con éxito
- [x] Request visible en el panel CEO luego del envío
- [x] Login Admin exitoso
- [x] Panel admin cargado correctamente
- [x] Propuesta de aerolínea encontrada en el panel admin
- [x] Aprobación de la propuesta ejecutada correctamente
- [x] Consulta directa en la base de datos confirmó que `status = approved` para la propuesta `TES`

## Observaciones detectadas

- La prueba por POST de login redirige a `home`, por lo que la primera comprobación de texto específico de la página CEO no es válida en esa etapa.
- El backend está funcionando correctamente para el flujo básico de propuestas CEO → aprobación admin.
- El contenido del panel admin tras la aprobación incluye el código `TES` porque el nuevo registro de aerolínea ya aparece en la lista de aerolíneas, no porque la solicitud siga pendiente.

## Checklist de cambios necesarios / mejoras sugeridas

- [x] Asegurar que la tabla `airline_requests` exista en la base de datos `airarg_db`.
- [x] Mantener `xampp_php/sql/schema.sql` actualizado con la tabla `airline_requests`.
- [ ] Agregar un script de migración o documentación clara para crear la tabla en instalaciones existentes.
- [ ] Añadir validación de longitud y formato más robusta para el código de aerolínea en el frontend, además del backend.
- [ ] Añadir pruebas automáticas end-to-end (E2E) para:
  - login CEO y admin
  - creación de propuesta de aerolínea
  - aprobación/denegación de solicitud
  - verificación de creación de aerolínea
- [ ] Mejorar el reporte de estado en el panel admin para distinguir claramente solicitudes `pending` de aerolíneas ya aprobadas.
- [ ] Añadir mensajes flash más visibles tras logout para validar visualmente el cierre de sesión en pruebas automatizadas.
- [ ] Revisar el manejo de respuestas HTML en tests automáticos para confirmar si la página resultante es `home`, `admin` o `ceo` tras cada acción.

## Resultado final

El backend principal asociado al flujo de propuesta y aprobación de aerolíneas está operativo. La prioridad inmediata es documentar o migrar la creación de la tabla `airline_requests` para entornos existentes y ampliar pruebas E2E para evitar regresiones.
