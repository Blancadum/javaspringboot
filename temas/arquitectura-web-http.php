<?php
  $is_standalone = empty($in_bloque_context);
  if ($is_standalone) {
    include_once __DIR__ . '/../components/header.php';
    include_once __DIR__ . '/../components/sidebar.php';
  }
?>

<?php if ($is_standalone): ?>
    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
<?php endif; ?>

<article id="tema-1">
          <h3>1 — Arquitectura Web y Protocolo HTTP</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">1. Arq. Web + HTTP</div>
            <a href="#tema-1-mpa-spa" class="topic-dropdown-item"><span class="item-num">1.1</span> <span class="item-title">MPA vs SPA: El Flujo de Datos en la Web Moderna</span></a>
            <a href="#tema-1-http-verbos" class="topic-dropdown-item"><span class="item-num">1.2</span> <span class="item-title">Anatomía de una Petición HTTP: Verbos, Cabeceras y Cuerpo</span></a>
            <a href="#tema-1-http-estados" class="topic-dropdown-item"><span class="item-num">1.3</span> <span class="item-title">Códigos de Estado HTTP: Semántica de la Respuesta</span></a>
            <a href="#tema-1-mvc-clasico" class="topic-dropdown-item"><span class="item-num">1.4</span> <span class="item-title">El Patrón MVC Clásico y el Flujo de Petición en Java EE</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Para dominar el desarrollo backend, es fundamental comprender cómo viajan los datos entre el cliente y el servidor. Este tema analiza la evolución de las aplicaciones web desde el modelo MPA hasta las APIs REST modernas, el funcionamiento interno del protocolo HTTP y la implementación del patrón MVC en el ecosistema Java.
          </p>

          <h4 id="tema-1-mpa-spa">1.1 MPA vs SPA: El Flujo de Datos en la Web Moderna</h4>
          <p>
            En la arquitectura de software actual coexisten dos paradigmas fundamentales para la entrega de contenido y la gestión de la interfaz de usuario: las <strong>Multi-Page Applications (MPA)</strong> y las <strong>Single-Page Applications (SPA)</strong>. Comprender sus diferencias operativas es crucial para elegir la estrategia de renderizado adecuada en aplicaciones empresariales Spring Boot.
          </p>

          <h5>1. Multi-Page Application (MPA) — Renderizado en Servidor (SSR)</h5>
          <p>
            En el modelo MPA tradicional, el servidor asume la responsabilidad total de generar la interfaz gráfica. Cuando el usuario hace clic en un enlace o envía un formulario:
          </p>
          <ul>
            <li><strong>Procesamiento en Servidor:</strong> Spring MVC procesa la petición, consulta la base de datos y utiliza un motor de plantillas (como <strong>Thymeleaf</strong> o JSP) para compilar y combinar los datos con el HTML.</li>
            <li><strong>Respuesta Completa:</strong> El servidor envía al cliente un documento HTML totalmente renderizado.</li>
            <li><strong>Recarga Completa del DOM:</strong> El navegador descarta el árbol DOM actual y reconstruye la pantalla desde cero.</li>
          </ul>

          <h5>2. Single-Page Application (SPA) — Renderizado en Cliente (CSR)</h5>
          <p>
            En el modelo SPA moderno, la aplicación web funciona de forma similar a una aplicación de escritorio local:
          </p>
          <ul>
            <li><strong>Carga Inicial del Shell:</strong> Al ingresar, el servidor entrega un archivo HTML mínimo (shell) junto con los bundles de JavaScript compilados (React, Angular o Vue).</li>
            <li><strong>Intercambio de Datos JSON:</strong> La aplicación JavaScript toma el control del DOM y se comunica con el servidor Spring Boot exclusivamente mediante peticiones asíncronas HTTP (Fetch / Axios) solicitando datos en formato <strong>JSON</strong> a través de endpoints REST.</li>
            <li><strong>Actualización Parcial e Instantánea:</strong> El motor del navegador actualiza partes específicas de la interfaz en tiempo real sin recargar la página completa.</li>
          </ul>

          <h5>Tabla Comparativa: MPA vs SPA</h5>
          <table>
            <thead>
              <tr>
                <th>Criterio / Característica</th>
                <th>MPA (Multi-Page Application)</th>
                <th>SPA (Single-Page Application)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Lugar de Renderizado</strong></td>
                <td><strong>Server-Side Rendering (SSR)</strong>: El HTML final se genera en el servidor (ej. Thymeleaf).</td>
                <td><strong>Client-Side Rendering (CSR)</strong>: El DOM lo construye el navegador mediante JavaScript (ej. React, Angular).</td>
              </tr>
              <tr>
                <td><strong>Ciclo de Petición / Respuesta</strong></td>
                <td>Envía peticiones HTTP completas y recibe documentos HTML completos por cada vista.</td>
                <td>Carga inicial del bundle de JS y subsiguientes intercambios de datos en formato <strong>JSON</strong> vía REST API.</td>
              </tr>
              <tr>
                <td><strong>Recarga de Página</strong></td>
                <td>Recarga total del navegador (blanqueo momentáneo y reconstrucción completa del DOM).</td>
                <td><strong>Cero recargas totales</strong>. Actualizaciones locales y fluidas de nodos específicos del DOM.</td>
              </tr>
              <tr>
                <td><strong>Rendimiento FCP (First Contentful Paint)</strong></td>
                <td><strong>Rápido en la primera carga</strong>: El navegador recibe HTML directo para renderizar de inmediato.</td>
                <td><strong>Más lento al inicio</strong>: Requiere descargar e interpretar primero el bundle de JavaScript.</td>
              </tr>
              <tr>
                <td><strong>Navegación entre Pantallas</strong></td>
                <td>Latencia de red en cada navegación; respuesta determinada por el tiempo de generación del servidor.</td>
                <td><strong>Navegación instantánea</strong> tras la carga inicial; la UI responde sin parpadeos.</td>
              </tr>
              <tr>
                <td><strong>SEO & Indexación</strong></td>
                <td><strong>Nativo e inmejorable</strong>. Los bots de motores de búsqueda rastrean HTML estructurado directo.</td>
                <td>Requiere técnicas adicionales (SSR con Next.js/Nuxt, Pre-rendering o hidratación) para indexar contenido dinámico.</td>
              </tr>
              <tr>
                <td><strong>Gestión de Estado & Seguridad</strong></td>
                <td>Estado gestionado centralmente en servidor (Sesión HTTP / <code>JSESSIONID</code>). Menor riesgo de XSS en datos.</td>
                <td>Estado mantenido en memoria del cliente (Redux/Pinia). Autenticación stateless con <strong>JWT</strong> (Tokens).</td>
              </tr>
              <tr>
                <td><strong>Arquitectura de Desarrollo</strong></td>
                <td>Monolito acoplado donde la capa de presentación reside dentro del proyecto Spring Boot.</td>
                <td><strong>Desacoplamiento total</strong>: Backend Spring Boot (API REST pura) + Frontend desacoplado (React/Vue/Angular).</td>
              </tr>
            </tbody>
          </table>

          <div class="block-flow-container" style="margin: 20px 0; padding: 15px; background: var(--color-canvas-subtle); border-radius: 8px; border: 1px dashed var(--color-border-muted); font-size: 13px;">
            <p style="margin: 0 0 10px 0;"><strong>Flujo de Comunicación Comparativo:</strong></p>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
              <div style="flex: 1; min-width: 250px; background: var(--color-canvas-default); padding: 12px; border-radius: 6px; border: 1px solid var(--color-border-default);">
                <span style="color: var(--color-accent); font-weight: 600;">🔄 Flujo MPA (Spring MVC + Thymeleaf)</span><br>
                <code>Navegador ➔ GET /libros ➔ Spring Controller ➔ Thymeleaf HTML ➔ Navegador (Recarga DOM)</code>
              </div>
              <div style="flex: 1; min-width: 250px; background: var(--color-canvas-default); padding: 12px; border-radius: 6px; border: 1px solid var(--color-border-default);">
                <span style="color: var(--color-success-fg); font-weight: 600;">⚡ Flujo SPA (Spring Boot REST + React)</span><br>
                <code>Navegador ➔ Fetch GET /api/libros ➔ REST Controller ➔ JSON ➔ React DOM Update (Sin recarga)</code>
              </div>
            </div>
          </div>

          <h4 id="tema-1-http-verbos">1.2 Anatomía de una Petición HTTP: Verbos, Cabeceras y Cuerpo</h4>
          <p>
            El protocolo HTTP es la base de la comunicación en la web. Una petición se compone de:
          </p>
          <ol>
            <li><strong>Línea de Petición</strong>: Incluye el Verbo HTTP, la URI y la versión del protocolo (ej. <code>GET /api/v1/libros HTTP/1.1</code>).</li>
            <li><strong>Cabeceras (Headers)</strong>: Metadatos sobre la petición (<code>Content-Type: application/json</code>, <code>Accept: application/json</code>, <code>Authorization: Bearer token</code>).</li>
            <li><strong>Cuerpo (Body)</strong>: Los datos enviados al servidor (usualmente un JSON en peticiones POST o PUT).</li>
          </ol>

          <p><strong>Verbos HTTP Esenciales:</strong></p>
          <table>
            <thead>
              <tr>
                <th>Verbo</th>
                <th>Acción</th>
                <th>Semántica en BiblioTech</th>
                <th>Idempotencia</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><code class="kw">GET</code></td>
                <td>Leer / Recuperar</td>
                <td><code>GET /api/v1/libros</code> (Obtener catálogo completo)</td>
                <td>Sí</td>
              </tr>
              <tr>
                <td><code class="kw">POST</code></td>
                <td>Crear / Procesar</td>
                <td><code>POST /api/v1/libros</code> (Registrar nuevo libro)</td>
                <td>No</td>
              </tr>
              <tr>
                <td><code class="kw">PUT</code></td>
                <td>Reemplazar / Actualizar</td>
                <td><code>PUT /api/v1/libros/123</code> (Actualizar todos los datos del libro 123)</td>
                <td>Sí</td>
              </tr>
              <tr>
                <td><code class="kw">DELETE</code></td>
                <td>Eliminar</td>
                <td><code>DELETE /api/v1/libros/123</code> (Borrar libro del catálogo)</td>
                <td>Sí</td>
              </tr>
            </tbody>
          </table>

          <h4 id="tema-1-http-estados">1.3 Códigos de Estado HTTP: Semántica de la Respuesta</h4>
          <p>
            El servidor responde siempre con un código numérico que indica el resultado de la operación:
          </p>
          <ul>
            <li><strong class="gh-badge success">2xx (Éxito)</strong>: La petición fue recibida y procesada correctamente. (Ej. <code>200 OK</code>, <code>201 Created</code> para nuevos recursos).</li>
            <li><strong class="gh-badge attention">4xx (Error del Cliente)</strong>: La petición es incorrecta o el recurso no existe. (Ej. <code>400 Bad Request</code>, <code>401 Unauthorized</code>, <code>404 Not Found</code>).</li>
            <li><strong class="gh-badge danger">5xx (Error del Servidor)</strong>: El servidor falló al procesar una petición válida. (Ej. <code>500 Internal Server Error</code>).</li>
          </ul>

          <h4 id="tema-1-mvc-clasico">1.4 El Patrón MVC Clásico y el Flujo de Petición en Java EE</h4>
          <p>
            El patrón <strong>Modelo-Vista-Controlador (MVC)</strong> separa la lógica de negocio, la interfaz de usuario y la orquestación del flujo.
          </p>
          <table>
            <thead>
              <tr>
                <th>Componente</th>
                <th>Rol Técnico</th>
                <th>Ejemplo en Java EE / Spring</th>
                <th>Responsabilidad</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Modelo (Model)</strong></td>
                <td>Lógica y Datos</td>
                <td>Entidades JPA, Servicios (@Service)</td>
                <td>Gestiona los datos, las reglas de validación de negocio y el acceso a la persistencia. Es agnóstico a la web.</td>
              </tr>
              <tr>
                <td><strong>Vista (View)</strong></td>
                <td>Interfaz de Usuario</td>
                <td>Thymeleaf, JSP, Payloads JSON</td>
                <td>Presenta los datos al usuario final. No ejecuta lógica de negocio ni consultas directas a la base de datos.</td>
              </tr>
              <tr>
                <td><strong>Controlador (Controller)</strong></td>
                <td>Orquestador</td>
                <td>@RestController, HttpServlet</td>
                <td>Punto de entrada: intercepta la petición HTTP, invoca al Modelo, prepara los datos y despacha el flujo hacia la Vista adecuada.</td>
              </tr>
            </tbody>
          </table>

          <p><strong>El Flujo Completo de Petición en el MVC Clásico:</strong></p>
          <ol>
            <li><strong>Llegada de la Petición:</strong> El cliente envía <code>GET /catalogo</code>. El contenedor despacha la petición hacia el Servlet Controlador correspondiente.</li>
            <li><strong>Ejecución de Lógica:</strong> El Servlet invoca el servicio de negocio del Modelo: <code>List&lt;Libro&gt; libros = catalogoService.obtenerTodos();</code>.</li>
            <li><strong>Almacenamiento en el Ámbito (Scope):</strong> El Servlet inyecta el resultado como atributo en la petición: <code>req.setAttribute("libros", libros);</code>.</li>
            <li><strong>Despacho Interno (Forward):</strong> El Servlet transfiere el control a la página JSP interna:
              <br><code>RequestDispatcher dispatcher = req.getRequestDispatcher("/WEB-INF/vistas/catalogo.jsp");</code>
              <br><code>dispatcher.forward(req, res);</code>
              <github-alert type="tip" title="La Regla de Oro del Directorio /WEB-INF/">
                <p>
                  Los archivos JSP deben ubicarse siempre dentro del directorio <code>/WEB-INF/</code>. La especificación Servlet prohíbe que el navegador acceda directamente por URL a cualquier archivo situado bajo <code>/WEB-INF/</code>. Solo un Servlet interno puede despachar hacia ellos mediante <code>forward()</code>, garantizando que nadie pueda saltarse la lógica del Controlador.
                </p>
              </github-alert>
            </li>
            <li><strong>Renderizado de la Vista:</strong> <code>catalogo.jsp</code> extrae la colección mediante EL (<code>${requestScope.libros}</code>) y JSTL, compone el marcado HTML y el contenedor lo envía como cuerpo de la respuesta HTTP al cliente.</li>
          </ol>

          <p>
            <em>Evolución hacia Spring MVC:</em> En el Tema 6 comprobarás cómo este patrón clásico evolucionó hacia el <strong><code>DispatcherServlet</code></strong> de Spring MVC, que actúa como <em>Front Controller</em> único interceptando todas las peticiones y orquestando el enrutamiento a controladores anotados con <code>@RestController</code>.
          </p>
        </article>

        <!-- TEMA 2 -->
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
