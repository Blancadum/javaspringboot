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

<article id="tema-6">
          <h3>6 — Controladores RESTful con <code class="kw">ResponseEntity&lt;T&gt;</code></h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">6. Controllers & ResponseEntity</div>
            <a href="#tema-6-restcontroller" class="topic-dropdown-item"><span class="item-num">6.1</span> <span class="item-title">Anatomía y Rol de @RestController</span></a>
            <a href="#tema-6-verbos" class="topic-dropdown-item"><span class="item-num">6.2</span> <span class="item-title">Mapeo de Endpoints CRUD y Códigos de Estado</span></a>
            <a href="#tema-6-responseentity" class="topic-dropdown-item"><span class="item-num">6.3</span> <span class="item-title">Respuestas Semánticas y Cabecera Location</span></a>
            <a href="#tema-6-mvc-arquitectura" class="topic-dropdown-item"><span class="item-num">6.4</span> <span class="item-title">Arquitectura Interna de Spring MVC: DispatcherServlet</span></a>
            <a href="#tema-6-webservices" class="topic-dropdown-item"><span class="item-num">6.5</span> <span class="item-title">Spring Web Services: RESTful vs SOAP</span></a>
          </div>
        </details>

          <p class="topic-intro">
            La capa de controladores expone la funcionalidad del sistema hacia el exterior respetando la semántica RESTful. Aquí aprenderás a mapear rutas y verbos HTTP, procesar parámetros dinámicos, estructurar respuestas ricas con <code class="kw">ResponseEntity</code> y comprender el flujo interno del <code class="kw">DispatcherServlet</code> en Spring MVC.
          </p>

          <h4 id="tema-6-restcontroller">6.1 Anatomía y Rol de @RestController</h4>
          <p>
            El <code class="ann">@RestController</code> combina <code class="ann">@Controller</code> y <code class="ann">@ResponseBody</code>, garantizando que el valor retornado por cada método se serialice directamente a JSON en el cuerpo de la respuesta HTTP.
          </p>

          <h4 id="tema-6-verbos">6.2 Mapeo de Endpoints CRUD y Códigos de Estado</h4>
          <p>
            Cada método atiende una operación RESTful (<code class="ann">@GetMapping</code>, <code class="ann">@PostMapping</code>, <code class="ann">@DeleteMapping</code>) delegando la lógica de negocio al servicio correspondiente.
          </p>

          <h4 id="tema-6-responseentity">6.3 Respuestas Semánticas y Cabecera Location</h4>
          <p>
            <code class="kw">ResponseEntity</code> permite controlar con precisión los códigos de estado HTTP (<code class="kw">200 OK</code>, <code class="kw">201 Created</code> con cabecera <code class="kw">Location</code>, <code class="kw">204 No Content</code>) y los encabezados de respuesta.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.controller;

<span class="kw">import</span> org.springframework.http.<span class="typ">ResponseEntity</span>;
<span class="kw">import</span> org.springframework.web.bind.annotation.*;
<span class="kw">import</span> org.springframework.web.util.<span class="typ">UriComponentsBuilder</span>;
<span class="kw">import</span> java.net.<span class="typ">URI</span>;
<span class="kw">import</span> java.util.<span class="typ">List</span>;

