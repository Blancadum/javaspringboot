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

<article id="tema-12">
          <h3>12 — Logging, Perfiles y Documentación OpenAPI</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">12. Logs, Actuator & RestClient</div>
            <a href="#tema-12-logs" class="topic-dropdown-item"><span class="item-num">12.1</span> <span class="item-title">Jerarquía de Logs y Uso de @Slf4j</span></a>
            <a href="#tema-12-perfiles-openapi" class="topic-dropdown-item"><span class="item-num">12.2</span> <span class="item-title">Perfiles de Configuración y Documentación con Swagger</span></a>
            <a href="#tema-12-actuator" class="topic-dropdown-item"><span class="item-num">12.3</span> <span class="item-title">Monitoreo y Observabilidad con Spring Boot Actuator</span></a>
            <a href="#tema-12-restclient" class="topic-dropdown-item"><span class="item-num">12.4</span> <span class="item-title">Consumo de Servicios Web Externos con RestClient</span></a>
            <a href="#tema-12-capacidades-especificas" class="topic-dropdown-item"><span class="item-num">12.5</span> <span class="item-title">Capacidades Específicas: Configuración y Eventos</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Operar una aplicación en producción exige trazabilidad, documentación interactiva y monitorización continua. Este tema cubre la jerarquía de logs con SLF4J, perfiles de entorno (<code class="kw">dev</code>, <code class="kw">prod</code>), documentación OpenAPI con Swagger, métricas y salud del sistema con Spring Boot Actuator, y el consumo de APIs REST externas mediante <code class="kw">RestClient</code>.
          </p>

          <div class="tip-box" style="background: var(--color-canvas-subtle); border-left: 4px solid var(--color-primer-border-active); padding: 16px 20px; margin: 20px 0; border-radius: 6px;">
            <h5 style="margin-top: 0; margin-bottom: 8px; font-size: 15px; color: var(--color-fg-default); display: flex; align-items: center; gap: 8px;">
              <span>💡</span> <strong>Intuición para Principiantes: Logs, Perfiles y Actuator (La caja negra y el cuadro de mandos del avión)</strong>
            </h5>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              Cuando estás aprendiendo, lo normal para ver qué pasa en tu programa es escribir <code class="kw">System.out.println("Llegó aquí")</code>. En un entorno profesional como <strong>BiblioTech</strong>, esto es una mala práctica crítica por tres razones:
            </p>
            <ul style="margin-bottom: 12px; font-size: 13.5px; line-height: 1.6; padding-left: 20px;">
              <li><strong>Frena el servidor</strong>: <code class="kw">System.out.println</code> es síncrono y bloquea el hilo de ejecución hasta que la terminal del sistema operativo termina de pintar la letra. Con miles de usuarios concurrentes, colapsaría la CPU.</li>
              <li><strong>No se puede apagar ni filtrar</strong>: En producción no quieres ver millones de mensajes irrelevantes, pero tampoco quieres borrar el código de prueba a mano.</li>
              <li><strong>Falta de contexto</strong>: No incluye marca de tiempo (<em>timestamp</em>), ni el hilo (<em>thread</em>), ni el nivel de gravedad.</li>
            </ul>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              <strong>La escala de severidad de SLF4J:</strong><br>
              &bull; <code class="kw">ERROR</code>: Algo ha fallado gravemente (la base de datos se cayó). Alerta a los ingenieros de guardia.<br>
              &bull; <code class="kw">WARN</code>: Situación sospechosa o no deseada, pero el servidor sigue funcionando (un usuario con multas intenta pedir un libro).<br>
              &bull; <code class="kw">INFO</code>: Hitos clave del negocio (<em>"Servidor arrancado en puerto 8080"</em>, <em>"Libro #12 prestado con éxito"</em>).<br>
              &bull; <code class="kw">DEBUG</code>: Detalles técnicos para depurar en local (<em>"Calculando penalización por 3 días de demora"</em>). En producción se apagan con una sola línea en <code class="kw">application.properties</code> sin tocar el código.<br>
              &bull; <code class="kw">TRACE</code>: Micro-detalles forenses (ej. valores exactos de los parámetros en cada consulta SQL).
            </p>
            <p style="margin-bottom: 0; font-size: 13.5px; line-height: 1.6;">
              <strong>¿Y los Perfiles y Actuator?</strong><br>
              &bull; <strong>Perfiles (<code class="kw">dev</code> vs <code class="kw">prod</code>)</strong>: El mismo código se viste según la ocasión. En <code class="kw">dev</code> arranca en 1 segundo con base de datos H2 volátil en RAM. En <code class="kw">prod</code> la conexión se realiza a PostgreSQL en la nube.<br>
              &bull; <strong>Actuator</strong>: Son los sensores médicos del servidor. Kubernetes consulta <code class="kw">/actuator/health</code> para saber si el contenedor sigue con vida o si debe reiniciar la máquina.
            </p>
          </div>

          <h4 id="tema-12-logs">12.1 Jerarquía de Logs y Uso de @Slf4j</h4>
          <p>
            Niveles de Log estándar: <code class="kw">TRACE &lt; DEBUG &lt; INFO &lt; WARN &lt; ERROR</code>. Se recomienda Lombok <code class="kw">@Slf4j</code> y parámetros estructurados con llaves <code class="kw">{}</code> para evitar concatenaciones innecesarias de cadenas en la plataforma BiblioTech:
          </p>
          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.service;

