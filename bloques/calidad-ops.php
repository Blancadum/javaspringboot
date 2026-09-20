<?php
  $in_bloque_context = true;
  include_once __DIR__ . "/../components/header.php";
  include_once __DIR__ . "/../components/sidebar.php";
?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- BLOQUE 4: CALIDAD, PERFILES Y OPERACIONES -->
          <section id="fase-4" class="study-section">
            <h2>Bloque 4: Calidad, Perfiles y Operaciones</h2>

            <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
            <div class="block-intro-layout">
              <div class="block-summary-side">
                <div class="block-summary-card" style="margin-top: 0; background: var(--color-canvas-default); border: 1px solid var(--color-border-muted); border-radius: 8px; padding: 20px;">
                    <h4 style="margin-top: 0; color: var(--color-accent);">🚀 Visión General del Bloque</h4>
                    <p style="font-size: 14px; line-height: 1.6; color: var(--color-fg-subtle);">
                        El Bloque 4 se centra en la <strong>calidad y la operabilidad</strong> del sistema. Una aplicación profesional no solo debe funcionar, sino que debe ser robusta ante datos incorrectos, fácil de monitorizar en producción y estar correctamente documentada.
                        <br><br>
                        Aprenderemos a blindar la API mediante <strong>validaciones estrictas</strong>, centralizar la gestión de errores para evitar fugas de información y utilizar <strong>perfiles de configuración</strong> para adaptar la aplicación a diferentes entornos (desarrollo vs producción). Finalmente, implementaremos la documentación interactiva con <strong>Swagger/OpenAPI</strong> y el monitoreo con <strong>Actuator</strong>.
                    </p>
                </div>
              </div>

              <div class="block-intro-main">
                <h3 style="margin-top: 0;">Objetivos de Aprendizaje — Bloque 4</h3>
                <div class="study-checks-grid">
                    <study-check id="f4_t1">Validar DTOs con Bean Validation (@NotNull, @NotBlank, @Size, @Email, @Valid).</study-check>
                    <study-check id="f4_t2">Crear un @RestControllerAdvice para capturar excepciones globalmente.</study-check>
                    <study-check id="f4_t3">Utilizar SLF4J con @Slf4j y evitar System.out.println en producción.</study-check>
                    <study-check id="f4_t4">Configurar perfiles de entorno (application-dev vs application-prod).</study-check>
                    <study-check id="f4_t5">Documentar la API con Springdoc OpenAPI y explorar Swagger UI.</study-check>
                </div>

              </div>
            </div>

            <!-- FLUJO DE PROGRESIÓN TÉCNICA -->
            <div class="block-flow-container" style="display: flex; align-items: center; justify-content: space-between; margin: 25px 0; padding: 15px; background: var(--color-canvas-subtle); border-radius: 10px; border: 1px dashed var(--color-border-muted); font-size: 13px; text-align: center;">
                <div style="flex: 1;"><strong>1. Blindaje</strong><br>Validación Bean</div>
                <div style="padding: 0 10px; color: var(--color-fg-subtle);">➔</div>
                <div style="flex: 1;"><strong>2. Control</strong><br>Errores Globales</div>
                <div style="padding: 0 10px; color: var(--color-fg-subtle);">➔</div>
                <div style="flex: 1;"><strong>3. Trazas</strong><br>SLF4J & Logs</div>
                <div style="padding: 0 10px; color: var(--color-fg-subtle);">➔</div>
                <div style="flex: 1;"><strong>4. Entornos</strong><br>Profiles & Ops</div>
            </div>

            <div class="block-topic-cluster">
              <div class="block-topic-cluster-header">
                <h3>Temas del bloque</h3>
              </div>
              <div class="block-topic-cluster-grid">
                <a class="block-topic-card" href="<?php echo $base_url; ?>calidad-ops/validaciones-errores"><span>11</span> Validaciones y errores</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>calidad-ops/logs-perfiles-swagger"><span>12</span> Logs, perfiles y Swagger</a>
              </div>
            </div>

            <figure class="block-summary-figure">
              <img src="../img/FASE4.png" alt="Fase 4: Calidad, Perfiles y Operaciones">
              <figcaption>Figura 5: Calidad, Perfiles y Operaciones</figcaption>
            </figure>

            <div class="block-quick-ref" style="margin: 30px 0; padding: 20px; background: var(--color-canvas-subtle); border-left: 5px solid var(--color-accent); border-radius: 0 8px 8px 0;">
                <h4 style="margin-top: 0; display: flex; align-items: center; gap: 10px; color: var(--color-fg-default);">
                    <span>⌨️</span> Quick-Reference: Calidad & Operaciones
                </h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-family: monospace; font-size: 12px; color: var(--color-fg-default);">
                    <div>
                        <strong style="color: var(--color-accent);">Bean Validation</strong>
                        <ul style="list-style: none; padding-left: 0; margin-top: 10px;">
                            <li><code class="kw">@NotNull / @NotBlank</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Evita nulos/vacíos)</span></li>
                            <li><code class="kw">@Size(min=x, max=y)</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Control de longitud)</span></li>
                            <li><code class="kw">@Positive / @Email</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Formato semántico)</span></li>
                            <li><code class="kw">@Valid</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Dispara la validación)</span></li>
                        </ul>
                    </div>
                    <div>
                        <strong style="color: var(--color-accent);">Ops & Monitoring</strong>
                        <ul style="list-style: none; padding-left: 0; margin-top: 10px;">
                            <li><code class="kw">log.info() / log.error()</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Trazas estructuradas)</span></li>
                            <li><code class="kw">spring.profiles.active</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Cambio de entorno)</span></li>
                            <li><code class="kw">/actuator/health</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Estado del sistema)</span></li>
                            <li><code class="kw">/swagger-ui.html</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Contrato de API)</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TABLA DE CONCEPTOS CLAVE DEL BLOQUE 4 -->
            <div class="block-concepts-box">
          <h4>🛡️ Conceptos Clave del Bloque 4 — Calidad, Perfiles y Operaciones</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Validaciones Declarativas (Bean Validation)</strong></td>
                <td>
                  Especificación de reglas de validación mediante metadatos en el DTO (<code class="kw">@NotNull</code>, <code class="kw">@NotBlank</code>, <code class="kw">@Size</code>, <code class="kw">@Positive</code>). Al anotar el payload en el controlador con <code class="kw">@Valid</code>, Spring ejecuta la inspección antes de entrar al servicio y devuelve <code class="kw">400 Bad Request</code> ante cualquier incumplimiento.<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">public record LibroRequestDTO(@NotBlank(message = "El ISBN es obligatorio") String isbn, @Positive(message = "El precio debe ser positivo") BigDecimal precio) {}</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Manejo Global de Excepciones (@RestControllerAdvice)</strong></td>
                <td>
                  Interceptor transversal que centraliza la captura de excepciones de negocio y validación para toda la API, convirtiéndolas en respuestas JSON normalizadas (estándar RFC 7807 <code class="kw">ProblemDetail</code>) en lugar de filtrar trazas de error internas.<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">@ExceptionHandler(LibroNotFoundException.class) public ResponseEntity&lt;ErrorResponse&gt; handleNotFound(...) { ... }</code> (retorna <code class="kw">404 Not Found</code> limpio con timestamp y ruta).
                </td>
              </tr>
              <tr>
                <td><strong>Observabilidad y Logging con SLF4J / Logback</strong></td>
                <td>
                  Sistema de trazas estructuradas con niveles de severidad (<code class="kw">TRACE</code>, <code class="kw">DEBUG</code>, <code class="kw">INFO</code>, <code class="kw">WARN</code>, <code class="kw">ERROR</code>). Emplea plantillas parametrizadas con llaves <code class="kw">{}</code> para evitar concatenaciones innecesarias de memoria.<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">log.info("Libro registrado con éxito en BiblioTech: id={}, isbn={}", libro.getId(), libro.getIsbn());</code> (nunca usar <code class="kw">System.out.println</code> en producción).
                </td>
              </tr>
              <tr>
                <td><strong>Perfiles de Configuración (application-{profile}.properties)</strong></td>
                <td>
                  Aislamiento estricto de configuraciones de infraestructura según el entorno (<code class="kw">dev</code>, <code class="kw">test</code>, <code class="kw">prod</code>), activable mediante <code class="kw">spring.profiles.active</code>.<br>
                  <em>Ejemplo en BiblioTech</em>: En <code class="kw">dev</code> se utiliza base de datos en memoria H2 con consola visual web; en <code class="kw">prod</code> se conecta a PostgreSQL gestionado en la nube con credenciales seguras por variables de entorno.
                </td>
              </tr>
              <tr>
                <td><strong>Documentación Interactiva OpenAPI / Swagger</strong></td>
                <td>
                  Generación automática de contratos de API REST (OpenAPI 3.0) y portal web interactivo Swagger UI mediante la dependencia <code class="kw">springdoc-openapi-starter-webmvc-ui</code>, permitiendo a clientes frontend probar la API en vivo.<br>
                  <em>Ejemplo en BiblioTech</em>: Navegar a <code class="kw">http://localhost:8080/swagger-ui.html</code> para inspeccionar el catálogo <code class="kw">/api/v1/libros</code>, probar payloads y validar esquemas de respuesta.
                </td>
              </tr>
              <tr>
                <td><strong>Monitoreo con Spring Boot Actuator</strong></td>
                <td>
                  Colección de endpoints HTTP listos para producción para telemetría operativa: estado de salud (<code class="kw">/actuator/health</code>), métricas de hardware/JVM (<code class="kw">/actuator/metrics</code>) y metadatos de compilación (<code class="kw">/actuator/info</code>).<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">GET /actuator/health</code> confirma si el pool de conexiones a la base de datos de libros está en estado <code class="kw">UP</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Consumo de APIs con RestClient</strong></td>
                <td>
                  Cliente HTTP síncrono moderno y fluido introducido en Spring Boot 3 para consultar microservicios o APIs de terceros de forma tipada, con soporte declarativo de cabeceras y manejo de errores HTTP.<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">restClient.get().uri("/books/{isbn}", isbn).retrieve().body(MetadatosLibroDTO.class);</code> (consulta a OpenLibrary para enriquecer la ficha del libro).
                </td>
              </tr>
              <tr>
                <td><strong>Capacidades Específicas (@ConfigurationProperties y Application Events)</strong></td>
                <td>
                  Mecanismos avanzados del contenedor Spring: <code class="kw">@ConfigurationProperties</code> para vincular propiedades tipadas e inmutables validadas con Bean Validation, y <code class="kw">ApplicationEventPublisher</code> / <code class="kw">@EventListener</code> para desacoplar flujos de negocio mediante eventos internos.<br>
                  <em>Ejemplo en BiblioTech</em>: Publicar un <code class="kw">LibroPrestadoEvent</code> al confirmar un préstamo para que el servicio de email notifique al usuario sin que el servicio de préstamos dependa directamente de él.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div> <!-- Fin de content-main -->
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
