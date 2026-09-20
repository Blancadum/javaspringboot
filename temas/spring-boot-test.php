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

<article id="tema-14">
          <h3>14 — Pruebas Web con <code class="kw">@WebMvcTest</code> y <code class="kw">MockMvc</code></h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">14. Slice Testing Web</div>
            <a href="#tema-14-slice" class="topic-dropdown-item"><span class="item-num">14.1</span> <span class="item-title">Slice Testing Web con @WebMvcTest</span></a>
            <a href="#tema-14-mockmvc" class="topic-dropdown-item"><span class="item-num">14.2</span> <span class="item-title">Peticiones y Aserciones JSON con MockMvc</span></a>
            <a href="#tema-14-mockbean" class="topic-dropdown-item"><span class="item-num">14.3</span> <span class="item-title">Sustitución de Servicios con @MockBean</span></a>
            <a href="#tema-14-debugging" class="topic-dropdown-item"><span class="item-num">14.4</span> <span class="item-title">Técnicas Profesionales de Depuración (Debugging) y Diagnóstico</span></a>
          </div>
        </details>

          <p class="topic-intro">
            A diferencia de las pruebas unitarias puras, las pruebas de integración web validan la capa de transporte: enrutamiento de peticiones, serialización JSON, validaciones <code class="kw">@Valid</code> y códigos de estado. Aquí aprenderás a utilizar <code class="kw">@WebMvcTest</code> con <code class="kw">MockMvc</code> para simular peticiones HTTP en milisegundos, junto con técnicas profesionales de depuración y análisis de logs en Spring Boot.
          </p>

          <h4 id="tema-14-slice">14.1 Arquitectura de Pruebas con Spring Test: Tests Integrales vs Slice Tests (@WebMvcTest y @DataJpaTest)</h4>
          <p>
            El módulo <strong>Spring Test</strong> (incluido en <code class="kw">spring-boot-starter-test</code>) provee un marco exhaustivo para ejecutar pruebas automáticas con distintos niveles de granularidad:
          </p>
          <ul>
            <li>
              <strong>Tests Integrales de Extremo a Extremo con <code class="kw">@SpringBootTest</code></strong>: Arranca el <code class="kw">ApplicationContext</code> completo con todos los beans, datasources, filtros de seguridad y capas activas. Es la validación más cercana al comportamiento de producción, pero la más pesada y lenta de ejecutar en pipelines de CI/CD.
            </li>
            <li>
              <strong>Pruebas de Corte Web con <code class="kw">@WebMvcTest</code></strong>: Inicializa exclusivamente la capa web de Spring MVC (controladores <code class="kw">@RestController</code>, filtros, validadores Bean Validation y serializadores Jackson), ignorando los servicios y repositorios. Permite verificar en milisegundos que los endpoints respondan con los códigos de estado semánticos (200, 201, 400, 404), cabeceras y estructura JSON correctos.
            </li>
            <li>
              <strong>Pruebas de Persistencia con <code class="kw">@DataJpaTest</code></strong>: Inicializa exclusivamente el subsistema JPA (Hibernate, entidades, interfaces <code class="kw">JpaRepository</code> y <code class="kw">TestEntityManager</code>), configurando por defecto una base de datos en memoria (H2). Cada método de test es transaccional por defecto y ejecuta un <strong>rollback automático</strong> al concluir, garantizando aislamiento total entre pruebas.
            </li>
          </ul>

          <h4 id="tema-14-mockmvc">14.2 Peticiones y Aserciones JSON con MockMvc</h4>
          <p>
            Permite simular llamadas HTTP reales y validar códigos de estado y nodos JSON con <code class="kw">jsonPath</code>.
          </p>

          <h4 id="tema-14-mockbean">14.3 Sustitución de Servicios con @MockBean</h4>
          <p>
            Reemplaza el servicio real en el contexto de Spring MVC por un mock gestionado por Mockito.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.controller;

