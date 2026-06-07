# Lo que falta (derivado de los PDFs en `PDF/`)

## Estado actual (según repo)
- `AUDITORIA_MEJORAS.md` ya tiene **CSRF, cookies seguras, OpenGraph/canonical, sitemap/robots, assets locales, fuentes/preload** como ✅.
- `TODO.md` solo lista mejoras UI/UX (parallax/easing/placeholder/iconografía/sombras).

> Los PDFs aportan principalmente criterios de **accesibilidad/usabilidad/navegación** (WCAG/POUR), y un documento de **estructura y navegación (AirARG)**.

---

## 1) Criterios de Accesibilidad/Usabilidad que vienen de PDFs (y que aún no están completos/documentados como “hecho”)

### 1.1. Skip link + estructura semántica (WCAG: navegación con teclado)
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf` (Skip links, landmarks, landmarks, foco visible)
- `UTN_Cátedra de EG_Checklist.pdf` (operable con teclado, foco visible)

**Requisito esperado**
- Link inicial tipo: “Saltar al contenido principal” que lleve a `main#contenido-principal`
- Uso de landmarks: `<header> <nav> <main> <footer>`

**Falta / por verificar**
- No hay evidencia en `AUDITORIA_MEJORAS.md` o `TODO.md` de que esto esté implementado.
- Debe quedar registrado como ✅ en algún lugar (mejor: `AUDITORIA_MEJORAS.md` “Medio/Bajo” si aplica).

---

### 1.2. Foco visible y navegación 100% con teclado
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf` (outline visible, orden lógico)
- `UTN_Cátedra de EG_Checklist.pdf` (indicador visible de enfoque)

**Requisito esperado**
- Nunca eliminar `outline` sin reemplazo equivalente (mantener foco visible)
- Orden de tab coherente con el orden visual

**Falta / por verificar**
- `AUDITORIA_MEJORAS.md` marca como **pendiente**: “Mejorar foco visible y estilos `:focus-visible`”.
- Falta implementar y marcar como ✅ con trazabilidad a `styles.css` y/o componentes.

---

### 1.3. Formularios accesibles: labels, agrupación, errores accionables
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf`
  - labels asociados (`label for` + `input id`)
  - `placeholder` no reemplaza label
  - `fieldset/legend` para grupos
  - errores específicos con `aria-describedby` y/o `role="alert"` / `aria-live`
- `UTN_Cátedra de EG_Checklist.pdf` (mensajes de verificación/error accesibles y útiles)
- `AUDITORIA_MEJORAS.md` (ya hay **ARIA live** pendiente en “Medio”)

**Requisito esperado**
- Cada campo tiene label programático
- Errores:
  - Indican **qué campo** falló, **por qué** y **cómo corregir**
  - Se anuncian correctamente para lectores de pantalla

**Falta / por verificar**
- En `AUDITORIA_MEJORAS.md` hay pendiente:
  - ✅/❌ “Añadir aria-live='polite' en contenedor de flash messages.” (actualmente [ ] )
- Además, falta una verificación global que *cada formulario* (login/register/contact/admin etc.) respete labels y manejo de errores.

---

### 1.4. Texto alternativo (ALT) y correcto etiquetado de imágenes
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf` (alt text: funcional/alt="" decorativas)
- `UTN_Cátedra de EG_Checklist.pdf` (accesibilidad)

**Requisito esperado**
- Imágenes decorativas => `alt=""`
- Imágenes funcionales => alt descriptivo (sin “imagen de…”)
- Si la imagen contiene texto relevante => incluirlo en alt o proveer texto equivalente

**Falta / por verificar**
- En el repo no hay checklist específico en `AUDITORIA_MEJORAS.md` para ALT.
- Debe auditarse cada `img` en vistas.

---

### 1.5. Color/contraste (WCAG 4.5:1)
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf` (contraste 4.5:1 / 3:1)
- `UTN_Cátedra de EG_Checklist.pdf` (accesibilidad)

