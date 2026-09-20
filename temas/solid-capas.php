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

<article id="tema-5">
          <h3>5 — SOLID y el Arranque Mágico de Spring Boot</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">5. SOLID & Spring Boot</div>
            <a href="#tema-5-solid" class="topic-dropdown-item"><span class="item-num">5.1</span> <span class="item-title">Principios SOLID Aplicados a Backend</span></a>
            <a href="#tema-5-autoconfigure" class="topic-dropdown-item"><span class="item-num">5.2</span> <span class="item-title">Autoconfiguración y Anotaciones Core</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Spring Boot agiliza el desarrollo eliminando la configuración XML mediante la autoconfiguración condicional (<code class="ann">@EnableAutoConfiguration</code>). En este tema exploraremos cómo funciona internamente este mecanismo y cómo aplicar los cinco principios SOLID para estructurar aplicaciones desacopladas, testeables y fáciles de mantener a largo plazo.
          </p>

          <h4 id="tema-5-solid">5.1 Principios SOLID Aplicados a Backend</h4>
          <p>
            Spring Boot promueve activamente el principio de Responsabilidad Única (SRP) distribuyendo responsabilidades entre Controladores, Servicios y Repositorios, e Inversión de Dependencias (DIP) interactuando con abstracciones.
          </p>

          <h4 id="tema-5-autoconfigure">5.2 Autoconfiguración y Anotaciones Core (@SpringBootApplication)</h4>
          <p>
            Spring Boot no es un framework distinto de Spring: es una capa de <strong>opiniones y autoconfiguración</strong> sobre Spring Framework que elimina la configuración manual mediante <code class="ann">@SpringBootApplication</code>:
          </p>
          <ul>
            <li><code class="ann">@Configuration</code>: Marca la clase como fuente de definiciones de Beans.</li>
            <li><code class="ann">@EnableAutoConfiguration</code>: Lee el classpath y deduce qué librerías has incluido. Si detecta <code class="kw">spring-boot-starter-web</code>, arranca automáticamente Tomcat embebido.</li>
            <li><code class="ann">@ComponentScan</code>: Escanea automáticamente el paquete donde reside la clase principal y todos sus subpaquetes.</li>
          </ul>
        </article>

        <!-- TEMA 6 -->
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
