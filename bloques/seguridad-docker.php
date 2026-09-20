<?php
  $in_bloque_context = true;
  include_once __DIR__ . "/../components/header.php";
  include_once __DIR__ . "/../components/sidebar.php";
?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- BLOQUE 6: SEGURIDAD Y DESPLIEGUE -->
          <section id="fase-6" class="study-section">
            <h2>Bloque 6: Seguridad y Despliegue</h2>

        <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
        <div class="block-intro-layout">
          <div class="block-summary-side">
            <div class="block-summary-card">
                <h4 style="margin-top: 0; color: var(--color-accent);">🚀 Visión General del Bloque</h4>
                <p class="text-small-muted">
                    El Bloque 6 representa la <strong>etapa final del ciclo de vida de desarrollo</strong>. Una aplicación no está terminada hasta que es segura y desplegable.
                    <br><br>
                    Primero, blindaremos <strong>BiblioTech</strong> implementando una arquitectura de seguridad <em>stateless</em> mediante <strong>JWT</strong> y <strong>Spring Security</strong>, eliminando la dependencia de sesiones en servidor para permitir el escalado horizontal.
                    <br><br>
                    Segundo, transformaremos la aplicación en una unidad portable mediante la <strong>contenedorización con Docker</strong>, utilizando técnicas de <em>multi-stage build</em> para reducir la superficie de ataque y el tamaño de la imagen.
                    <br><br>
                    Finalmente, daremos el salto hacia la arquitectura de <strong>Microservicios</strong>, explorando cómo la comunicación asíncrona con <strong>Apache Kafka</strong> permite que el sistema sea resiliente y desacoplado.
                </p>
            </div>
          </div>

          <div class="block-intro-main">
            <h3 style="margin-top: 0;">Objetivos de Aprendizaje — Bloque 6</h3>
            <div class="study-checks-grid">
                <study-check id="f6_t1">Entender la anatomía de un JWT (Header, Payload, Signature).</study-check>
                <study-check id="f6_t2">Configurar Spring Security en modo sin estado (SessionCreationPolicy.STATELESS).</study-check>
                <study-check id="f6_t3">Escribir un Dockerfile multi-stage build optimizado para Spring Boot.</study-check>
                <study-check id="f6_t4">Orquestar app + PostgreSQL con docker-compose.yml.</study-check>
                <study-check id="f6_t5">Comprender la comunicación asíncrona basada en eventos con Kafka.</study-check>
            </div>

            <!-- FLUJO DE PROGRESIÓN TÉCNICA -->
          </div>
        </div>

        <div class="block-flow-container">
            <div class="block-flow-item"><strong>1. Seguridad</strong><br>JWT & RBAC</div>
            <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
            <div class="block-flow-item"><strong>2. Empaquetado</strong><br>Docker Multi-stage</div>
            <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
            <div class="block-flow-item"><strong>3. Orquestación</strong><br>Docker Compose</div>
            <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
            <div class="block-flow-item"><strong>4. Escalabilidad</strong><br>Kafka Events</div>
        </div>

        <div class="block-topic-cluster">
          <div class="block-topic-cluster-header">
            <h3>Temas del bloque</h3>
          </div>
          <div class="block-topic-cluster-grid">
            <a class="block-topic-card" href="<?php echo $base_url; ?>seguridad-docker/jwt-docker"><span>20</span> JWT y Docker</a>
            <a class="block-topic-card" href="<?php echo $base_url; ?>seguridad-docker/oauth2-security"><span>21</span> OAuth2 & Security 6</a>
          </div>
        </div>

        <figure class="block-summary-figure">
          <img src="<?php echo $base_url; ?>img/FASE6.png" alt="Fase 6: Seguridad y Despliegue">
          <figcaption>Figura 7: Seguridad y Despliegue</figcaption>
        </figure>

        <!-- QUICK-REFERENCE CHEAT SHEET -->
        <div class="block-quick-ref">
            <h4 class="tip-box-title">
                <span>⌨️</span> Quick-Reference: Comandos de Despliegue
            </h4>
            <div class="quick-ref-grid">
                <div>
                    <strong style="color: var(--color-accent);">Docker & Containers</strong>
                    <ul class="quick-ref-list">
                        <li><code class="kw">docker build -t biblio-app .</code> <span class="quick-ref-comment">(Build imagen)</span></li>
                        <li><code class="kw">docker compose up -d</code> <span class="quick-ref-comment">(Lanzar stack)</span></li>
                        <li><code class="kw">docker compose logs -f</code> <span class="quick-ref-comment">(Ver logs vivo)</span></li>
                        <li><code class="kw">docker ps</code> <span class="quick-ref-comment">(Listar containers)</span></li>
                    </ul>
                </div>
                <div>
                    <strong style="color: var(--color-accent);">Spring & Environment</strong>
                    <ul class="quick-ref-list">
                        <li><code class="kw">mvn clean package -DskipTests</code> <span class="quick-ref-comment">(Jar optimizado)</span></li>
                        <li><code class="kw">java -jar app.jar --spring.profiles.active=prod</code> <span class="quick-ref-comment">(Run Prod)</span></li>
                        <li><code class="kw">mvn spring-boot:run</code> <span class="quick-ref-comment">(Run Local)</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- TABLA DE CONCEPTOS CLAVE DEL BLOQUE 6 -->
        <div class="block-concepts-box">
          <h4>🔒 Conceptos Clave del Bloque 6 — Seguridad y Despliegue</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Seguridad Stateless con JWT</strong></td>
                <td>
                  Autenticación sin estado mediante tokens compactos (RFC 7519) divididos en tres partes: <code class="kw">Header.Payload.Signature</code>. El servidor valida la firma criptográfica en milisegundos sin consultar sesiones en memoria ni en base de datos (<code class="kw">SessionCreationPolicy.STATELESS</code>).<br>
                  <em>Ejemplo</em>: El cliente envía <code class="kw">Authorization: Bearer eyJhbGci...</code>; el filtro de Spring Security extrae el usuario y sus roles del token y autentica el contexto.
                </td>
              </tr>
              <tr>
                <td><strong>Hashing Criptográfico con BCrypt</strong></td>
                <td>
                  Algoritmo adaptativo unidireccional para almacenamiento seguro de contraseñas. Incorpora una sal (*salt*) aleatoria para neutralizar tablas arcoíris y un factor de costo configurable contra ataques de fuerza bruta.<br>
                  <em>Ejemplo</em>: <code class="kw">passwordEncoder.encode("secreto123")</code> &rarr; genera <code class="kw">$2a$10$vI8a7...</code>. La validación se realiza mediante <code class="kw">passwordEncoder.matches(raw, hash)</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Control de Acceso Basado en Roles (RBAC)</strong></td>
                <td>
                  Autorización granular a nivel de método o endpoint basada en roles y autoridades (<code class="kw">@PreAuthorize</code>). Si el usuario autenticado carece del rol exigido, Spring Security deniega la ejecución con <code class="kw">HTTP 403 Forbidden</code>.<br>
                  <em>Ejemplo</em>: <code class="kw">@PreAuthorize("hasRole('ADMIN')") @DeleteMapping("/{id}") public ResponseEntity&lt;Void&gt; eliminar(...)</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Docker Multi-Stage Builds</strong></td>
                <td>
                  Técnica de empaquetado que separa el entorno de compilación (SDK completo con Maven) de la imagen final de ejecución (JRE mínimo en Alpine), reduciendo el tamaño del contenedor de ~800MB a &lt;150MB y mitigando vulnerabilidades del SO.<br>
                  <em>Ejemplo</em>: <code class="kw">FROM maven:3.9 AS build</code> &rarr; genera `.jar`; <code class="kw">FROM eclipse-temurin:21-jre-alpine</code> &rarr; copia solo el `.jar` con <code class="kw">COPY --from=build</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Orquestación con Docker Compose</strong></td>
                <td>
                  Herramienta para coordinar aplicaciones multicontenedor mediante el archivo declarativo <code class="kw">docker-compose.yml</code>, enlazando la aplicación Spring Boot con sus bases de datos (PostgreSQL), colas o cachés en una red interna privada.<br>
                  <em>Ejemplo</em>: <code class="kw">docker compose up -d</code> arranca simultáneamente la base de datos PostgreSQL en el puerto 5432 y el backend de Spring Boot conectado automáticamente.
                </td>
              </tr>
              <tr>
                <td><strong>Microservicios: Comunicación Síncrona vs Asíncrona</strong></td>
                <td>
                  <strong>Síncrona (REST)</strong>: petición-respuesta bloqueante con acoplamiento temporal (si el destinatario no responde, la petición falla).<br>
                  <strong>Asíncrona (Event-Driven con Kafka / RabbitMQ)</strong>: publicación de eventos desacoplada; los consumidores procesan los mensajes a su propio ritmo sin bloquear al emisor.<br>
                  <em>Ejemplo</em>: Tras cobrar un pedido, se emite un evento <code class="kw">PedidoCreadoEvent</code> en un tópico de Kafka para que Facturación y Notificaciones lo procesen en paralelo.
                  <em>Ejemplo en BiblioTech</em>: Tras formalizar un préstamo, se emite un evento <code class="kw">LibroPrestadoEvent</code> en el topic de Kafka <code class="kw">bibliotech-prestamos</code> para que los microservicios de Notificaciones y Analítica lo procesen en paralelo sin demorar la respuesta HTTP.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div> <!-- Fin de content-main -->
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
