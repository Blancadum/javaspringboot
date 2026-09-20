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

<article id="tema-18">
  <h3>18 — Testing de Integración Real con Testcontainers y WireMock</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">18. Testcontainers & WireMock</div>
      <a href="#tema-18-testcontainers" class="topic-dropdown-item"><span class="item-num">18.1</span> <span class="item-title">Testing de Integración con Bases de Datos Reales via Testcontainers</span></a>
      <a href="#tema-18-dynamic-properties" class="topic-dropdown-item"><span class="item-num">18.2</span> <span class="item-title">Inyección Dinámica de Propiedades con @DynamicPropertySource</span></a>
      <a href="#tema-18-wiremock" class="topic-dropdown-item"><span class="item-num">18.3</span> <span class="item-title">Mocheo de APIs HTTP Externas mediante WireMock</span></a>
      <a href="#tema-18-full-integration" class="topic-dropdown-item"><span class="item-num">18.4</span> <span class="item-title">Suite Completa de Pruebas de Integración E2E</span></a>
    </div>
  </details>

  <p class="topic-intro">
    Las bases de datos en memoria (H2) a menudo difieren en comportamiento, sintaxis dialectal y funciones nativas respecto a los motores de producción (PostgreSQL, MySQL). <strong>Testcontainers</strong> resuelve este problema ejecutando contenedores Docker efímeros durante la suite de pruebas. Por su parte, <strong>WireMock</strong> permite simular respuestas HTTP de APIs de terceros sin depender de conexiones reales.
  </p>

  <h4 id="tema-18-analogia">18.0 Intuición de la Vida Real: El Simulador de Vuelo y el Doble de Acción</h4>
  <github-alert type="note" title="💡 Modelo Mental: Testcontainers y WireMock en la vida real">
    <p>
      Imagina cómo se prepara a un piloto o se rueda una película de acción:
    </p>
    <ul>
      <li><strong>El Simulador de Vuelo de Alta Fidelidad (Testcontainers)</strong>: Probar una base de datos en memoria tipo H2 es como practicar vuelo dibujando un avión en un papel. Probar con **Testcontainers** es meter al piloto en una cabina hidráulica idéntica a la real (un contenedor Docker real de PostgreSQL o Kafka), donde los controles, los fallos y los dialectos SQL se comportan exactamente igual que en el avión de pasajeros en producción.</li>
      <li><strong>El Actor Doble de Riesgo (WireMock)</strong>: Cuando tu aplicación necesita consultar la API bancaria de Stripe o PayPal para cobrar una suscripción, no quieres gastar dinero real ni depender de si el servidor del banco cae durante el test. **WireMock** actúa como un actor doble que se pone la máscara del banco, recibe la petición HTTP de prueba y responde exactamente: <code>{"status": "PAID", "txId": "ST_999"}</code> en 2 milisegundos.</li>
    </ul>
  </github-alert>

  <h4 id="tema-18-testcontainers">18.1 Testing de Integración con Bases de Datos Reales via Testcontainers</h4>
  <p>
    Testcontainers gestiona automáticamente el ciclo de vida del contenedor Docker (inicio, espera de readiness y destrucción al finalizar la ejecución del test).
  </p>

  <h4 id="tema-18-dynamic-properties">18.2 Inyección Dinámica de Propiedades con @DynamicPropertySource</h4>
  <p>
    Dado que Docker asigna un puerto aleatorio libre en el host para evitar colisiones, Spring Boot 3 permite sobreescribir la URL de conexión JDBC mediante <code>@DynamicPropertySource</code>.
  </p>

  <div class="code-block-header">Ejemplo: Pruebas con PostgreSQL Container</div>
  <pre><code class="language-java">@SpringBootTest(webEnvironment = SpringBootTest.WebEnvironment.RANDOM_PORT)
@Testcontainers
class ProductoRepositoryIntegrationTest {

    @Container
    static PostgreSQLContainer&lt;?&gt; postgres = new PostgreSQLContainer&lt;&gt;("postgres:15-alpine")
            .withDatabaseName("testdb")
            .withUsername("test")
            .withPassword("test");

    @DynamicPropertySource
    static void configureProperties(DynamicPropertyRegistry registry) {
        registry.add("spring.datasource.url", postgres::getJdbcUrl);
        registry.add("spring.datasource.username", postgres::getUsername);
        registry.add("spring.datasource.password", postgres::getPassword);
    }

    @Autowired
    private ProductoRepository productoRepository;

    @Test
    void debeGuardarYRecuperarProductoEnPostgresReal() {
        Producto producto = new Producto(null, "Laptop Pro", new BigDecimal("1299.99"));
        Producto guardado = productoRepository.save(producto);

        assertThat(guardado.getId()).isNotNull();
        assertThat(productoRepository.findById(guardado.getId())).isPresent();
    }
}</code></pre>

  <h4 id="tema-18-wiremock">18.3 Mocheo de APIs HTTP Externas mediante WireMock</h4>
  <p>
    WireMock levanta un servidor HTTP ficticio que intercepta y valida peticiones salientes simulando escenarios de éxito, latencia o errores 500 del proveedor.
  </p>

  <pre><code class="language-java">@SpringBootTest
@WireMockTest(httpPort = 8089)
class ClienteHttpExternoTest {

    @Autowired
    private TarifaClient tarifaClient;

    @Test
    void debeObtenerTarifaDesdeApiExternaMocheada() {
        // Configuración de la respuesta simulada en WireMock
        stubFor(get(urlEqualTo("/api/v1/tarifas/EUR"))
            .willReturn(aResponse()
                .withStatus(200)
                .withHeader("Content-Type", "application/json")
                .withBody("{\"moneda\":\"EUR\", \"factor\": 1.08}")));

        BigDecimal factor = tarifaClient.obtenerFactor("EUR");
        assertThat(factor).isEqualByComparingTo("1.08");
    }
}</code></pre>

  <h4 id="tema-18-full-integration">18.4 Suite Completa de Pruebas de Integración E2E</h4>
  <p>
    Combinando Testcontainers y WireMock en una clase base compartida (AbstractIntegrationTest), garantizas que todos los tests de integración se ejecuten contra un entorno idéntico al de producción minimizando el tiempo de arranque.
  </p>

  <github-alert type="tip" title="Testcontainers Reusable Containers">
    <p>
      Para acelerar la ejecución local durante el desarrollo TDD, activa la opción <code>withReuse(true)</code> en tus contenedores de Testcontainers junto con <code>testcontainers.reuse.enable=true</code> en tu archivo <code>~/.testcontainers.properties</code> para evitar destruir el contenedor entre ejecuciones individuales.
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>