<span class="ann">@RestController</span>
<span class="ann">@RequestMapping</span>(<span class="str">"/api/v1/libros"</span>)
<span class="kw">public class</span> <span class="typ">LibroController</span> {

    <span class="kw">private final</span> <span class="typ">LibroService</span> libroService;

    <span class="kw">public</span> <span class="fn">LibroController</span>(<span class="typ">LibroService</span> libroService) {
        <span class="kw">this</span>.libroService = libroService;
    }

    <span class="ann">@GetMapping</span>
    <span class="kw">public</span> <span class="typ">ResponseEntity</span>&lt;<span class="typ">List</span>&lt;<span class="typ">LibroResponseDTO</span>&gt;&gt; <span class="fn">listarTodos</span>() {
        <span class="kw">return</span> <span class="typ">ResponseEntity</span>.<span class="fn">ok</span>(libroService.<span class="fn">obtenerTodos</span>());
    }

    <span class="ann">@PostMapping</span>
    <span class="kw">public</span> <span class="typ">ResponseEntity</span>&lt;<span class="typ">LibroResponseDTO</span>&gt; <span class="fn">crear</span>(
            <span class="ann">@RequestBody</span> <span class="typ">LibroRequestDTO</span> dto,
            <span class="typ">UriComponentsBuilder</span> ucb) {

        <span class="typ">LibroResponseDTO</span> nuevo = libroService.<span class="fn">guardar</span>(dto);
        <span class="typ">URI</span> uriUbicacion = ucb.<span class="fn">path</span>(<span class="str">"/api/v1/libros/{id}"</span>).<span class="fn">buildAndExpand</span>(nuevo.<span class="fn">id</span>()).<span class="fn">toUri</span>();

        <span class="kw">return</span> <span class="typ">ResponseEntity</span>.<span class="fn">created</span>(uriUbicacion).<span class="fn">body</span>(nuevo);
    }

    <span class="ann">@DeleteMapping</span>(<span class="str">"/{id}"</span>)
    <span class="kw">public</span> <span class="typ">ResponseEntity</span>&lt;<span class="typ">Void</span>&gt; <span class="fn">eliminar</span>(<span class="ann">@PathVariable</span> <span class="typ">Long</span> id) {
        libroService.<span class="fn">borrar</span>(id);
        <span class="kw">return</span> <span class="typ">ResponseEntity</span>.<span class="fn">noContent</span>().<span class="fn">build</span>();
    }
}</code></pre>
          </code-block>
          <h4 id="tema-6-mvc-arquitectura">6.4 Arquitectura Interna de Spring MVC: El Ciclo de Vida del DispatcherServlet</h4>
          <github-alert type="note" title="💡 Intuición para Principiantes: El DispatcherServlet y el Recepcionista del Hotel">
            <p>
              ¿Cómo sabe Spring qué método de Java ejecutar cuando un usuario hace clic en su navegador?
            </p>
            <p>
              El <strong><code class="kw">DispatcherServlet</code></strong> es como el <strong>Jefe de Recepción de un gran hotel de lujo</strong>:
            </p>
            <ol>
              <li>Llega un huésped por la puerta principal (una petición HTTP a <code class="kw">GET /api/v1/libros/42</code>).</li>
              <li>El recepcionista consulta su libro de reservas (<code class="kw">HandlerMapping</code>) para averiguar qué conserje o departamento especializado debe atenderlo. Encuentra que corresponde a <code class="kw">LibroController.obtenerPorId()</code>.</li>
              <li>Llama a un botones (<code class="kw">HandlerAdapter</code>) para que prepare la llave y los datos (convierte el texto <code class="kw">"42"</code> en un <code class="kw">Long</code> de Java con <code class="ann">@PathVariable</code>).</li>
              <li>El controlador llama a cocina (<code class="kw">LibroService</code>) para preparar el plato.</li>
              <li>El recepcionista toma el resultado, lo coloca en una bandeja de plata sellada (lo convierte a JSON con Jackson) y se lo entrega al huésped con una sonrisa y un código <code class="kw">200 OK</code>.</li>
            </ol>
          </github-alert>

          <p>
            Spring MVC implementa el patrón <strong>Front Controller</strong> a través del <code class="kw">DispatcherServlet</code>, que orquesta todo el procesamiento concurrente y escalable de peticiones HTTP empresariales:
          </p>
          <ol>
            <li><strong>Recepción</strong>: La petición HTTP entrante llega al contenedor embebido (Tomcat) y se delega al <code class="kw">DispatcherServlet</code>.</li>
            <li><strong>Mapeo de Ruta (HandlerMapping)</strong>: El <code class="kw">DispatcherServlet</code> consulta el registro de rutas para asociar la URL y el método HTTP al método específico del <code class="ann">@RestController</code>.</li>
            <li><strong>Adaptador de Ejecución (HandlerAdapter)</strong>: El <code class="kw">HandlerAdapter</code> gestiona la invocación, resolviendo argumentos (como <code class="ann">@RequestBody</code> o <code class="ann">@PathVariable</code>) mediante deserializadores JSON (<code class="kw">HttpMessageConverter</code> con Jackson).</li>
            <li><strong>Invocación de Servicio</strong>: Se ejecuta la lógica de negocio delegada a la capa <code class="ann">@Service</code>.</li>
            <li><strong>Serialización Directa</strong>: Al estar anotado con <code class="ann">@RestController</code>, el valor retornado (ej. <code class="kw">ResponseEntity&lt;DTO&gt;</code>) se serializa a JSON directamente en el flujo de salida HTTP con su código de estado (200, 201, 204).</li>
          </ol>

          <h4 id="tema-6-webservices">6.5 Spring Web Services: Arquitectura de Servicios Web RESTful (Spring MVC) vs SOAP (Spring-WS)</h4>
          <p>
            En el ecosistema empresarial Java, el concepto de <strong>Web Service</strong> abarca dos paradigmas principales para la integración de sistemas y microservicios:
          </p>
          <table>
            <thead>
              <tr>
                <th style="width: 25%;">Característica</th>
                <th style="width: 38%;">Servicios Web SOAP (Spring-WS)</th>
                <th style="width: 37%;">Servicios Web RESTful (Spring MVC)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Módulo Spring</strong></td>
                <td><code class="kw">Spring-WS</code> (enfocado en aproximación <em>Contract-First</em>).</td>
                <td><code class="kw">Spring Web / Spring MVC</code> (controladores con <code class="ann">@RestController</code>).</td>
              </tr>
              <tr>
                <td><strong>Formato de Mensaje</strong></td>
                <td>Sobres XML estrictos (Envelope, Header, Body) validados contra esquemas <code class="kw">.xsd</code>.</td>
                <td>Cargas ligeras (principalmente JSON vía Jackson, o XML opcional).</td>
              </tr>
              <tr>
                <td><strong>Definición de Contrato</strong></td>
                <td>Contrato formal en <code class="kw">WSDL</code> (Web Services Description Language).</td>
                <td>Especificación OpenAPI 3.0 / Swagger UI y semántica HTTP.</td>
              </tr>
              <tr>
                <td><strong>Protocolo de Transporte</strong></td>
                <td>Independiente del transporte (HTTP, SMTP, JMS, colas MQ).</td>
                <td>Estrechamente acoplada y optimizado sobre el protocolo HTTP/HTTPS.</td>
              </tr>
              <tr>
                <td><strong>Estándares de Seguridad</strong></td>
                <td><code class="kw">WS-Security</code> a nivel de mensaje (cifrado y firma de nodos XML).</td>
                <td>Seguridad a nivel de transporte (TLS/HTTPS) y tokens criptográficos (JWT, OAuth2).</td>
              </tr>
              <tr>
                <td><strong>Consumo de Clientes</strong></td>
                <td><code class="kw">WebServiceTemplate</code> enviando payloads XML marshaller/unmarshaller.</td>
                <td><code class="kw">RestClient</code> (moderno en Spring Boot 3) y <code class="kw">RestTemplate</code> (clásico).</td>
              </tr>
            </tbody>
          </table>
        </article>

        <!-- TEMA 7 -->
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