<span class="kw">import</span> lombok.extern.slf4j.<span class="typ">Slf4j</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;

<span class="ann">@Slf4j</span>
<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">PrestamoLibroService</span> {

    <span class="kw">public void</span> <span class="fn">procesarPrestamo</span>(<span class="typ">Long</span> libroId, <span class="typ">Long</span> usuarioId) {
        log.<span class="fn">debug</span>(<span class="str">"Iniciando verificación de disponibilidad: libroId={}, usuarioId={}"</span>, libroId, usuarioId);

        <span class="kw">if</span> (<span class="fn">tieneSancionesPendientes</span>(usuarioId)) {
            log.<span class="fn">warn</span>(<span class="str">"Usuario sancionado intenta solicitar libro: usuarioId={}, libroId={}"</span>, usuarioId, libroId);
        }
        <span class="cmt">// log.info("Pago procesado con éxito id={}", id);</span>

        <span class="cmt">// Lógica del préstamo en el catálogo BiblioTech...</span>
        log.<span class="fn">info</span>(<span class="str">"Préstamo registrado exitosamente en BiblioTech: libroId={}, usuarioId={}"</span>, libroId, usuarioId);
    }

    <span class="kw">private boolean</span> <span class="fn">tieneSancionesPendientes</span>(<span class="typ">Long</span> usuarioId) {
        <span class="kw">return false</span>;
    }
}</code></pre>
          </code-block>

          <h4 id="tema-12-perfiles-openapi">12.2 Perfiles de Configuración y Documentación con Swagger</h4>
          <p>
            Permite alternar propiedades por entorno (dev, test, prod) con <code class="kw">spring.profiles.active</code> y exponer automáticamente la documentación interactiva OpenAPI de BiblioTech en <code class="kw">/swagger-ui/index.html</code>.
          </p>
          <h4 id="tema-12-actuator">12.3 Monitoreo y Observabilidad con Spring Boot Actuator</h4>
          <p>
            El módulo <code class="kw">spring-boot-starter-actuator</code> expone endpoints HTTP listos para producción para auditar la salud, métricas de rendimiento y estado del servicio:
          </p>
          <ul>
            <li><code class="kw">/actuator/health</code>: Estado general del sistema (<code class="kw">UP</code>, <code class="kw">DOWN</code>). Verifica la conectividad con la base de datos de BiblioTech, espacio libre en disco y servicios externos.</li>
            <li><code class="kw">/actuator/metrics</code>: Métricas detalladas de la JVM (uso de heap memory, hilos activos, Garbage Collector) y rendimiento HTTP (<code class="kw">http.server.requests</code>).</li>
            <li><code class="kw">/actuator/info</code>: Metadatos de compilación (versión git, build timestamp y descripción del artefacto).</li>
            <li><code class="kw">/actuator/prometheus</code>: Formato scrapeable por Prometheus para integración con dashboards en Grafana.</li>
          </ul>

          <code-block lang="yaml">
<pre><code><span class="cmt"># application.yml: Exposición controlada de endpoints de telemetría</span>
<span class="kw">management</span>:
  <span class="kw">endpoints</span>:
    <span class="kw">web</span>:
      <span class="kw">exposure</span>:
        <span class="kw">include</span>: <span class="str">"health,info,metrics,prometheus"</span>
  <span class="kw">endpoint</span>:
    <span class="kw">health</span>:
      <span class="kw">show-details</span>: <span class="str">always</span></code></pre>
          </code-block>

          <h4 id="tema-12-restclient">12.4 Consumo de Servicios Web Externos con RestClient (Spring Boot 3)</h4>
          <p>
            A partir de Spring Boot 3 y Spring Framework 6, <code class="kw">RestClient</code> es el cliente HTTP síncrono moderno que reemplaza al clásico <code class="kw">RestTemplate</code>, ofreciendo una API fluida y gestión declarativa de errores. En BiblioTech se utiliza para consultar metadatos bibliográficos en la API pública de OpenLibrary:
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.client;

