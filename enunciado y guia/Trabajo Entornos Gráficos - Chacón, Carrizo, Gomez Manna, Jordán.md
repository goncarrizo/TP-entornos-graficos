  
![][image1]

“AirARG”

***Facultad Regional Rosario***

Cátedra de: ENTORNOS GRÁFICOS

Trabajo Práctico Año 2026

Integrantes:

**Agustina Celeste Chacón**, 50980, aguscchacon@gmail.com  
**Gonzalo Carrizo**, 51091, gonzacarrizo123456@gmail.com  
**Joaquina Gomez Manna**, 47791, gomezmannajoaquina@gmail.com  
**Nicolás Jordán**, 51276, nicojordan2609@gmail.com

## **Índice**

[**Introducción	3**](#introducción)

[**Definición del Sitio Web	3**](#definición-del-sitio-web)

[a. Objetivos del Sitio	3](#a.-objetivos-del-sitio)

[b. Descripción del Sitio	4](#b.-descripción-del-sitio)

[**Definición de la Audiencia	4**](#definición-de-la-audiencia)

[**4\. Definición de los contenidos del sitio	6**](#4.-definición-de-los-contenidos-del-sitio)

[a. Agrupación por contenidos	6](#a.-agrupación-por-contenidos)

[**5\. Definición de la estructura del sitio	7**](#5.-definición-de-la-estructura-del-sitio)

[a. Mapa del sitio (árbol de contenido funcional)	7](#a.-mapa-del-sitio-\(árbol-de-contenido-funcional\))

[b. Diagrama de la estructura de las páginas	9](#b.-diagrama-de-la-estructura-de-las-páginas-\(bocetos\))

[c. Diagrama de flujo de interacción	1](#c.-diagrama-de-flujo-de-interacción)4

[**6\. Definición de los sistemas de navegación**](#6.-definición-de-los-sistemas-de-navegación)	**23**

## **Introducción** {#introducción}

El presente trabajo práctico tiene como objetivo el desarrollo de un sitio web funcional al que llamamos “AirARG” orientado a la gestión de reservas de pasajes de avión. Este proyecto se enmarca dentro de la asignatura Entornos Gráficos, con la finalidad de integrar y aplicar conocimientos adquiridos a lo largo de la carrera de Ingeniería en Sistemas de Información.

A través de este desarrollo, se busca abordar una problemática real mediante la construcción de una solución tecnológica que contemple aspectos fundamentales como la usabilidad, la accesibilidad, la arquitectura de la información y las buenas prácticas de desarrollo web.

El sistema permitirá la interacción de distintos tipos de usuarios, facilitando la búsqueda, reserva y gestión de vuelos, así como la administración de la información por parte de aerolíneas y administradores del sistema. De esta manera, se propone no solo implementar funcionalidades técnicas, sino también diseñar una experiencia de usuario clara, eficiente e intuitiva.

## **Definición del Sitio Web** {#definición-del-sitio-web}

### **a. Objetivos del Sitio** {#a.-objetivos-del-sitio}

El objetivo principal del sitio web es brindar una plataforma digital que permita gestionar de manera eficiente el proceso de búsqueda, reserva y administración de pasajes aéreos.

Las tecnológicas y los lenguajes que utilizaremos son:

* HTML 5  
* CSS3  
* Bootstrap  
* JavaScript  
* jQuery  
* PHP  
* MySQL  
* XAMPP

Como objetivos específicos u objetivos secundarios se plantean:

* Permitir a los usuarios buscar vuelos mediante distintos criterios (origen, destino, fechas, disponibilidad, etc.).  
* Facilitar la reserva y compra de pasajes de avión de manera simple y segura.  
* Brindar herramientas para la gestión de reservas, incluyendo consulta de historial y cancelaciones.  
* Permitir a las aerolíneas administrar vuelos, disponibilidad y promociones.  
* Proveer al administrador un control centralizado del sistema, incluyendo la gestión de aerolíneas, promociones, novedades y reportes.  
* Garantizar una experiencia de usuario basada en criterios de usabilidad, accesibilidad y navegación intuitiva.  
* Asegurar la integridad y consistencia de la información gestionada dentro del sistema.

### **b. Descripción del Sitio** {#b.-descripción-del-sitio}

El sitio web será una plataforma interactiva orientada a la gestión integral de reservas de vuelos, accesible desde navegadores web y diseñada bajo criterios de accesibilidad y diseño responsive.

El sistema contempla distintos tipos de usuarios, cada uno con funcionalidades específicas:

* **Usuarios no registrados:** podrán acceder a información general sobre vuelos, aerolíneas y promociones.  
* **Usuarios registrados (clientes):** podrán buscar vuelos, realizar reservas, gestionar su perfil y consultar su historial de compras.  
* **CEOs de aerolíneas:** tendrán acceso a funcionalidades de gestión de vuelos, disponibilidad y creación de promociones.  
* **Administrador:** contará con control total del sistema, pudiendo gestionar aerolíneas, aprobar promociones, administrar contenidos (novedades) y generar reportes para tomar decisiones estratégicas.

El sistema incluirá funcionalidades clave tales como:

* Registro y autenticación de usuarios.  
* Gestión de sesiones.  
* Búsqueda y filtrado de vuelos.  
* Reserva y confirmación de pasajes.  
* Gestión de promociones.  
* Envío de notificaciones (por ejemplo, validación de cuenta).  
* Visualización de historial de reservas.

Asimismo, contará con una estructura de navegación clara, incluyendo secciones como inicio, registro, login, perfil de usuario y mapa del sitio, con el objetivo de mejorar la experiencia de usuario.

## **Definición de la Audiencia** {#definición-de-la-audiencia}

El sitio web está dirigido a distintos tipos de usuarios, los cuales presentan necesidades y niveles de conocimiento diferentes:

**1\. Según sus roles en el sistema:**

* **Clientes o pasajeros:** personas que desean buscar y reservar vuelos de forma rápida, sencilla y segura. Este grupo incluye usuarios con distintos niveles de experiencia digital, por lo que se prioriza una interfaz intuitiva, clara y accesible.  
* **Empresas aéreas (CEOs de aerolíneas):** usuarios con un perfil más técnico-administrativo, responsables de gestionar la oferta de vuelos, disponibilidad y promociones. Requieren herramientas eficientes, organizadas y con acceso a información relevante para la toma de decisiones.  
* **Administrador del sistema:** usuario con conocimientos técnicos, encargado de supervisar el funcionamiento general de la plataforma, gestionar contenido, validar información y generar reportes.  
* **Público general:** usuarios no registrados que accedan al sitio con fines informativos, interesados en conocer la oferta de vuelos y aerolíneas disponibles.

**2\. Según sus Características y Necesidades (Guía Web de Chile):**

* **Por ubicación geográfica (e idiomas):** Al ser un sistema de vuelos, la audiencia ingresará desde múltiples ciudades, regiones o incluso otros países. El diseño deberá contemplar la **Internacionalización** para adaptar el sitio a diferentes idiomas, regiones y formatos locales (horas, fechas, direcciones) sin crear barreras, previendo soporte para distintos idiomas, claridad en los formatos de fechas, horarios y monedas internacionales.  
* **Por conocimiento de la institución:** Se diferencia claramente a los usuarios internos (Administradores y CEOs), que manejan el vocabulario técnico aerocomercial y la estructura de la plataforma, de los usuarios externos (clientes y público general). Para estos últimos, el sitio no debe usar siglas ni jerga administrativa, facilitando un lenguaje claro y directo para que encuentren lo que buscan sin esfuerzo.  
* **Por capacidad técnica (y experiencia digital):** La audiencia se divide según su experiencia técnica e infraestructura. Se debe ofrecer una interfaz sencilla e intuitiva con enlaces directos para los clientes o usuarios novatos, mientras que para los perfiles administrativos (CEOs y Administradores) se habilitarán buscadores avanzados y herramientas de gestión eficientes.  
* **Por necesidades de información:** El sitio debe equilibrar la atención entre los usuarios que ingresan con una misión específica (clientes listos para comprar un pasaje o administradores generando un reporte puntual) y aquellos usuarios que solo están explorando la oferta para ver si encuentran información que les sirva (público general viendo promociones).  
* **Por capacidad física:** Como requisito transversal e indispensable, la audiencia incluye a personas con diferentes discapacidades físicas, visuales o motrices. El sitio debe garantizar la accesibilidad universal para todos estos grupos implementando los estándares internacionales, específicamente las **Pautas de Accesibilidad para el Contenido Web (WCAG)**, asegurando que todos los roles puedan operar la plataforma mediante tecnologías de apoyo.

En términos generales, la audiencia del sistema es heterogénea, por lo que el diseño del sitio deberá equilibrar simplicidad de uso para usuarios finales con funcionalidades más avanzadas para perfiles administrativos, garantizando una experiencia eficiente para todos los tipos de usuario.

## **4\. Definición de los contenidos del sitio** {#4.-definición-de-los-contenidos-del-sitio}

### **a. Agrupación por contenidos** {#a.-agrupación-por-contenidos}

El sitio contará con los siguientes módulos: 

**Administrador**: este módulo permitirá gestionar las aerolíneas registradas, aprobar o denegar promociones, administrar las novedades y generar reportes globales de toda la plataforma. 

**CEO de Aerolínea**: en este módulo, el encargado podrá gestionar los vuelos y promociones específicos de su aerolínea. Además, podrá acceder a reportes de ventas y niveles de ocupación. 

**Pasajero (Usuario registrado)**: en este módulo el pasajero podrá buscar y realizar reservas, consultar su estado, cancelarlas y ver su historial de compras. También incluye la gestión de su cuenta (registro, inicio de sesión, recuperación de clave, perfil) y la visualización de novedades. 

Por último, existirán secciones de acceso público (sin logueo previo):

**Página principal**: página que recibe a todo usuario, donde se muestra información general, vuelos, aerolíneas, promociones destacadas y novedades.

 **Buscador de vuelos**: sección pública que permite a cualquier visitante buscar disponibilidad de vuelos. 

**Navegación transversal**: enlaces rápidos y un mapa del sitio que estarán presentes en todas las páginas para facilitar la navegación global. 

**b. Requerimientos funcionales**

### **Búsqueda de Vuelos**

* **Buscador público:** Permitir a cualquier usuario buscar vuelos disponibles sin necesidad de registro.  
* **Filtros de búsqueda:** Habilitar el filtrado de vuelos por origen, destino, fechas y disponibilidad de asientos.  
* **Paginación:** Mostrar los resultados de búsqueda de manera paginada para facilitar la navegación.

### **Autenticación y Gestión de Usuarios**

* **Sistema de login:** Gestionar el inicio de sesión y el manejo de sesiones de los usuarios.  
* **Control de roles:** Restringir el acceso a las diferentes secciones de la plataforma según el rol del usuario (Administrador, CEO, Cliente).  
* **Registro de clientes:** Requerir la validación del correo electrónico para activar las cuentas de pasajeros.  
* **Registro de directivos:** Requerir la aprobación manual de un Administrador para dar de alta cuentas de ejecutivos de aerolíneas.

### **Gestión de Reservas**

* **Flujo de estados:** Iniciar las reservas en estado de "pago pendiente" y actualizarlas automáticamente a "confirmadas" una vez verificado el cobro.  
* **Actualización de inventario:** Descontar de forma automática el asiento del vuelo correspondiente al confirmar una reserva.  
* **Autogestión del usuario:** Permitir a los clientes visualizar, confirmar o cancelar sus reservas, aplicando las reglas de negocio establecidas.

### **Notificaciones y Comunicación**

* **Emails automáticos:** Enviar correos electrónicos desde el servidor para validación de cuentas, recuperación de contraseñas y notificaciones de estado.  
* **Formularios de contacto:** Proveer formularios para resolución de dudas, con validación de datos ingresados.

## **5\. Definición de la estructura del sitio** {#5.-definición-de-la-estructura-del-sitio}

### **a. Mapa del sitio (árbol de contenido funcional)** {#a.-mapa-del-sitio-(árbol-de-contenido-funcional)}

**![][image2]**

**Inicio (Público)**  
Página principal del sistema que permite acceder a la búsqueda de vuelos, destinos destacados, aerolíneas, novedades y acceso rápido a la cuenta.

**Vuelos (Público / Usuarios registrados)**  
Módulo principal para buscar, consultar y reservar vuelos. Incluye resultados, detalle de vuelo, reservas y favoritos.

**Promociones (Público)**  
Sección destinada a visualizar ofertas y descuentos disponibles, tanto generales como por aerolínea.

**Novedades (Público)**  
Espacio informativo donde se publican noticias, avisos y actualizaciones relevantes para los usuarios.

**Mi Cuenta (Usuarios registrados)**  
Área personal para gestionar el perfil, las reservas y las notificaciones del usuario.

**Soporte (Público)**  
Centro de ayuda que brinda acceso a preguntas frecuentes, contacto y estado del sistema.

**Dashboard de Gestión (Usuarios administrativos)**  
Área de administración del sistema reservada para perfiles con permisos de gestión.

* **Administrador:** Gestiona aerolíneas, novedades, promociones y reportes generales de la plataforma.  
* **CEO de Aerolínea:** Administra vuelos, promociones y reportes de su propia aerolínea.

**Navegación Global (Disponible en todo el sitio)**  
Accesos permanentes a FAQ, Contacto, Mapa del Sitio, Términos y Condiciones, Política de Privacidad y Accesibilidad.

### **b. Diagrama de la estructura de las páginas (bocetos)** {#b.-diagrama-de-la-estructura-de-las-páginas-(bocetos)}

* Página de inicio:   
  ![][image3]

* Vuelos:  
    
  ![][image4]  
    
    
    
* Novedades:  
    
  ![][image5]  
    
* Cuenta / mis reservas:  
    
  ![][image6]

* Panel admin  
    
  ![][image7]

* Panel ceo  
    
  ![][image8]

* Crear Cuenta![][image9]  
* Inicio de sesion: ![][image10]

### 

### **c. Diagrama de flujo de interacción** {#c.-diagrama-de-flujo-de-interacción}

Flujo General de Navegación de Sitio  
![][image11]

Flujo Registro  
![][image12]

Flujo Inicio de Sesión  
![][image13]

Flujo de Búsqueda, Favoritos y Reserva Vuelos![][image14]  
Flujo de cancelación  
![][image15]  
Aprobación de promociones  
![][image16]  
Flujo Panel de CEO  
![][image17]

Flujo Panel de Administrador  
![][image18]

Flujo de Noticias  
![][image19]  
Flujo de contacto y Soporte  
![][image20]  
Flujo Gestión de Cuenta y Perfil  
![][image21]

## **6\. Definición de los sistemas de navegación** {#6.-definición-de-los-sistemas-de-navegación}

En este proyecto se utilizará un sistema de navegación consistente, uniforme y visible, con el objetivo de que el usuario no se desoriente durante su recorrido. El logotipo del sitio funcionará como un control de navegación global, redireccionando de manera constante a la página principal desde cualquier vista de la plataforma. 

* **Navegación Textual Principal:** ubicada en el encabezado, permite acceder con rapidez a las secciones clave del sitio (búsqueda, promociones, novedades). Es totalmente accesible mediante teclado e incluye un enlace oculto para lectores de pantalla.  
* **Navegación Contextual Dinámica:** menú que se ajusta según el rol del usuario autenticado, asegurando que cada perfil visualice exclusivamente las opciones y funcionalidades que le corresponden.  
* **Migas de pan (Breadcrumbs):** elemento de navegación contextual que indica la ruta del usuario y facilita su retroceso a niveles superiores del sitio de manera intuitiva.  
* **Pie de Página (Footer):** elemento de navegación textual ubicado en la parte inferior de cada página, que incluye un enlace permanente al mapa del sitio para ofrecer una vía alternativa de acceso global.  
* **Buscador Global:** herramienta presente en toda la navegación para localizar vuelos e información de manera eficiente en cualquier momento.