**Requisito esperado**
- Mensajes de error / estados no dependen solo de color
- Contraste suficiente para texto normal y grande

**Falta / por verificar**
- No hay tarea explícita de contraste en `AUDITORIA_MEJORAS.md` o `TODO.md`.
- Debe auditarse `styles.css` y verificar foco/errores.

---

### 1.6. Idioma del documento (`html lang`)
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf` (declarar `html lang="es"`)

**Requisito esperado**
- `lang` en `public/index.php` / plantilla HTML base / header parcial (según arquitectura)

**Falta / por verificar**
- No está marcado explícitamente en `AUDITORIA_MEJORAS.md`.

---

### 1.7. Links descriptivos (sin “leer más / click aquí”)
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf`

**Falta / por verificar**
- No hay checklist explícito de texto de links.
- Debe auditarse navegación y listados.

---

### 1.8. Multimedia (subtítulos/transcripciones, sin autoplay con sonido)
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf`
- `accesibilidad_contenidos.pdf` (equivalentes para no textual y controles)

**Falta / por verificar**
- En repo no se informó presencia de video/audio.
- Si existe en vistas, debe comprobarse subtítulos/transcripciones y control del usuario.

---

### 1.9. Zoom/Responsive hasta 200% (legibilidad y no solapado)
**PDFs fuente**
- `UTN_Entornos_Gráficos_TipsDeAccesibilidad.pdf`

**Falta / por verificar**
- `TODO.md` tiene parallax responsivo mencionado, pero no valida WCAG zoom 200%.
- Debe convertirse en checklist de accesibilidad: “funciona hasta 200%”.

---

## 2) Criterios de “AirARG” (documento de estructura/navegación) que deben reflejarse en el código

**PDF fuente**
- `Trabajo Entornos Gráficos - Chacón, Carrizo, Gomez Manna, Jordán.pdf`

### 2.1. Navegación consistente y accesible por teclado
**Requisito esperado**
- Logo => redirección a home
- Navegación textual principal en header
- Menú contextual dinámico según rol
- Breadcrumbs
- Footer con enlace a mapa del sitio

**Falta / por verificar**
- `AUDITORIA_MEJORAS.md` no contempla breadcrumbs ni “mapa del sitio” como patrón de UI.
- Debe verificarse que `navbar.php` y páginas incluyan:
  - breadcrumbs (si el repo no los tiene, hay “falta”)
  - enlace a sitemap en footer (ya hay sitemap.xml, pero falta link UX)
  - consistencia de navegación textual principal.

---

## 3) Lo que ya está marcado como hecho (no constituye “faltantes”)
De `AUDITORIA_MEJORAS.md` (ya ✅):
- CSRF helper + meta + validación central
- Migración de contraseñas a `password_hash()`/`password_verify()` y cookies seguras
- OpenGraph/canonical
- sitemap.xml + robots.txt
- reemplazo de imágenes remotas por assets locales
- preload/fuentes locales

---

## 4) Resumen en formato “Checklist accionable”
### Pendientes principales (accesibilidad)
- [ ] Skip link a `main#contenido-principal`
- [ ] Landmarks semánticos (`header/nav/main/footer`)
- [ ] Foco visible consistente (evitar `outline: none` sin reemplazo) + ordenar tab
- [ ] aria-live para flash messages
- [ ] Formularios: labels asociados + errores específicos y anunciados
- [ ] ALT correcto para imágenes (y `alt=""` decorativas)
- [ ] Contraste 4.5:1 en texto + estados de error sin depender solo del color
- [ ] `html lang="es"`
- [ ] Links descriptivos
- [ ] Verificar zoom 200% y responsive sin romper layout
- [ ] Breadcrumbs + mapa del sitio link en footer (según AirARG)

### Pendientes secundarios (si existe multimedia)
- [ ] Verificar subtítulos/transcripción y control de reproducción