<span class="kw">import</span> com.bibliotech.service.<span class="typ">LibroService</span>;
<span class="kw">import</span> com.bibliotech.dto.<span class="typ">LibroResponseDTO</span>;
<span class="kw">import</span> org.junit.jupiter.api.<span class="typ">Test</span>;
<span class="kw">import</span> org.springframework.beans.factory.annotation.<span class="typ">Autowired</span>;
<span class="kw">import</span> org.springframework.boot.test.autoconfigure.web.servlet.<span class="typ">WebMvcTest</span>;
<span class="kw">import</span> org.springframework.boot.test.mock.mockito.<span class="typ">MockBean</span>;
<span class="kw">import</span> org.springframework.test.web.servlet.<span class="typ">MockMvc</span>;
<span class="kw">import</span> static org.springframework.test.web.servlet.request.<span class="typ">MockMvcRequestBuilders</span>.*;
<span class="kw">import</span> static org.springframework.test.web.servlet.result.<span class="typ">MockMvcResultMatchers</span>.*;
<span class="kw">import</span> static org.mockito.Mockito.<span class="fn">when</span>;

<span class="ann">@WebMvcTest</span>(<span class="typ">LibroController</span>.<span class="kw">class</span>)
<span class="kw">class</span> <span class="typ">LibroControllerTest</span> {

    <span class="ann">@Autowired</span>
    <span class="kw">private</span> <span class="typ">MockMvc</span> mockMvc;

    <span class="ann">@MockBean</span>
    <span class="kw">private</span> <span class="typ">LibroService</span> libroService;

    <span class="ann">@Test</span>
    <span class="kw">void</span> <span class="fn">debeRetornar200YJsonCorrecto</span>() {
        <span class="typ">LibroResponseDTO</span> dto = <span class="kw">new</span> <span class="typ">LibroResponseDTO</span>(42L, <span class="str">"Effective Java"</span>, <span class="kw">null</span>, <span class="str">"Joshua Bloch"</span>);
        <span class="fn">when</span>(libroService.<span class="fn">buscarPorId</span>(42L)).<span class="fn">thenReturn</span>(dto);

        mockMvc.<span class="fn">perform</span>(<span class="fn">get</span>(<span class="str">"/api/v1/libros/42"</span>))
            .<span class="fn">andExpect</span>(<span class="fn">status</span>().<span class="fn">isOk</span>())
            .<span class="fn">andExpect</span>(<span class="fn">jsonPath</span>(<span class="str">"$.id"</span>).<span class="fn">value</span>(42))
            .<span class="fn">andExpect</span>(<span class="fn">jsonPath</span>(<span class="str">"$.titulo"</span>).<span class="fn">value</span>(<span class="str">"Effective Java"</span>));
    }
}</code></pre>
          </code-block>
          <h4 id="tema-14-debugging">14.4 Técnicas Profesionales de Depuración (Debugging) y Diagnóstico</h4>
          <p>
            El diagnóstico y resolución de errores complejos en Spring Boot exige herramientas avanzadas de trazabilidad más allá del logging tradicional:
          </p>
          <ul>
            <li><strong>Inspección de SQL y Parámetros Bind en Hibernate</strong>:
              Para diagnosticar el problema N+1 y verificar las sentencias exactas y parámetros enviados:
              <pre><code>spring.jpa.show-sql=true