<span class="kw">import</span> org.springframework.http.HttpStatusCode;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> org.springframework.web.client.<span class="typ">RestClient</span>;
<span class="kw">import</span> org.springframework.http.<span class="typ">HttpStatusCode</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> org.springframework.web.client.<span class="typ">RestClient</span>;

<span class="cmt">// DTO inmutable con los metadatos devueltos por el proveedor externo</span>
<span class="kw">public record</span> <span class="typ">MetadatosLibroDTO</span>(<span class="typ">String</span> isbn, <span class="typ">String</span> title, <span class="typ">int</span> numberOfPages, <span class="typ">String</span> publishDate) {}

<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">OpenLibraryClient</span> {

    <span class="kw">private final</span> <span class="typ">RestClient</span> restClient;

    <span class="kw">public</span> <span class="fn">OpenLibraryClient</span>(<span class="typ">RestClient</span>.<span class="typ">Builder</span> builder) {
        <span class="kw">this</span>.restClient = builder
            .<span class="fn">baseUrl</span>(<span class="str">"https://openlibrary.org/api"</span>)
            .<span class="fn">defaultHeader</span>(<span class="str">"Accept"</span>, <span class="str">"application/json"</span>)
            .<span class="fn">build</span>();
    }

    <span class="kw">public</span> <span class="typ">MetadatosLibroDTO</span> <span class="fn">consultarPorIsbn</span>(<span class="typ">String</span> isbn) {
        <span class="kw">return</span> restClient.<span class="fn">get</span>()
            .<span class="fn">uri</span>(<span class="str">"/books?bibkeys=ISBN:{isbn}&format=json&jscmd=data"</span>, isbn)
            .<span class="fn">retrieve</span>()
            .<span class="fn">onStatus</span>(<span class="typ">HttpStatusCode</span>::is4xxClientError, (req, res) -&gt; {
                <span class="kw">throw new</span> <span class="typ">LibroExternoNoEncontradoException</span>(<span class="str">"ISBN no registrado en OpenLibrary: "</span> + isbn);
            })
            .<span class="fn">onStatus</span>(<span class="typ">HttpStatusCode</span>::is5xxServerError, (req, res) -&gt; {
                <span class="kw">throw new</span> <span class="typ">ServicioExternoCaidoException</span>(<span class="str">"El servicio de OpenLibrary se encuentra temporalmente caído."</span>);
            })
            .<span class="fn">body</span>(<span class="typ">MetadatosLibroDTO</span>.<span class="kw">class</span>);
    }
}</code></pre>
          </code-block>

          <h4 id="tema-12-capacidades-especificas">12.5 Capacidades Específicas del Ecosistema Spring: Externalización (@Value, @ConfigurationProperties) y Eventos Desacoplados</h4>
          <p>
            Spring Boot proporciona capacidadesLíneas 3451-3779 de index.html</p>
          </p>
          <p>
            <strong>1. Inyección y Externalización de Propiedades: <code class="kw">@Value</code> vs <code class="kw">@ConfigurationProperties</code></strong>
          </p>
          <ul>
            <li>
              <strong>Anotación <code class="kw">@Value</code></strong>: Adecuada para inyecciones puntuales de propiedades simples o expresiones SpEL (<em>Spring Expression Language</em>):
              <pre><code class="kw">@Value("${bibliotech.prestamo.dias-maximos:14}")
private int diasMaximosPrestamo;</code></pre>
            </li>
            <li>
              <strong>Anotación <code class="kw">@ConfigurationProperties</code></strong>: El estándar recomendado para configuraciones jerárquicas y estructuradas. Proporciona seguridad de tipos en tiempo de compilación (<em>type-safety</em>), autocompletado en el IDE y soporte nativo de Bean Validation (<code class="kw">@Validated</code>):
            </li>
          </ul>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.config;

