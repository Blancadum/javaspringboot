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

<article id="tema-15">
  <h3>15 — Observabilidad con Actuator, Micrometer y Prometheus</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">15. Actuator & Observabilidad</div>
      <a href="#tema-15-actuator" class="topic-dropdown-item"><span class="item-num">15.1</span> <span class="item-title">Configuración de Spring Boot Actuator y Exposición de Endpoints</span></a>
      <a href="#tema-15-health" class="topic-dropdown-item"><span class="item-num">15.2</span> <span class="item-title">Indicadores de Salud Personalizados (HealthIndicator)</span></a>
      <a href="#tema-15-micrometer" class="topic-dropdown-item"><span class="item-num">15.3</span> <span class="item-title">Métricas de Negocio e Instrumentalización con Micrometer</span></a>
      <a href="#tema-15-prometheus" class="topic-dropdown-item"><span class="item-num">15.4</span> <span class="item-title">Exportación de Métricas a Prometheus y Visualización en Grafana</span></a>
    </div>
  </details>

  <p class="topic-intro">
    En entornos cloud-native y de microservicios, la observabilidad es imprescindible para conocer el estado interno de un sistema a partir de sus salidas. Spring Boot integra <strong>Actuator</strong> para la monitorización de salud e infraestructura, y <strong>Micrometer</strong> como la fachada universal de métricas.
  </p>

  <h4 id="tema-15-actuator">15.1 Configuración de Spring Boot Actuator y Exposición de Endpoints</h4>
  <p>
    Actuator añade endpoints HTTP y JMX orientados a la producción para auditar la aplicación (memoria JVM, estado de base de datos, beans configurados, propiedades cargadas).
  </p>

  <div class="code-block-header">Configuración en application.properties</div>
  <pre><code class="language-ini"># Exposición web de endpoints seleccionados por seguridad
management.endpoints.web.exposure.include=health,info,metrics,prometheus

# Mostrar detalles completos del estado de salud
management.endpoint.health.show-details=always

# Información personalizada de la aplicación
info.app.name=Handbook Spring Boot API
info.app.version=3.2.0
info.app.encoding=UTF-8</code></pre>

  <h4 id="tema-15-health">15.2 Indicadores de Salud Personalizados (HealthIndicator)</h4>
  <p>
    Puedes crear comprobaciones personalizadas implementando la interfaz <code>HealthIndicator</code> (o extendiendo <code>AbstractHealthIndicator</code>) para validar componentes críticos como servicios externos o colas de mensajes.
  </p>

  <pre><code class="language-java">@Component
@RequiredArgsConstructor
public class ExternalApiHealthIndicator implements HealthIndicator {

    private final RestTemplate restTemplate;

    @Override
    public Health health() {
        try {
            ResponseEntity&lt;String&gt; response = restTemplate.getForEntity("https://api.proveedor.com/ping", String.class);
            if (response.getStatusCode().is2xxSuccessful()) {
                return Health.up()
                    .withDetail("proveedorApi", "Disponible")
                    .withDetail("responseTimeMs", 45)
                    .build();
            }
            return Health.down()
                .withDetail("proveedorApi", "Código inesperado: " + response.getStatusCode())
                .build();
        } catch (Exception ex) {
            return Health.down(ex)
                .withDetail("proveedorApi", "Inalcanzable")
                .build();
        }
    }
}</code></pre>

  <h4 id="tema-15-micrometer">15.3 Métricas de Negocio e Instrumentalización con Micrometer</h4>
  <p>
    Micrometer proporciona primitivas de métricas universales (Counters, Gauges, Timers):
  </p>

  <pre><code class="language-java">@Service
public class PedidoService {

    private final Counter pedidosCreadosCounter;
    private final Timer tiempoProcesamientoTimer;

    public PedidoService(MeterRegistry registry) {
        // Contador incrementable
        this.pedidosCreadosCounter = Counter.builder("pedidos.creados.total")
            .description("Número total de pedidos tramitados")
            .tag("canal", "web")
            .register(registry);

        // Temporizador de ejecución
        this.tiempoProcesamientoTimer = Timer.builder("pedidos.procesamiento.tiempo")
            .description("Tiempo empleado en procesar pedidos")
            .register(registry);
    }

    public void procesarPedido(Pedido pedido) {
        tiempoProcesamientoTimer.record(() -&gt; {
            // Lógica de procesar pedido...
            pedidosCreadosCounter.increment();
        });
    }
}</code></pre>

  <h4 id="tema-15-prometheus">15.4 Exportación de Métricas a Prometheus y Visualización en Grafana</h4>
  <p>
    Al añadir la dependencia <code>micrometer-registry-prometheus</code>, Actuator expone automáticamente un endpoint en formato scrapable por Prometheus bajo <code>/actuator/prometheus</code>:
  </p>

  <pre><code class="language-xml">&lt;dependency&gt;
    &lt;groupId&gt;io.micrometer&lt;/groupId&gt;
    &lt;artifactId&gt;micrometer-registry-prometheus&lt;/artifactId&gt;
&lt;/dependency&gt;</code></pre>

  <pre><code class="language-yaml"># prometheus.yml
scrape_configs:
  - job_name: 'springboot-app'
    metrics_path: '/actuator/prometheus'
    scrape_interval: 5s
    static_configs:
      - targets: ['host.docker.internal:8080']</code></pre>

  <github-alert type="warning" title="Seguridad en endpoints de Actuator">
    <p>
      Nunca expongas <code>management.endpoints.web.exposure.include=*</code> en entornos de producción sin proteger la ruta <code>/actuator/**</code> mediante Spring Security. Endpoints como <code>env</code> o <code>heapdump</code> pueden exponer credenciales o secretos en memoria.
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>