spring.jpa.properties.hibernate.format_sql=true
logging.level.org.hibernate.orm.jdbc.bind=TRACE</code></pre>
            </li>
            <li><strong>Diagnóstico de Fallos de Arranque (FailureAnalyzer)</strong>:
              Cuando la aplicación falla al iniciar por dependencias circulares o propiedades ausentes, ejecutar con la bandera <code class="kw">--debug</code> para activar el <code class="kw">ConditionEvaluationReport</code> y analizar los mensajes de <code class="kw">FailureAnalyzer</code> (bloque "APPLICATION FAILED TO START").
            </li>
            <li><strong>Breakpoints Condicionales en el IDE</strong>:
              Pausar el hilo de ejecución solo cuando se cumpla una condición booleana específica (ej. <code class="kw">monto &lt; 0 || id == 999L</code>), evitando detener el depurador en cientos de llamadas válidas concurrentes.
            </li>
            <li><strong>Evaluación de Expresiones al Vuelo</</strong>>
              Permite inspeccionar y alterar variables en memoria durante la pausa de ejecución sin reiniciar el servidor para validar hipótesis de corrección.
            </li>
          </ul>
        </article>
      </section>

      <hr>

      <!-- BLOQUE 6: SEGURIDAD Y DESPLIEGUE -->
      <section id="fase-6" class="study-section">
        <h2>Bloque 6: Seguridad y Despliegue</h2>

                <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
        <div class="block-intro-layout">
          <div class="block-summary-side">
            <div class="block-summary-card">
              <h4 class="block-summary-title">🚀 Visión General del Bloque</h4>
              <p class="block-summary-text">
                En este bloque cerramos la base del sistema con la parte más crítica para producción: seguridad, despliegue y escalabilidad.
                <br><br>
                Aprenderemos a proteger la API con JWT, a empaquetarla con Docker y a preparar la infraestructura para ejecutar la aplicación en entornos reales con fiabilidad.
              </p>
              <figure class="block-summary-figure">
                <img src="../img/FASE6.png" alt="Fase 6: Seguridad y Despliegue">
                <figcaption>Figura 7: Contenido del Bloque 6 — Autenticación y autorización mediante JWT y contenedorización de aplicaciones con Docker.</figcaption>
              </figure>
            </div>
          </div>

          <div class="block-intro-main">
            <h3>Objetivos de Aprendizaje — Bloque 6</h3>
            <div class="study-checks-grid">
              <study-check id="f6_t1">Entender la anatomía de un JWT (Header, Payload, Signature).</study-check>
              <study-check id="f6_t2">Configurar Spring Security en modo sin estado (SessionCreationPolicy.STATELESS).</study-check>
              <study-check id="f6_t3">Escribir un Dockerfile multi-stage build optimizado para Spring Boot.</study-check>
              <study-check id="f6_t4">Orquestar la infraestructura con Docker Compose (App + DB + Redis).</study-check>
              <study-check id="f6_t5">Comprender el flujo de eventos asíncronos con Kafka o RabbitMQ.</study-check>
            </div>
          </div>
        </div>

        <!-- TABLA DE CONCEPTOS CLAVE DEL BLOQUE 6 -->
        <div class="block-concepts-box">
          <h4>🔐 Conceptos Clave del Bloque 6 — Seguridad y Despliegue</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>JWT (JSON Web Token)</strong></strong>
                <td>
                  Estándar de transferencia de identidad stateless. El servidor no guarda sesiones en RAM, sino que firma un token con una clave secreta. El cliente lo envía en la cabecera <code class="kw">Authorization: Bearer &lt;token&gt;</code> en cada petición.<br>
                  <em>Ejemplo</em>: Un token JWT contiene el <code class="kw">sub</code> (usuario), <code class="kw">roles</span a la vez que garantiza que el contenido no ha sido alterado gracias a la firma digital.
                </td>
              </tr>
              <tr>
                <td><strong>Spring Security stateless</strong></td>
                <td>
                  Configuración que desactiva la creación de cookies de sesión (JSESSIONID) y obliga a validar el JWT en cada petición mediante un filtro de seguridad personalizado.
                </td>
              </tr>
              <tr>
                <td><strong>Docker Multi-stage Build</strong></td>
                <td>
                  Técnica para reducir el tamaño de la imagen final eliminando el Maven wrapper y el código fuente, dejando únicamente el archivo .jar ejecutable y la JRE mínima necesaria.
                </td>
              </tr>
              <tr>
                <td><strong>Orquestación con Docker Compose</strong></td>
                <td>
                  Definición de un grafo de servicios dependientes (App + DB + Cache) en un único archivo YAML, permitiendo levantar todo el entorno de desarrollo con un solo comando (<code class="kw">docker-compose up</s>).
                </td>
              </tr>
              <tr>
                <td><strong>Comunicación Asíncrona (Kafka / RabbitMQ)</strong></td>
                <td>
                  Modelo basado en eventos donde el productor no espera respuesta inmediata del consumidor, eliminando el acoplamiento temporal y aumentando la resiliencia del sistema.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
