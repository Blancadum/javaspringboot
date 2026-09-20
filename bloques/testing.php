<?php
  $in_bloque_context = true;
  include_once __DIR__ . "/../components/header.php";
  include_once __DIR__ . "/../components/sidebar.php";
?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- BLOQUE 5: TESTING AUTOMATIZADO -->
      <section id="fase-5" class="study-section">
        <h2>Bloque 5: Testing Automatizado</h2>

                <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
        <div class="block-intro-layout">
          <div class="block-summary-side">
            <div class="block-summary-card">
              <h4 class="block-summary-title">🚀 Visión General del Bloque</h4>
              <p class="block-summary-text">
                En este bloque aprendemos a validar cada capa del sistema sin depender de pruebas manuales o de variaciones aleatorias del entorno.
                <br><br>
                Comenzamos con una estrategia sólida de pruebas unitarias y avanzamos hacia la verificación de controladores y flujos completos con Spring Boot Test, manteniendo la velocidad y la fiabilidad del proceso.
              </p>
            </div>
          </div>

          <div class="block-intro-main">
            <h3>Objetivos de Aprendizaje — Bloque 5</h3>
            <div class="study-checks-grid">
              <study-check id="f5_t1">Aplicar la Pirámide de Tests (muchos tests unitarios, menos de integración).</study-check>
              <study-check id="f5_t2">Crear pruebas unitarias con JUnit 5 y aislar con @Mock y @InjectMocks de Mockito.</study-check>
              <study-check id="f5_t3">Usar when().thenReturn() y verify() para verificar interacciones.</study-check>
              <study-check id="f5_t4">Escribir tests de integración web con @WebMvcTest y MockMvc.</study-check>
            </div>
          </div>
        </div>

        <div class="block-flow-container">
            <div class="block-flow-item"><strong>1. Pirámide</strong><br>Unitarios & Integración</div>
            <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
            <div class="block-flow-item"><strong>2. Aislamiento</strong><br>JUnit & Mockito</div>
            <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
            <div class="block-flow-item"><strong>3. Verificación</strong><br>when() & verify()</div>
            <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
            <div class="block-flow-item"><strong>4. Web</strong><br>MockMvc & Spring Test</div>
        </div>

        <div class="block-topic-cluster">
          <div class="block-topic-cluster-header">
            <h3>Temas del bloque</h3>
          </div>
          <div class="block-topic-cluster-grid">
            <a class="block-topic-card" href="<?php echo $base_url; ?>testing/junit5-mockito"><span>17</span> JUnit 5 y Mockito</a>
            <a class="block-topic-card" href="<?php echo $base_url; ?>testing/spring-boot-test"><span>18</span> Spring Boot Test</a>
            <a class="block-topic-card" href="<?php echo $base_url; ?>testing/testcontainers-wiremock"><span>19</span> Testcontainers & WireMock</a>
          </div>
        </div>

        <figure class="block-summary-figure">
          <img src="<?php echo $base_url; ?>img/FASE5.png" alt="Fase 5: Testing Automatizado">
          <figcaption>Figura 6: Contenido del Bloque 5 — Pruebas unitarias con JUnit y Mockito, e integración con Spring Boot Test.</figcaption>
        </figure>

        <!-- TABLA DE CONCEPTOS CLAVE DEL BLOQUE 5 -->
        <div class="block-concepts-box">
          <h4>🧪 Conceptos Clave del Bloque 5 — Testing Automatizado</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Pirámide de Testing</strong></td>
                <td>
                  Estrategia de distribución de pruebas: base masiva de <strong>tests unitarios</strong> rápidos y baratos; capa intermedia de <strong>tests de integración</strong> entre componentes/BD; y vértice reducido de <strong>tests E2E</strong> por su lentitud y fragilidad.<br>
                  <em>Ejemplo</em>: 70% unitarios (milisegundos con Mockito) | 20% integración (<code class="kw">@WebMvcTest</code>) | 10% integrales (<code class="kw">@SpringBootTest</code>).
                </td>
              </tr>
              <tr>
                <td><strong>Pruebas Unitarias con JUnit 5 y Mockito</strong></td>
                <td>
                  Validación aislada de una única clase en milisegundos sin levantar Spring. <code class="kw">@Mock</code> simula las dependencias externas y <code class="kw">@InjectMocks</code> las inyecta automáticamente en la clase a testear.<br>
                  <em>Ejemplo</em>: <code class="kw">@ExtendWith(MockitoExtension.class) class ServicioTest { @Mock Repo repo; @InjectMocks Servicio serv; }</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Stubbing y Verificación (when / verify)</strong></td>
                <td>
                  Control y comprobación de interacciones con dobles de prueba: <code class="kw">when(...).thenReturn(...)</code> programa el retorno simulado; <code class="kw">verify(mock, times(1)).metodo(...)</code> certifica que el colaborador fue invocado con los argumentos esperados.<br>
                  <em>Ejemplo</em>: <code class="kw">when(repo.findById(1L)).thenReturn(Optional.of(libro)); serv.borrar(1L); verify(repo).deleteById(1L);</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Pruebas de Integración Web (@WebMvcTest y MockMvc)</strong></td>
                <td>
                  Prueba focalizada (*Slice Test*) que levanta únicamente la capa web de Spring MVC sin base de datos. <code class="kw">MockMvc</code> simula peticiones HTTP de red y valida el JSON de respuesta con <code class="kw">jsonPath</code>.<br>
                  <em>Ejemplo</em>: <code class="kw">mockMvc.perform(get("/api/libros/1")).andExpect(status().isOk()).andExpect(jsonPath("$.titulo").value("Clean Code"));</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Pruebas Integrales (@SpringBootTest)</strong></td>
                <td>
                  Prueba que arranca el <code class="kw">ApplicationContext</code> completo con todos los beans y configuraciones de infraestructura, validando el flujo de extremo a extremo contra una base de datos de test (H2 o Testcontainers).<br>
                  <em>Ejemplo</em>: <code class="kw">@SpringBootTest @AutoConfigureMockMvc class PedidoIntegrationTest { @Autowired MockMvc mockMvc; }</code>.
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">@SpringBootTest @AutoConfigureMockMvc class LibroIntegrationTest { @Autowired MockMvc mockMvc; }</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Depuración y Diagnóstico Profesional</strong></td>
                <td>
                  Metodologías de resolución de defectos mediante el debugger del IDE: puntos de interrupción condicionales (<em>conditional breakpoints</em>), inspección de variables en la pila de llamadas y evaluación de expresiones en caliente.<br>
                  <em>Ejemplo</em>: Configurar condición <code class="kw">producto.getStock() &lt; 0</code> para detener la ejecución solo cuando se detecte una inconsistencia de stock.
                  <em>Ejemplo en BiblioTech</em>: Configurar condición <code class="kw">libro.getPrecio().compareTo(BigDecimal.ZERO) &lt; 0</code> para pausar el depurador solo si se procesa un libro con precio inconsistente.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div> <!-- Fin de content-main -->
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
