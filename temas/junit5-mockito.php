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

<article id="tema-13">
          <h3>13 — Pruebas Unitarias Aisladas con Mockito</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">13. Unit Testing Mockito</div>
            <a href="#tema-13-aislamiento" class="topic-dropdown-item"><span class="item-num">13.1</span> <span class="item-title">Aislamiento con @Mock y @InjectMocks</span></a>
            <a href="#tema-13-when-verify" class="topic-dropdown-item"><span class="item-num">13.2</span> <span class="item-title">Definición de Stubs (when) y Verificaciones (verify)</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Las pruebas unitarias garantizan que cada componente individual de la lógica de negocio funcione correctamente de forma aislada y sin dependencias externas lentas. En este tema dominarás el ciclo de vida de JUnit 5, las aserciones semánticas y el uso de Mockito (<code class="kw">when</code>, <code class="kw">verify</code>, mocks e inyecciones simuladas) para verificar casos de éxito y límites de error.
          </p>

          <div class="tip-box" style="background: var(--color-canvas-subtle); border-left: 4px solid var(--color-primer-border-active); padding: 16px 20px; margin: 20px 0; border-radius: 6px;">
            <h5 style="margin-top: 0; margin-bottom: 8px; font-size: 15px; color: var(--color-fg-default); display: flex; align-items: center; gap: 8px;">
              <span>💡</span> <strong>Intuición para Principiantes: ¿Cómo testear sin romper nada? (El simulador de vuelo y los dobles de riesgo)</strong>
            </h5>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              Cuando estás aprendiendo a programar, hacer tests automáticos puede parecer una pérdida de tiempo: <em>"¿Por qué escribir código para probar código si puedo probarlo yo mismo abriendo Postman o el navegador?"</em>. La respuesta es que cuando tu sistema crece a decenas de entidades y cientos de reglas de negocio, es humanamente imposible probar a mano toda la aplicación cada vez que tocas una línea. Un test automatizado tarda <strong>5 milisegundos</strong> y te da la certeza de que tu cambio no ha roto nada más.
            </p>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              <strong>La pirámide de tests explicada de forma sencilla:</strong>
            </p>
            <ul style="margin-bottom: 12px; font-size: 13.5px; line-height: 1.6; padding-left: 20px;">
              <li><strong>Test Unitario con Mockito (La base de la pirámide — 70%)</strong>: Quieres probar la lógica de <code class="kw">LibroService</code> (por ejemplo, cómo calcula si un libro está disponible). Pero <code class="kw">LibroService</code> depende de <code class="kw">LibroRepository</code>, que a su vez necesita una base de datos real. Conectar con la base de datos es lento y puede fallar por problemas de red. ¿La solución? Usar un <strong>Mock</strong> (un <em>doble de acción</em> o simulador). Con <code class="kw">@Mock</code> creamos un repositorio ficticio y con <code class="kw">when(repo.findById(1L)).thenReturn(...)</code> le ordenamos: <em>"Cuando el servicio te pida el libro 1, devuélvele este libro falso"</em>. Así probamos el servicio en 2 milisegundos sin tocar la base de datos.</li>
              <li><strong>Test de Integración Web con <code class="kw">@WebMvcTest</code> (20%)</strong>: Prueba exclusivamente la capa del controlador y la red HTTP. Simula una llamada web real con <code>MockMvc</code> y comprueba si la API responde con código HTTP 200 y el JSON esperado con <code class="kw">jsonPath</code>, sin necesidad de levantar el servidor Tomcat completo.</li>
              <li><strong>Test End-to-End con <code class="kw">@SpringBootTest</code> (10%)</strong>: El ensayo general completo. Arranca Spring Boot al completo, conecta a una base de datos en memoria y verifica el flujo íntegro desde la petición HTTP hasta la persistencia en tabla.</li>
            </ul>
          </div>

          <h4 id="tema-13-aislamiento">13.1 Aislamiento con @Mock y @InjectMocks</h4>
          <p>
            <code class="kw">@Mock</code> genera un doble simulado del repositorio sin tocar la base de datos, y <code class="kw">@InjectMocks</code> inyecta los mocks automáticamente en la instancia real del servicio bajo prueba en BiblioTech.
          </p>

          <h4 id="tema-13-when-verify">13.2 Definición de Stubs (when) y Verificaciones (verify)</h4>
          <p>
            <code class="kw">when(...).thenReturn(...)</code> fija el comportamiento esperado, y <code class="kw">verify(...)</code> certifica que la interacciones ocurrieron con los parámetros exactos y el número de veces requerido.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.service;

<span class="kw">import</span> com.bibliotech.repository.<span class="typ">LibroRepository</span>;
<span class="kw">import</span> com.bibliotech.entity.<span class="typ">Libro</span>;
<span class="kw">import</span> com.bibliotech.dto.<span class="typ">LibroResponseDTO</span>;
<span class="kw">import</span> org.junit.jupiter.api.<span class="typ">Test</span>;
<span class="kw">import</span> org.junit.jupiter.api.extension.<span class="typ">ExtendWith</span>;
<span class="kw">import</span> org.mockito.<span class="typ">InjectMocks</span>;
<span class="kw">import</span> org.mockito.<span class="typ">Mock</span>;
<span class="kw">import</span> org.mockito.junit.jupiter.<span class="typ">MockitoExtension</span>;
<span class="kw">import</span> java.util.<span class="typ">Optional</span>;
<span class="kw">import</span> static org.mockito.Mockito.*;
<span class="kw">import</span> static org.junit.jupiter.api.<span class="typ">Assertions</span>.*;

<span class="ann">@ExtendWith</span>(<span class="typ">MockitoExtension</span>.<span class="kw">class</span>)
<span class="kw">class</span> <span class="typ">LibroServiceTest</span> {

    <span class="ann">@Mock</span>
    <span class="kw">private</span> <span class="typ">LibroRepository</span> libroRepository;

    <span class="ann">@InjectMocks</span>
    <span class="kw">private</span> <span class="typ">LibroService</span> libroService;

    <span class="ann">@Test</span>
    <span class="kw">void</span> <span class="fn">debeRetornarLibroCuandoExiste</span>() {
        <span class="typ">Libro</span> libroMock = <span class="typ">Libro</span>.<span class="fn">builder</span>()
            .<span class="fn">id</span>(1L)
            .<span class="fn">titulo</span>(<span class="str">"Clean Architecture"</span>)
            .<span class="fn">isbn</span>(<span class="str">"978-0134494166"</span>)
            .<span class="fn">build</span>();

        <span class="fn">when</span>(libroRepository.<span class="fn">findById</span>(1L)).<span class="fn">thenReturn</span>(<span class="typ">Optional</span>.<span class="fn">of</span>(libroMock));

        <span class="typ">LibroResponseDTO</span> resultado = libroService.<span class="fn">buscarPorId</span>(1L);

        <span class="fn">assertNotNull</span>(resultado);
        <span class="fn">assertEquals</span>(<span class="str">"Clean Architecture"</span>, resultado.<span class="fn">titulo</span>());
        <span class="fn">verify</span>(libroRepository, <span class="fn">times</span>(1)).<span class="fn">findById</span>(1L);
    }
}</code></pre>
          </code-block>

        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
