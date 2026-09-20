<?php include_once __DIR__ . '/components/header.php'; ?>
<?php include_once __DIR__ . '/components/sidebar.php'; ?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- HERO / INTRO -->
          <section id="inicio" class="study-section">
            <h1>Java con Spring Boot</h1>

            <div class="badge-row">
              <span class="gh-badge primary">Java 17 / 21 LTS</span>
              <span class="gh-badge primary">Spring Boot 3.x</span>
              <span class="gh-badge success">15 Temas Técnicos</span>
              <span class="gh-badge success">6 Bloques Temáticos</span>
              <span class="gh-badge">Desarrollo Backend</span>
              <span class="gh-badge">Arquitectura 3 Capas & Hexagonal</span>
            </div>

            <p>
              Bienvenido al manual técnico y cuaderno de estudio interactivo estructurado en 6 bloques temáticos y 15 temas de profundización técnica.
              Este recurso consolida todos los conceptos teóricos, discusiones de diseño, fragmentos de código ejecutable y pruebas tipo test con estándares de desarrollo empresarial en Java y Spring Boot.
            </p>

            <github-alert type="note" title="Cómo estudiar con esta guía">
              <p>
                Utiliza las casillas de verificación interactivas al inicio de cada bloque temático para registrar tu avance. El progreso se almacena automáticamente en tu navegador. Consulta los fragmentos de código para entender la implementación real en Java y resuelve el test interactivo al final de cada bloque conceptual.
              </p>
            </github-alert>

            <div class="resource-panel resource-panel-primary glossary-home-panel">
              <div class="resource-panel-header">
                <h3>Diccionario</h3>
              </div>

              <div class="resource-search-wrap search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" id="glossary-search" class="search-input" placeholder="Buscar concepto, término o ejemplo..." autocomplete="off" spellcheck="false" aria-label="Buscar en el diccionario">
              </div>

              <div class="glossary-list resource-glossary-list">
                <div class="glossary-item" data-term="bean inversion control spring">
                  <button class="glossary-trigger" type="button" aria-expanded="false">
                    <span>Bean</span>
                    <span class="glossary-toggle-indicator">+</span>
                  </button>
                  <div class="glossary-content" hidden>
                    <p>Un <strong>bean</strong> es un objeto gestionado por Spring. El contenedor crea, configura y reutiliza estos objetos para que la aplicación esté desacoplada y más fácil de mantener.</p>
                    <code class="kw">@Service
public class LibroService {}</code>
                    <a href="<?php echo $base_url; ?>fundamentos#fase-1" class="glossary-topic-link">Ver tema relacionado</a>
                  </div>
                </div>

                <div class="glossary-item" data-term="dto data transfer object">
                  <button class="glossary-trigger" type="button" aria-expanded="false">
                    <span>DTO</span>
                    <span class="glossary-toggle-indicator">+</span>
                  </button>
                  <div class="glossary-content" hidden>
                    <p>Un <strong>DTO</strong> es un objeto pensado para transportar datos entre capas. Se usa para evitar exponer directamente entidades JPA o modelos internos de la base de datos.</p>
                    <code class="kw">record LibroDTO(Long id, String titulo) {}</code>
                    <a href="<?php echo $base_url; ?>persistencia-dtos#fase-3" class="glossary-topic-link">Ver tema relacionado</a>
                  </div>
                </div>

                <div class="glossary-item" data-term="inversion de control dependencia">
                  <button class="glossary-trigger" type="button" aria-expanded="false">
                    <span>Inversión de Control</span>
                    <span class="glossary-toggle-indicator">+</span>
                  </button>
                  <div class="glossary-content" hidden>
                    <p>La <strong>IoC</strong> consiste en que la creación de dependencias la controla el contenedor, no la propia clase. Así se reduce el acoplamiento y se hace más sencillo testear el código.</p>
                    <code class="kw">private final LibroRepository repo;
public LibroService(LibroRepository repo) { this.repo = repo; }</code>
                    <a href="<?php echo $base_url; ?>fundamentos#fase-1" class="glossary-topic-link">Ver tema relacionado</a>
                  </div>
                </div>

                <div class="glossary-item" data-term="transaccion atomicidad rollback">
                  <button class="glossary-trigger" type="button" aria-expanded="false">
                    <span>Transacción</span>
                    <span class="glossary-toggle-indicator">+</span>
                  </button>
                  <div class="glossary-content" hidden>
                    <p>Una <strong>transacción</strong> agrupa varias operaciones para que se ejecuten como una única unidad. Si falla una parte, se revierte todo para mantener la consistencia.</p>
                    <code class="kw">@Transactional
public void reservarLibro() { ... }</code>
                    <a href="<?php echo $base_url; ?>core-spring-boot#fase-2" class="glossary-topic-link">Ver tema relacionado</a>
                  </div>
                </div>

                <div class="glossary-item" data-term="jwt token seguridad autenticacion">
                  <button class="glossary-trigger" type="button" aria-expanded="false">
                    <span>JWT</span>
                    <span class="glossary-toggle-indicator">+</span>
                  </button>
                  <div class="glossary-content" hidden>
                    <p>Un <strong>JWT</strong> es un token firmado que transporta identidad y permisos. Se usa para autenticar llamadas sin depender de sesiones en servidor.</p>
                    <code class="kw">Authorization: Bearer eyJhbGciOiJIUzI1NiJ9...</code>
                    <a href="<?php echo $base_url; ?>seguridad-docker#fase-6" class="glossary-topic-link">Ver tema relacionado</a>
                  </div>
                </div>

                <div class="glossary-item" data-term="api rest http">
                  <button class="glossary-trigger" type="button" aria-expanded="false">
                    <span>API REST</span>
                    <span class="glossary-toggle-indicator">+</span>
                  </button>
                  <div class="glossary-content" hidden>
                    <p>Una <strong>API REST</strong> expone recursos a través de URLs y verbos HTTP. Es la base para que frontends, móviles o servicios externos consuman la aplicación.</p>
                    <code class="kw">GET /api/libros/1</code>
                    <a href="<?php echo $base_url; ?>core-spring-boot#fase-2" class="glossary-topic-link">Ver tema relacionado</a>
                  </div>
                </div>
              </div>
            </div>

            <figure class="context-figure">
              <iframe 
                src="https://www.youtube.com/embed/8X2acANBuLk" 
                title="Video representativo del ecosistema Java y Spring Boot" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
              </iframe>
              <figcaption>Video del ecosistema backend con Java y Spring Boot.</figcaption>
            </figure>
          </section>
        </div> <!-- Fin de content-main -->

        <aside class="topic-toc" id="dynamic-toc">
          <ul id="toc-list">
            <!-- Generado dinámicamente por app.js -->
          </ul>
        </aside>
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/components/footer.php'; ?>
