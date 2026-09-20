<?php
  $in_bloque_context = false;
  include_once __DIR__ . '/components/header.php';
  include_once __DIR__ . '/components/sidebar.php';
?>

<main class="main-wrapper markdown-body">
  <div class="content-grid">
    <div class="content-main">
      <section id="hub-proyectos" class="study-section">
        
        <!-- HERO / HEADER BANNER -->
        <div class="projects-hero-banner">
          <div class="projects-hero-badge">🚀 Proyectos Prácticos & Portafolio</div>
          <h2>Proyectos Guiados Paso a Paso</h2>
          <p class="projects-hero-subtitle">
            Pon a prueba tus conocimientos de Spring Boot con proyectos reales diseñados para construir tu portafolio. Cada proyecto incluye una guía estructurada con <strong>arquitectura de carpetas</strong>, <strong>configuración de dependencias Maven/Gradle</strong>, <strong>código paso a paso</strong> e <strong>instrucciones para publicar en GitHub</strong>.
          </p>
          <div class="projects-stats-row">
            <div class="stat-item">
              <span class="stat-number">7</span>
              <span class="stat-label">Proyectos Reales</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">4</span>
              <span class="stat-label">Niveles de Dificultad</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">10+</span>
              <span class="stat-label">Módulos de Spring</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">100%</span>
              <span class="stat-label">Listos para GitHub</span>
            </div>
          </div>
        </div>

        <!-- APP DE FILTRADO INTERACTIVO -->
        <div class="projects-filter-app">
          
          <div class="projects-search-bar">
            <span class="search-icon-projects">🔍</span>
            <input 
              type="text" 
              id="project-search-input" 
              class="projects-search-input" 
              placeholder="Buscar por título, tecnología (ej: JWT, Kafka, Docker) o palabras clave..."
              autocomplete="off"
              spellcheck="false"
            >
            <button id="project-search-clear" class="projects-search-clear" style="display: none;" title="Limpiar búsqueda">✕</button>
          </div>

          <!-- PANEL DE FILTROS (GRID RESPONSIVO) -->
          <div class="projects-filter-panel">
            
            <!-- FILTRO: DIFICULTAD -->
            <div class="filter-group">
              <div class="filter-group-title">🎯 Dificultad</div>
              <div class="filter-checkbox-list">
                <label class="filter-checkbox-label">
                  <input type="checkbox" class="filter-checkbox" name="difficulty" value="principiante">
                  <span class="checkbox-custom diff-badge-principiante"></span>
                  <span>🟢 Principiante</span>
                </label>
                <label class="filter-checkbox-label">
                  <input type="checkbox" class="filter-checkbox" name="difficulty" value="intermedio">
                  <span class="checkbox-custom diff-badge-intermedio"></span>
                  <span>🔵 Intermedio</span>
                </label>
                <label class="filter-checkbox-label">
                  <input type="checkbox" class="filter-checkbox" name="difficulty" value="avanzado">
                  <span class="checkbox-custom diff-badge-avanzado"></span>
                  <span>🟣 Avanzado</span>
                </label>
                <label class="filter-checkbox-label">
                  <input type="checkbox" class="filter-checkbox" name="difficulty" value="experto">
                  <span class="checkbox-custom diff-badge-experto"></span>
                  <span>🔴 Experto</span>
                </label>
              </div>
            </div>

            <!-- FILTRO: TECNOLOGÍAS -->
            <div class="filter-group filter-group-wide">
              <div class="filter-group-title">🛠️ Tecnologías e Integraciones</div>
              <div class="filter-chips-grid">
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="web">
                  <span class="chip-text">Spring Web (REST)</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="jpa">
                  <span class="chip-text">Spring Data JPA</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="validation">
                  <span class="chip-text">Bean Validation</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="security">
                  <span class="chip-text">Spring Security 6</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="jwt">
                  <span class="chip-text">JWT Tokens</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="actuator">
                  <span class="chip-text">Actuator & Metrics</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="testcontainers">
                  <span class="chip-text">Testcontainers</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="wiremock">
                  <span class="chip-text">WireMock</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="docker">
                  <span class="chip-text">Docker & Compose</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="kafka">
                  <span class="chip-text">Apache Kafka</span>
                </label>
                <label class="filter-chip-label">
                  <input type="checkbox" class="filter-chip-input" name="tech" value="mapstruct">
                  <span class="chip-text">MapStruct & DTOs</span>
                </label>
              </div>
            </div>

            <!-- FILTRO: ARQUITECTURA Y DURACIÓN -->
            <div class="filter-group">
              <div class="filter-group-title">📐 Arquitectura & Duración</div>
              <div class="filter-select-stack">
                <div class="select-field">
                  <label for="filter-architecture" class="select-label">Estilo Arquitectónico:</label>
                  <select id="filter-architecture" class="filter-select">
                    <option value="todas">Todas las arquitecturas</option>
                    <option value="capas">Monolito Limpio en Capas</option>
                    <option value="stateless">API REST Stateless</option>
                    <option value="event-driven">Arquitectura Event-Driven (EDA)</option>
                  </select>
                </div>
                <div class="select-field">
                  <label for="filter-duration" class="select-label">Tiempo Estimado:</label>
                  <select id="filter-duration" class="filter-select">
                    <option value="todas">Cualquier duración</option>
                    <option value="rapido">⚡ Rápido (&lt; 2 horas)</option>
                    <option value="medio">⏳ Medio (1 día)</option>
                    <option value="completo">🚀 Completo (Fin de semana)</option>
                  </select>
                </div>
              </div>
            </div>

          </div>

          <!-- BARRA DE RESULTADOS Y CONTROLES -->
          <div class="projects-results-bar">
            <div id="projects-counter" class="projects-counter">
              Mostrando <strong id="visible-count">7</strong> de <strong id="total-count">7</strong> proyectos
            </div>
            <button id="project-clear-filters" class="btn-clear-filters" style="display: none;">
              🗑️ Limpiar todos los filtros
            </button>
          </div>

        </div>

        <!-- CUADRÍCULA DE PROYECTOS -->
        <div id="projects-grid" class="projects-grid">
          
          <!-- PROYECTO 1 -->
          <article class="project-card" 
            data-difficulty="principiante" 
            data-techs="web,jpa,validation" 
            data-architecture="capas" 
            data-duration="rapido"
            data-keywords="bibliotech crud libros prestamos responseentity rfc7807 postgresql h2 validation"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-principiante">🟢 Principiante</div>
              <div class="project-duration-tag">⏱️ &lt; 2 horas</div>
            </div>
            <h3 class="project-title">1. BiblioTech REST API</h3>
            <p class="project-desc">
              API REST completa para la gestión de biblioteca: catálogo de libros, gestión de préstamos, validaciones Bean Validation y manejo global de excepciones con RFC 7807.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">Spring Web</span>
              <span class="tech-tag">Spring Data JPA</span>
              <span class="tech-tag">Bean Validation</span>
              <span class="tech-tag">PostgreSQL / H2</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Diseño limpio en capas (Controller &rarr; Service &rarr; Repository).</li>
                <li>Uso de <code>ResponseEntity</code> y códigos HTTP semánticos (201, 404, 400).</li>
                <li>Mapeo de excepciones globales con <code>ProblemDetail</code>.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

          <!-- PROYECTO 2 -->
          <article class="project-card" 
            data-difficulty="principiante" 
            data-techs="web,jpa,mapstruct" 
            data-architecture="stateless" 
            data-duration="rapido"
            data-keywords="taskflow kanban tareas records mapstruct dto repositorios"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-principiante">🟢 Principiante</div>
              <div class="project-duration-tag">⏱️ &lt; 2 horas</div>
            </div>
            <h3 class="project-title">2. TaskFlow — Tablero Kanban & Tareas</h3>
            <p class="project-desc">
              Sistema de gestión de tareas por estados (PENDIENTE, EN_PROCESO, COMPLETADO) desacoplado mediante Java Records inmutables y mappers automáticos con MapStruct.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">Spring Web</span>
              <span class="tech-tag">Java Records</span>
              <span class="tech-tag">MapStruct</span>
              <span class="tech-tag">Spring Data JPA</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Uso del patrón DTO inmutable con Java 16+ Records.</li>
                <li>Generación automática de mappers en compilación con MapStruct.</li>
                <li>Evitar fugas de entidades JPA y ciclos infinitos en JSON.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

          <!-- PROYECTO 3 -->
          <article class="project-card" 
            data-difficulty="intermedio" 
            data-techs="web,jpa,validation" 
            data-architecture="capas" 
            data-duration="medio"
            data-keywords="ecommerce tienda pedidos carrito specifications transactional junit mockito"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-intermedio">🔵 Intermedio</div>
              <div class="project-duration-tag">⏱️ 1 día</div>
            </div>
            <h3 class="project-title">3. E-Commerce Storefront & Pedidos</h3>
            <p class="project-desc">
              Motor backend de tienda virtual con filtros de búsqueda avanzados mediante JPA Specifications, gestión de transacciones ACID (`@Transactional`) y suite de tests unitarios.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">JPA Specifications</span>
              <span class="tech-tag">@Transactional</span>
              <span class="tech-tag">JUnit 5</span>
              <span class="tech-tag">Mockito</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Consultas dinámicas y desacopladas con JPA Criteria API.</li>
                <li>Gestión de transacciones ACID y rollbacks automáticos.</li>
                <li>Pruebas unitarias de servicios aísladas con Mockito.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

          <!-- PROYECTO 4 -->
          <article class="project-card" 
            data-difficulty="avanzado" 
            data-techs="web,security,jwt,jpa" 
            data-architecture="stateless" 
            data-duration="medio"
            data-keywords="secureauth seguridad jwt oauth2 spring security 6 rbac bcrypt refresh token"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-avanzado">🟣 Avanzado</div>
              <div class="project-duration-tag">⏱️ 1 día</div>
            </div>
            <h3 class="project-title">4. SecureAuth — Servidor JWT & Security 6</h3>
            <p class="project-desc">
              Microservicio de autenticación sin estado (Stateless) con Spring Security 6, emisión/verificación de Tokens JWT, contraseñas encriptadas con BCrypt y control de acceso RBAC.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">Spring Security 6</span>
              <span class="tech-tag">JWT</span>
              <span class="tech-tag">BCrypt</span>
              <span class="tech-tag">RBAC Roles</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Configuración de <code>SecurityFilterChain</code> con DSL Lambda.</li>
                <li>Filtros personalizados de interceptación de Tokens JWT.</li>
                <li>Protección de métodos con <code>@PreAuthorize("hasRole('ADMIN')")</code>.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

          <!-- PROYECTO 5 -->
          <article class="project-card" 
            data-difficulty="intermedio" 
            data-techs="web,actuator,docker" 
            data-architecture="capas" 
            data-duration="rapido"
            data-keywords="opspulse observabilidad actuator micrometer prometheus grafana health metrics"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-intermedio">🔵 Intermedio</div>
              <div class="project-duration-tag">⏱️ &lt; 2 horas</div>
            </div>
            <h3 class="project-title">5. OpsPulse — Observabilidad & Telemetría</h3>
            <p class="project-desc">
              Servicio de monitoreo de producción con Spring Boot Actuator, indicadores de salud personalizados, métricas customizadas con Micrometer y exportación a Prometheus & Grafana.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">Actuator</span>
              <span class="tech-tag">Micrometer</span>
              <span class="tech-tag">Prometheus</span>
              <span class="tech-tag">Docker</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Creación de <code>HealthIndicator</code> personalizados.</li>
                <li>Medición de métricas de negocio con <code>MeterRegistry</code>.</li>
                <li>Visualización de métricas de la JVM en tableros de Grafana.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

          <!-- PROYECTO 6 -->
          <article class="project-card" 
            data-difficulty="experto" 
            data-techs="web,kafka,docker" 
            data-architecture="event-driven" 
            data-duration="completo"
            data-keywords="eventdrive kafka eventos asincronos docker compose microservicios notificaciones"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-experto">🔴 Experto</div>
              <div class="project-duration-tag">⏱️ Fin de semana</div>
            </div>
            <h3 class="project-title">6. EventDrive — Notificaciones con Kafka & Docker</h3>
            <p class="project-desc">
              Arquitectura guiada por eventos (EDA) multi-servicio con Apache Kafka: publicación de eventos de dominio, consumo asíncrono y orquestación con Docker Compose.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">Apache Kafka</span>
              <span class="tech-tag">Spring Kafka</span>
              <span class="tech-tag">Docker Compose</span>
              <span class="tech-tag">Event-Driven</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Publicación de eventos con <code>KafkaTemplate</code>.</li>
                <li>Consumidores tolerantes a fallos con <code>@KafkaListener</code>.</li>
                <li>Orquestación multi-contenedor con <code>docker-compose.yml</code>.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

          <!-- PROYECTO 7 -->
          <article class="project-card" 
            data-difficulty="avanzado" 
            data-techs="web,jpa,testcontainers,wiremock,docker" 
            data-architecture="stateless" 
            data-duration="completo"
            data-keywords="qualitykit testcontainers wiremock integracion postgresql stripe mock testing"
          >
            <div class="project-card-header">
              <div class="project-diff-badge diff-avanzado">🟣 Avanzado</div>
              <div class="project-duration-tag">⏱️ Fin de semana</div>
            </div>
            <h3 class="project-title">7. QualityKit — Testcontainers & WireMock Suite</h3>
            <p class="project-desc">
              Suite completa de pruebas de integración E2E sobre entornos reales: PostgreSQL ejecutado en contenedores de Testcontainers y mocheo HTTP de pasarelas de pago con WireMock.
            </p>
            <div class="project-tech-stack">
              <span class="tech-tag">Testcontainers</span>
              <span class="tech-tag">WireMock</span>
              <span class="tech-tag">Spring Boot Test</span>
              <span class="tech-tag">PostgreSQL Real</span>
            </div>
            <div class="project-highlights">
              <strong>Lo que aprenderás:</strong>
              <ul>
                <li>Levantamiento dinámico de PostgreSQL en Docker mediante Testcontainers.</li>
                <li>Inyección dinámica de propiedades con <code>@DynamicPropertySource</code>.</li>
                <li>Simulación de APIs externas de terceros con WireMock.</li>
              </ul>
            </div>
            <div class="project-card-footer">
              <span class="github-ready-tag">🐙 Paso a paso + GitHub Guide</span>
              <a href="#" class="btn-view-project">Ver Guía del Proyecto &rarr;</a>
            </div>
          </article>

        </div>

        <!-- ESTADO VACÍO (SIN RESULTADOS) -->
        <div id="projects-empty-state" class="projects-empty-state" style="display: none;">
          <div class="empty-icon">🔍</div>
          <h3>No se encontraron proyectos</h3>
          <p>Ningún proyecto coincide con la combinación de filtros seleccionada. Prueba a desactivar algunos filtros o borrar el término de búsqueda.</p>
          <button id="btn-reset-empty" class="btn-reset-empty">Ver todos los proyectos</button>
        </div>

      </section>
    </div>
  </div>
</main>

<script src="<?php echo $base_url; ?>js/projects.js"></script>

<?php include_once __DIR__ . '/components/footer.php'; ?>

