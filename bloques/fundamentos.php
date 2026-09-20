<?php
  $in_bloque_context = true;
  include_once __DIR__ . "/../components/header.php";
  include_once __DIR__ . "/../components/sidebar.php";
?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- BLOQUE 1: FUNDAMENTOS -->
          <section id="fase-1" class="study-section">
            <h2>Bloque 1: Fundamentos</h2>

            <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
            <div class="block-intro-layout">
              <div class="block-summary-side">
                <div class="block-summary-card">
                    <h4 class="block-summary-title">🚀 Visión General del Bloque</h4>
                    <p class="block-summary-text">
                        El Bloque 1 establece los <strong>cimientos técnicos</strong> sobre los que se construye toda la aplicación. Antes de programar lógica compleja, es imperativo entender cómo viajan los datos por la red y cómo se organizan los proyectos modernos de Java.
                        <br><br>
                        Comenzaremos analizando el <strong>Protocolo HTTP</strong> y la diferencia entre arquitecturas MPA y SPA para entender el flujo de datos. Luego, dominaremos la <strong>serialización JSON con Jackson</strong>, el lenguaje universal de las APIs.
                        <br><br>
                        Posteriormente, configuraremos el entorno profesional utilizando <strong>Maven y Lombok</strong> para garantizar la reproducibilidad y limpieza del código. Finalmente, nos adentraremos en la <strong>Inversión de Control (IoC)</strong>, el concepto más potente de Spring, que nos permite crear software desacoplado y altamente testeable.
                    </p>
                </div>
              </div>

              <div class="block-intro-main">
                <h3 class="block-intro-heading">Objetivos de Aprendizaje — Bloque 1</h3>
                <div class="study-checks-grid">
                    <study-check id="f1_t1">Diferenciar entre MPA y SPA y comprender el ciclo de petición/respuesta HTTP.</study-check>
                    <study-check id="f1_t2">Implementar la serialización y deserialización de objetos Java a JSON usando Jackson.</study-check>
                    <study-check id="f1_t3">Gestionar dependencias y el ciclo de vida de construcción con Apache Maven.</study-check>
                    <study-check id="f1_t4">Utilizar Lombok para eliminar el código repetitivo (Boilerplate) en entidades de datos.</study-check>
                    <study-check id="f1_t5">Aplicar la Inversión de Control (IoC) y la Inyección de Dependencias mediante el ApplicationContext de Spring.</study-check>
                    <study-check id="f1_t6">Implementar la modularización de lógica transversal mediante Spring AOP.</study-check>
                </div>

              </div>
            </div>

            <!-- FLUJO DE PROGRESIÓN TÉCNICA -->
            <div class="block-flow-container">
                <div class="block-flow-item"><strong>1. Web</strong><br>HTTP & MVC</div>
                <div class="block-flow-separator">➔</div>
                <div class="block-flow-item"><strong>2. Datos</strong><br>JSON & Jackson</div>
                <div class="block-flow-separator">➔</div>
                <div class="block-flow-item"><strong>3. Tooling</strong><br>Maven & Lombok</div>
                <div class="block-flow-separator">➔</div>
                <div class="block-flow-item"><strong>4. Corazón</strong><br>IoC & AOP</div>
            </div>

            <div class="block-topic-cluster">
              <div class="block-topic-cluster-header">
                <h3>Temas del bloque</h3>
              </div>
              <div class="block-topic-cluster-grid">
                <a class="block-topic-card" href="<?php echo $base_url; ?>fundamentos/arquitectura-web-http"><span>1</span> Arquitectura Web y HTTP</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>fundamentos/json-jackson"><span>2</span> JSON y Jackson</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>fundamentos/maven-lombok"><span>3</span> Maven y Lombok</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>fundamentos/core-spring-ioc"><span>4</span> Core Spring (IoC)</a>
              </div>
            </div>

            <figure class="block-summary-figure">
              <img src="../img/FASE1.png" alt="Fase 1: Fundamentos">
              <figcaption>Figura 1: Fundamentos de Spring</figcaption>
            </figure>

            <div class="block-quick-ref">
                <h4 class="block-quick-ref-title">
                    <span>⌨️</span> Quick-Reference: Fundamentos & Tooling
                </h4>
                <div class="quick-ref-grid">
                    <div class="quick-ref-col">
                        <strong>Maven Lifecycle</strong>
                        <ul class="quick-ref-list">
                            <li><code class="kw">mvn clean</code> <span class="quick-ref-comment">(Borra la carpeta target)</span></li>
                            <li><code class="kw">mvn compile</code> <span class="quick-ref-comment">(Compila el código fuente)</span></li>
                            <li><code class="kw">mvn test</code> <span class="quick-ref-comment">(Ejecuta las pruebas unitarias)</span></li>
                            <li><code class="kw">mvn package</code> <span class="quick-ref-comment">(Genera el archivo .jar)</span></li>
                        </ul>
                    </div>
                    <div class="quick-ref-col">
                        <strong>Lombok Annotations</strong>
                        <ul class="quick-ref-list">
                            <li><code class="kw">@Data</code> <span class="quick-ref-comment">(Getter, Setter, equals, hash, toString)</span></li>
                            <li><code class="kw">@Builder</code> <span class="quick-ref-comment">(Patrón Builder fluido)</span></li>
                            <li><code class="kw">@AllArgsConstructor</code> <span class="quick-ref-comment">(Constructor con todos los campos)</span></li>
                            <li><code class="kw">@Slf4j</code> <span class="quick-ref-comment">(Inyecta logger de Logback)</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-concepts-box">
          <h4>📦 Conceptos Clave del Bloque 1 — Fundamentos</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Arquitectura Web (MPA vs SPA)</strong></td>
                <td>
                  <strong>MPA (Multi-Page Application)</strong>: El servidor genera el HTML completo para cada página solicitada. Cada clic en un enlace provoca una recarga total del navegador. Es el modelo nativo de SEO y la base de los motores de plantillas como Thymeleaf.<br>
                  <strong>SPA (Single Page Application)</strong>: El servidor entrega un único archivo HTML vacío y un paquete de JavaScript (React, Angular, Vue). El JS toma el control del DOM y solicita datos en formato JSON a una API REST. Solo se actualizan las partes necesarias de la pantalla sin recargar la página.<br>
                  <em>Ejemplo en BiblioTech</em>: El catálogo de libros puede ser una MPA (navegación tradicional) o una SPA que consume la API de libros.
                </td>
              </tr>
              <tr>
                <td><strong>Protocolo HTTP/HTTPS</strong></td>
                <td>
                  El lenguaje universal de la web basado en Verbos (<code>GET, POST, PUT, DELETE, PATCH</code>), Cabeceras (<code>Content-Type, Authorization</code>) y Códigos de Estado (<code>200, 201, 400, 404, 500</code>).<br>
                  <em>Ejemplo</em>: <code>GET /api/v1/libros/123</code> solicita la información de un libro específico.
                </td>
              </tr>
              <tr>
                <td><strong>Serialización JSON (Jackson)</strong></td>
                <td>
                  Proceso de convertir un objeto Java en una cadena de texto JSON (<strong>Serialización</strong>) y viceversa (<strong>Deserialización</strong>). Jackson es el motor estándar en Spring Boot que automatiza este proceso mediante el <code>ObjectMapper</code>.<br>
                  <em>Ejemplo en BiblioTech</em>: Convertir la entidad <code>Libro</code> en un JSON para enviarlo al frontend.
                </td>
              </tr>
              <tr>
                <td><strong>Apache Maven (pom.xml)</strong></td>
                <td>
                  Herramienta de gestión de proyectos que estandariza la estructura de carpetas y la resolución de dependencias transitivas. El <code>pom.xml</code> define las librerías, la versión de Java y los plugins de empaquetado.<br>
                  <em>Ejemplo</em>: Añadir <code>spring-boot-starter-web</code> para habilitar la creación de APIs REST.
                </td>
              </tr>
              <tr>
                <td><strong>Lombok (@Data, @Builder)</strong></td>
                <td>
                  Librería que genera código en tiempo de compilación para eliminar el "boilerplate" (getters, setters, constructores). El patrón <code>@Builder</code> permite la creación fluida de objetos complejos.<br>
                  <em>Ejemplo en BiblioTech</em>: Usar <code>@Getter</code> y <code>@Setter</code> en la clase <code>Libro</code> para evitar escribir 50 líneas de código repetitivo.
                </td>
              </tr>
              <tr>
                <td><strong>Inversión de Control (IoC)</strong></td>
                <td>
                  Principio donde el control de la creación y gestión de los objetos (Beans) se delega a un contenedor externo (<code>ApplicationContext</code>), eliminando el acoplamiento fuerte provocado por el operador <code>new</code>.<br>
                  <em>Ejemplo en BiblioTech</em>: <code>PrestamoLibroService</code> no crea su propio <code>NotificacionService</code>, sino que lo recibe inyectado en el constructor.
                </td>
              </tr>
              <tr>
                <td><strong>Spring AOP (Aspectos)</strong></td>
                <td>
                  Programación Orientada a Aspectos para separar la lógica de negocio de preocupaciones transversales (logging, seguridad, transaccionalidad) mediante interceptores (Proxies).<br>
                  <em>Ejemplo en BiblioTech</em>: Un aspecto que mide el tiempo de ejecución de todos los métodos de servicio del catálogo sin modificar el código de esos métodos.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div> <!-- Fin de content-main -->
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
