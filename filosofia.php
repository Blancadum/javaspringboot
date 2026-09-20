<?php include_once __DIR__ . '/components/header.php'; ?>
<?php include_once __DIR__ . '/components/sidebar.php'; ?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- FILOSOFÍA Y PARADIGMA ARQUITECTÓNICO -->
      <section id="filosofia-paradigma" class="study-section">
        <h2>Fundamentos Filosóficos y Paradigma Arquitectónico</h2>

        <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">Fundamentos Filosóficos</div>
            <a href="#filo-1-1" class="topic-dropdown-item"><span class="item-num">1.1</span> <span class="item-title">Los Tres Niveles de Abstracción en Software</span></a>
            <a href="#filo-1-2" class="topic-dropdown-item"><span class="item-num">1.2</span> <span class="item-title">El Pecado Original: Acoplamiento por new</span></a>
            <a href="#filo-1-3" class="topic-dropdown-item"><span class="item-num">1.3</span> <span class="item-title">La Regla de Oro de las Dependencias</span></a>
            <a href="#filo-1-4" class="topic-dropdown-item"><span class="item-num">1.4</span> <span class="item-title">Arquitectura Hexagonal (Puertos y Adaptadores</span></a>
            <a href="#filo-1-5" class="topic-dropdown-item"><span class="item-num">1.5</span> <span class="item-title">El Paradigma Stateless y la Concurrencia Web</span></a>
          </div>
        </details>

        <p>
          Antes de escribir una sola línea de código en Spring Boot, es indispensable comprender la <strong>filosofía que motiva las decisiones arquitectónicas</strong> del desarrollo backend moderno.
        </p>

        <h3 id="filo-1-1">1.1 Los Tres Niveles de Abstracción en Software</h3>
        <p>
          Construir una aplicación no es solo unir código que compile. El desarrollo profesional opera en tres niveles complementarios:
        </p>
        <ol>
          <li><strong>Nivel 1 — Código</strong>: La calidad intrínseca de cada método. Nombres significativos, funciones de responsabilidad única, ausencia de efectos colaterales y legibilidad.</li>
          <li><strong>Nivel 2 — Diseño</strong>: Cómo interactúan las clases entre sí. Aplicación de patrones de diseño (Factory, Builder, Singleton, Strategy) y principios SOLID.</li>
          <li><strong>Nivel 3 — Arquitectura</strong>: La estructura macroscópica del sistema. Cómo se empaquetan los módulos, cómo fluyen los datos y qué fronteras estrictas delimitan cada componente.</li>
        </ol>

        <h3 id="filo-1-2">1.2 El Pecado Original: El Acoplamiento por new</h3>
        <p>
          En la programación orientada a objetos convencional, cuando la clase <code>A</code> necesita utilizar la clase <code>B</code>, es común instanciarla directamente:
        </p>
        <code-block lang="java">
<pre><code><span class="cmt">// ❌ ANTIPATRÓN: Acoplamiento fuerte directo en BiblioTech</span>
<span class="kw">public class</span> <span class="typ">PrestamoLibroService</span> {
    <span class="cmt">// La clase crea a mano su colaborador concreto: ¡Gravísimo error arquitectónico!</span>
    <span class="kw">private</span> <span class="typ">EmailNotificacionService</span> emailService = <span class="kw">new</span> <span class="typ">EmailNotificacionService</span>();

    <span class="kw">public void</span> <span class="fn">formalizarPrestamo</span> (<span class="typ">Libro</span> libro, <span class="typ">Usuario</span> lector) {
        <span class="cmt">// ... lógica de validación de ejemplares disponibles</span>
        emailService.<span class="fn">enviar</span>(lector.<span class="fn">getEmail</span>(), <span class="str">"Préstamo confirmado: "</span> + libro.<span class="fn">getTitulo</span>());
    }
}</code></pre>
        </code-block>

        <p>
          ¿Por qué esto representa un problema grave en entornos empresariales como BiblioTech?
        </p>
        <ul>
          <li><strong>Falta de abstracción</strong>: <code>PrestamoLibroService</code> conoce la clase concreta exacta. Si mañana la biblioteca decide notificar por SMS o WhatsApp, habría que modificar y recompilar la lógica de negocio.</li>
          <li><strong>Imposibilidad de testing unitario puro</strong>: No se puede probar la lógica de <code>formalizarPrestamo</code> sin intentar enviar un email real por la red, porque no podemos sustituir <code>emailService</code> por un objeto simulado (Mock).</li>
          <li><strong>Multiplicación de instancias innecesarias</strong>: Si 50 servicios usan notificaciones, crearemos 50 instancias de un servicio que realmente no tiene estado interno y podría ser compartido como un Singleton.</li>
        </ul>

        <github-alert type="important" title="El Principio de Hollywood: Inversión de Control (IoC)">
          <p>
            <em>"Don't call us, we'll call you"</em> (No nos llames a nosotros, nosotros te llamaremos a ti).<br>
            En lugar de que tu código tome la iniciativa de crear sus dependencias con <code>new</code>, cedes el control a un <strong>Contenedor de Inversión de Control</strong> (en Spring, el <code>ApplicationContext</code>). Tú únicamente declaras qué necesitas a través del constructor, y el framework se encarga de instanciarlo y suministrártelo.
          </p>
        </github-alert>

        <h3 id="filo-1-3">1.3 La Regla de Oro de las Dependencias</h3>
        <p>
          En una arquitectura en capas tradicional, la aplicación se divide en tres responsabilidades estancas:
        </p>
        <ol>
          <li><strong>Capa de Presentación</strong>: Interactúa con el mundo exterior (recibe HTTP, serializa/deserializa JSON). En Spring Boot: clases anotadas con <code>@RestController</code>.</li>
          <li><strong>Capa de Negocio</strong>: El cerebro del sistema. Contiene las reglas, cálculos, políticas de descuento y validaciones lógicas. En Spring Boot: clases anotadas con <code>@Service</code>.</li>
          <li><strong>Capa de Datos (Persistencia)</strong>: Comunicación con el motor relacional (SQL/BBDD). En Spring Boot: interfaces anotadas con <code>@Repository</code> (o extensiones de <code>JpaRepository</code>).</li>
        </ol>

        <github-alert type="warning" title="Regla de Oro: Las dependencias solo viajan hacia abajo">
          <p>
            <code>Presentación → depende de → Negocio → depende de → Datos</code><br>
            <strong>La capa de Datos JAMÁS debe conocer ni llamar a la capa de Negocio.</strong> La capa de Negocio JAMÁS debe conocer cómo se presenta la información al usuario (desconoce HTTP, JSON o HTML). Si la Presentación se salta a Negocio para consultar directamente Datos, se rompe el encapsulamiento y las reglas de negocio quedan desprotegidas.
          </p>
        </github-alert>

        <h3 id="filo-1-4">1.4 Arquitectura Concéntrica y Hexagonal (Puertos y Adaptadores)</h3>
        <p>
          Cuando los sistemas evolucionan, la arquitectura en capas clásica presenta una limitación: la capa de Negocio termina acoplada a la tecnología de base de datos (por ejemplo, importando librerías de JPA o Hibernate dentro de sus clases de dominio).
        </p>
        <p>
          Para resolver esto, <strong>Alistair Cockburn</strong> introdujo la <strong>Arquitectura Hexagonal (Puertos y Adaptadores)</strong>, conceptualmente alineada con la <em>Clean Architecture</em> de Robert C. Martin:
        </p>

        <div class="block-intro-layout">
          <div class="block-summary-side">
            <div class="block-summary-card">
              <p>
                En este paradigma:
              </p>
              <ul>
                <li><strong>El Dominio (Centro Inmaculado)</strong>: Es código Java puro. No contiene importaciones de Spring, ni de Hibernate, ni anotaciones de base de datos. Define cómo funciona el negocio real (ej. cómo se calcula el interés de una hipoteca).</li>
                <li><strong>Puertos de Entrada (Driving Ports)</strong>: Interfaces que exponen qué operaciones permite realizar el dominio (ej. <code>CrearPedidoUseCase</code>).</li>
                <li><strong>Puertos de Salida (Driven Ports)</strong>: Interfaces que declaran qué necesita el dominio del exterior (ej. <code>PedidoRepositoryPort</code>).</li>
                <li><strong>Adaptadores Primarios (Entrada)</strong>: Controladores REST, comandos de consola (CLI), mensajes de colas Kafka o tests. Traducen la petición externa e invocan el puerto de entrada.</li>
                <li><strong>Adaptadores Secundarios (Salida)</strong>: Implementaciones concretas de los puertos de salida (ej. un repositorio que usa Spring Data JPA + PostgreSQL, un cliente HTTP que llama a SendGrid para emails).</li>
              </ul>
            </div>
          </div>

          <div class="block-intro-main">
            <div class="block-summary-card">
              <figure class="block-summary-figure">
                <img src="<?php echo $base_url; ?>img/ARQ-HEX.png" alt="Arquitectura Concéntrica y Hexagonal: Presentación, Negocio y Datos">
                <figcaption>Figura 1: Representación concéntrica del software. El Dominio y las reglas de Negocio ocupan el núcleo, protegidos del exterior por capas concéntricas.</figcaption>
              </figure>
            </div>
          </div>
        </div>

        <github-alert type="tip" title="Ventaja de la Filosofía Hexagonal">
          <p>
            Si mañana decides cambiar PostgreSQL por MongoDB, o cambiar Spring Boot por Quarkus, <strong>el 100% de la lógica de negocio permanece intacta</strong>, porque solo necesitas cambiar el adaptador externo, sin tocar una sola regla del dominio central.
          </p>
        </github-alert>

        <h3 id="filo-1-5">1.5 El Paradigma Stateless (Sin Estado) y la Concurrencia Web</h3>
        <p>
          En los albores de la web (modelo MPA tradicional), los servidores mantenían una sesión en memoria para cada usuario (<code>HttpSession</code>). Si 10.000 usuarios estaban conectados, el servidor retenía 10.000 objetos en su memoria RAM.
        </p>
        <p>
          En las aplicaciones web modernas y APIs RESTful:
        </p>
        <ul>
          <li><strong>HTTP es Stateless</strong>: Cada petición HTTP es totalmente autónoma. El servidor no recuerda la petición anterior.</li>
          <li><strong>Beans de Spring son Singletons Stateless</strong>: Spring crea una única instancia de cada <code>@Service</code> y <code>@RestController</code> para toda la aplicación. Un único objeto atiende peticiones de miles de clientes en hilos paralelos de Tomcat.</li>
          <li><strong>Regla de Hilos (Thread-Safety)</strong>: Como los Beans son compartidos por múltiples hilos simultáneamente, <strong>jamás deben guardar datos específicos de un usuario en variables de instancia</strong>. Los datos viajan exclusivamente a través de los argumentos de los métodos.</li>
          <li><strong>Autenticación delegada</strong>: El estado de identidad del usuario no reside en el servidor; el cliente envía un token criptográfico (JWT) en la cabecera <code>Authorization</code> en cada petición.</li>
        </ul>
        </div> <!-- Fin de content-main -->

        <aside class="topic-toc" id="dynamic-toc">
          <ul id="toc-list">
            <!-- Generado dinámicamente por app.js -->
          </ul>
        </aside>
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/components/footer.php'; ?>
