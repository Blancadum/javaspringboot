<?php
  $in_bloque_context = true;
  include_once __DIR__ . '/components/header.php';
  include_once __DIR__ . '/components/sidebar.php';
?>

<main class="main-wrapper markdown-body">
  <div class="content-grid">
    <div class="content-main">
      <section id="recursos" class="study-section">
        <h2>Recursos de estudio</h2>

        <div class="resource-page-grid">
          <article class="resource-panel resource-panel-primary">
            <div class="resource-panel-header">
              <h3>📘 Diccionario de conceptos</h3>
            </div>

            <div class="resource-search-wrap search-wrapper">
              <span class="search-icon">🔍</span>
              <input type="text" id="glossary-search" class="search-input" placeholder="Buscar concepto, término o ejemplo..." autocomplete="off" spellcheck="false" aria-label="Buscar en el diccionario">
            </div>

            <div class="glossary-list resource-glossary-list">
              <div class="glossary-item" data-term="bean inversion control spring">
                <div class="glossary-term">Bean</div>
                <p>Un <strong>bean</strong> es un objeto gestionado por Spring. El contenedor crea, configura y reutiliza estos objetos para que la aplicación esté desacoplada y más fácil de mantener.</p>
                <code>@Service
public class LibroService {}</code>
              </div>

              <div class="glossary-item" data-term="dto data transfer object">
                <div class="glossary-term">DTO</div>
                <p>Un <strong>DTO</strong> es un objeto pensado para transportar datos entre capas. Se usa para evitar exponer directamente entidades JPA o modelos internos de la base de datos.</p>
                <code>record LibroDTO(Long id, String titulo) {}</code>
              </div>

              <div class="glossary-item" data-term="inversion de control dependencia">
                <div class="glossary-term">Inversión de Control</div>
                <p>La <strong>IoC</strong> consiste en que la creación de dependencias la controla el contenedor, no la propia clase. Así se reduce el acoplamiento y se hace más sencillo testear el código.</p>
                <code>private final LibroRepository repo;
public LibroService(LibroRepository repo) { this.repo = repo; }</code>
              </div>

              <div class="glossary-item" data-term="transaccion atomicidad rollback">
                <div class="glossary-term">Transacción</div>
                <p>Una <strong>transacción</strong> agrupa varias operaciones para que se ejecuten como una única unidad. Si falla una parte, se revierte todo para mantener la consistencia.</p>
                <code>@Transactional
public void reservarLibro() { ... }</code>
              </div>

              <div class="glossary-item" data-term="jwt token seguridad autenticacion">
                <div class="glossary-term">JWT</div>
                <p>Un <strong>JWT</strong> es un token firmado que transporta identidad y permisos. Se usa para autenticar llamadas sin depender de sesiones en servidor.</p>
                <code>Authorization: Bearer eyJhbGciOiJIUzI1NiJ9...</code>
              </div>

              <div class="glossary-item" data-term="api rest http">
                <div class="glossary-term">API REST</div>
                <p>Una <strong>API REST</strong> expone recursos a través de URLs y verbos HTTP. Es la base para que frontends, móviles o servicios externos consuman la aplicación.</p>
                <code>GET /api/libros/1</code>
              </div>

              <div class="glossary-item" data-term="jpa orm">
                <div class="glossary-term">JPA / ORM</div>
                <p>La <strong>persistencia ORM</strong> mapea clases Java a tablas de base de datos. Permite trabajar con objetos y dejar la traducción SQL en manos del framework.</p>
                <code>@Entity
public class Libro { ... }</code>
              </div>

              <div class="glossary-item" data-term="autoconfiguracion spring">
                <div class="glossary-term">Autoconfiguración</div>
                <p>Spring Boot detecta dependencias y configura automáticamente los beans necesarios para que la aplicación arranque con pocas líneas de configuración.</p>
                <code>@SpringBootApplication
public class App {}</code>
              </div>
            </div>
          </article>

          <article class="resource-panel">
            <div class="resource-panel-header">
              <h3>🎓 Acreditaciones y cursos</h3>
            </div>

            <div class="resource-links-list">
              <a class="resource-link-card" href="https://spring.io/projects/spring-boot" target="_blank" rel="noreferrer">
                <span class="resource-link-title">Spring Boot</span>
                <span class="resource-link-meta">Documentación oficial</span>
              </a>

              <a class="resource-link-card" href="https://www.oracle.com/java/" target="_blank" rel="noreferrer">
                <span class="resource-link-title">Java</span>
                <span class="resource-link-meta">Oracle · fundamentos y evolución</span>
              </a>

              <a class="resource-link-card" href="https://www.baeldung.com/" target="_blank" rel="noreferrer">
                <span class="resource-link-title">Baeldung</span>
                <span class="resource-link-meta">Prácticas y ejemplos reales</span>
              </a>

              <a class="resource-link-card" href="https://www.udemy.com/courses/search/?q=spring%20boot" target="_blank" rel="noreferrer">
                <span class="resource-link-title">Spring Boot en Udemy</span>
                <span class="resource-link-meta">Cursos orientados a certificaciones</span>
              </a>

              <a class="resource-link-card" href="https://www.coursera.org/search?query=spring%20boot" target="_blank" rel="noreferrer">
                <span class="resource-link-title">Coursera</span>
                <span class="resource-link-meta">Ruta estructurada y más académica</span>
              </a>

              <a class="resource-link-card" href="https://www.pluralsight.com/search?q=spring%20boot" target="_blank" rel="noreferrer">
                <span class="resource-link-title">Pluralsight</span>
                <span class="resource-link-meta">Formación técnica y práctica profesional</span>
              </a>
            </div>
          </article>
        </div>

        <div class="resource-roadmap-panel resource-panel">
          <div class="resource-panel-header">
            <h3>🧭 Ruta recomendada por nivel</h3>
          </div>

          <div class="roadmap-grid">
            <div class="roadmap-level roadmap-level-beginner">
              <h4>Principiante</h4>
              <ul>
                <li>Java básico: variables, clases, interfaces, colecciones.</li>
                <li>Git y GitHub.</li>
                <li>Spring Boot inicial: arranque, beans y controladores.</li>
                <li>HTTP, REST y JSON.</li>
              </ul>
            </div>

            <div class="roadmap-level roadmap-level-intermediate">
              <h4>Intermedio</h4>
              <ul>
                <li>JPA, Hibernate y relaciones entre entidades.</li>
                <li>DTO, validación y manejo de errores.</li>
                <li>Seguridad con Spring Security y JWT.</li>
                <li>Testing unitario e integración.</li>
              </ul>
            </div>

            <div class="roadmap-level roadmap-level-advanced">
              <h4>Avanzado</h4>
              <ul>
                <li>Arquitectura hexagonal y capas bien definidas.</li>
                <li>Docker, despliegues y entornos de desarrollo.</li>
                <li>Observabilidad, logs, métricas y monitorización.</li>
                <li>Microservicios, calidad y automatización.</li>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</main>

<?php include_once __DIR__ . '/components/footer.php'; ?>
