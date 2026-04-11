# TODO de mejoras visuales (AirARG)

Checklist enfocado en look & feel, fotos, efectos y acciones visuales, manteniendo stack PHP + Bootstrap + JS.

## Prioridad alta (impacto inmediato)

- [x] Definir una guia visual base: paleta final, escala tipografica, espaciados y radios.
- [x] Reemplazar bloques planos por imagenes reales de destinos en Home, Vuelos y Novedades.
- [x] Unificar estilo de botones principales/secundarios (hover, active, disabled, focus visible).
- [x] Mejorar hero principal con foto de fondo de alta calidad + gradiente de contraste.
- [x] Convertir cards de vuelos en formato mas visual: iconos, chips de estado, precio destacado.
- [x] Mejorar jerarquia visual de formularios (titulos, ayudas, errores y estados de exito).
- [x] Agregar estados vacios ilustrados (sin resultados, sin reservas, sin noticias).
- [x] Reforzar contraste y legibilidad general para accesibilidad AA.

## Prioridad media (experiencia y microinteraccion)

- [x] Agregar microanimaciones suaves en cards, dropdowns, tabs y alertas.
- [x] Incorporar transiciones de entrada para secciones al hacer scroll (sin exceso).
- [x] Añadir skeleton loaders para listados de vuelos y noticias.
- [x] Mejorar paginacion mobile con controles compactos y mas visibles.
- [x] Agregar indicador visual de pagina activa en navbar y breadcrumbs en paneles.
- [x] Crear galeria simple de destinos con tarjetas de imagen + CTA.
- [x] Mejorar visual de reservas con timeline de estado (pendiente, confirmada, cancelada).
- [x] Agregar feedback visual inmediato en acciones clave (favorito, reservar, cancelar).

## Prioridad baja (polish)

- [ ] Incluir variantes de tema de fondos por seccion (Home, Vuelos, Admin, CEO).
- [ ] Refinar animaciones con easing consistente y duraciones estandar.
- [ ] Agregar parallax leve en hero (solo desktop, con fallback mobile).
- [ ] Mejorar detalles de iconografia SVG (grosor, alineacion, consistencia visual).
- [ ] Integrar placeholders visuales cuando falten fotos reales.
- [ ] Revisar coherencia de sombras, bordes y profundidad en todos los componentes.

## Biblioteca de assets visuales

- [ ] Armar carpeta de imagenes optimizadas por seccion (webp/jpg comprimido).
- [ ] Definir criterios de recorte y proporciones (hero, card horizontal, card vertical).
- [ ] Crear set minimo de ilustraciones SVG propias (empty states y ayudas).
- [ ] Agregar favicon y variantes de icono para consistencia de marca.

## QA visual (obligatorio antes de cerrar)

- [ ] Validar responsive real en 360px, 768px, 1024px y desktop amplio.
- [ ] Revisar foco de teclado en todos los controles interactivos.
- [ ] Probar rendimiento visual (sin animaciones pesadas en equipos lentos).
- [ ] Verificar que efectos respeten `prefers-reduced-motion`.
- [ ] Confirmar que las imagenes no rompan layout ni CLS.