<span class="kw">import</span> jakarta.validation.constraints.<span class="typ">Min</span>;
<span class="kw">import</span> jakarta.validation.constraints.<span class="typ">NotBlank</span>;
<span class="kw">import</span> lombok.<span class="typ">Getter</span>;
<span class="kw">import</span> lombok.<span class="typ">Setter</span>;
<span class="kw">import</span> org.springframework.boot.context.properties.<span class="typ">ConfigurationProperties</span>;
<span class="kw">import</span> org.springframework.context.annotation.<span class="typ">Configuration</span>;
<span class="kw">import</span> org.springframework.validation.annotation.<span class="typ">Validated</span>;

<span class="ann">@Configuration</span>
<span class="ann">@ConfigurationProperties</span>(prefix = <span class="str">"bibliotech.politicas"</span>)
<span class="ann">@Validated</span>
<span class="ann">@Getter</span>
<span class="ann">@Setter</span>
<span class="kw">public class</span> <span class="typ">BiblioTechProperties</span> {

    <span class="ann">@Min</span>(value = 1, message = <span class="str">"El límite de días debe ser al menos 1"</span>)
    <span class="kw">private int</span> diasPrestamoPorDefecto = 14;

    <span class="ann">@Min</span>(value = 1, message = <span class="str">"Un usuario debe poder solicitar al menos 1 libro"</span>)
    <span class="kw">private int</span> maxLibrosSimultaneos = 5;

    <span class="ann">@NotBlank</span>
    <span class="kw">private String</span> emailNotificaciones = <span class="str">"prestamos@bibliotech.com"</span>;
}</code></pre>
          </code-block>

          <p><strong>2. Mecanismo de Eventos de Aplicación (Application Events)</strong></p>
          <p>
            El patrón Publisher-Subscriber desacopla componentes que deben reaccionar ante cambios de estado de negocio sin mantener referencias directas entre sí. Cuando se confirma un préstamo, el servicio de préstamos no conoce ni invoca al servicio de correos ni al de analítica; simplemente emite un evento inmutable en el <code class="kw">ApplicationContext</code>:
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.event;

<span class="kw">import</span> java.time.<span class="typ">LocalDateTime</span>;

<span class="cmt">// 1. El Evento de Dominio inmutable modelado con un Record Java</span>
<span class="kw">public record</span> <span class="typ">LibroPrestadoEvent</span>(<span class="typ">Long</span> libroId, <span class="typ">Long</span> usuarioId, <span class="typ">LocalDateTime</span> fecha) {}</code></pre>
          </code-block>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.service;

<span class="kw">import</span> com.bibliotech.event.<span class="typ">LibroPrestadoEvent</span>;
<span class="kw">import</span> lombok.extern.slf4j.<span class="typ">Slf4j</span>;
<span class="kw">import</span> org.springframework.context.<span class="typ">ApplicationEventPublisher</span>;
<span class="kw">import</span> org.springframework.context.event.<span class="typ">EventListener</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> java.time.<span class="typ">LocalDateTime</span>;

<span class="cmt">// 2. El Publicador: Emite el evento sin acoplarse a los receptores</span>
<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">PrestamoService</span> {

    <span class="kw">private final</span> <span class="typ">ApplicationEventPublisher</span> eventPublisher;

    <span class="kw">public</span> <span class="fn">PrestamoService</span>(<span class="typ">ApplicationEventPublisher</span> eventPublisher) {
        <span class="kw">this</span>.eventPublisher = eventPublisher;
    }

    <span class="kw">public void</span> <span class="fn">confirmarPrestamo</span>(<span class="typ">Long</span> libroId, <span class="typ">Long</span> usuarioId) {
        <span class="cmt">// Lógica de persistencia del préstamo en base de datos...</span>

        <span class="cmt">// Publicación del evento en el bus de Spring Boot:</span>
        eventPublisher.<span class="fn">publishEvent</span>(<span class="kw">new</span> <span class="typ">LibroPrestadoEvent</span>(libroId, usuarioId, <span class="typ">LocalDateTime</span>.<span class="fn">now</span>()));
    }
}

<span class="cmt">// 3. El Suscriptor: Escucha reactivamente el evento para enviar el email</span>
<span class="ann">@Slf4j</span>
<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">NotificacionEmailListener</span> {

    <span class="ann">@EventListener</span>
    <span class="kw">public void</span> <span class="fn">onLibroPrestado</span>(<span class="typ">LibroPrestadoEvent</span> event) {
        log.<span class="fn">info</span>(<span class="str">"Enviando correo al usuario {} por el préstamo del libro {}"</span>,
            event.<span class="fn">usuarioId</span>(), event.<span class="fn">libroId</span>());
    }
}</code></pre>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
