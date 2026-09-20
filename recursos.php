<?php
  $in_bloque_context = true;
  include_once __DIR__ . '/components/header.php';
  include_once __DIR__ . '/components/sidebar.php';
?>

<main class="main-wrapper markdown-body">
  <div class="content-grid">
    <div class="content-main">
      <section id="recursos" class="study-section">
        <h2>Credenciales y Recursos Oficiales</h2>

        <p class="topic-intro">
          Para destacar profesionalmente en el ecosistema Java y Spring Boot, es clave validar tu aprendizaje mediante <strong>certificaciones oficiales reconocidas internacionalmente</strong> y consultar de forma recurrente las <strong>fuentes de documentación oficiales de la industria</strong>.
        </p>

        <!-- BLOQUE 1: CERTIFICACIONES Y CREDENCIALES OFICIALES -->
        <article class="resource-panel resource-panel-primary" style="margin-bottom: 30px;">
          <div class="resource-panel-header">
            <h3>🏆 Certificaciones Oficiales de la Industria (Credenciales)</h3>
          </div>

          <p>
            Obtener una certificación oficial otorga respaldo institucional a tus conocimientos, acredita que dominas las últimas especificaciones de la JVM y Spring Boot 3, y te diferencia en procesos de selección para posiciones de arquitectura backend.
          </p>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            
            <!-- CERTIFICACIÓN 1: ORACLE JAVA -->
            <div style="background: var(--color-canvas-subtle); border: 1px solid var(--color-border-default); border-radius: 10px; padding: 18px; display: flex; flex-direction: column; justify: space-between;">
              <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                  <span style="font-size: 24px;">☕</span>
                  <span style="font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 12px; background: rgba(207, 34, 46, 0.15); color: #cf222e;">Oracle Official</span>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; color: var(--color-fg-default);">Oracle Certified Professional: Java SE 17 / 21 Developer</h4>
                <p style="font-size: 13px; line-height: 1.5; color: var(--color-fg-subtle); margin-bottom: 12px;">
                  <strong>Examen 1Z0-829 / 1Z0-830</strong>: La acreditación estándar global emitida por Oracle Corporation que certifica dominio avanzado del lenguaje Java.
                </p>
                <div style="font-size: 12px; color: var(--color-fg-muted); margin-bottom: 14px;">
                  <strong>Temas Evaluados:</strong>
                  <ul style="padding-left: 16px; margin-top: 4px; margin-bottom: 0;">
                    <li>Programación Orientada a Objetos avanzada e inmutabilidad.</li>
                    <li>API de Streams, Lambdas y Colecciones.</li>
                    <li>Concurrencia, Hilos Virtuales (Project Loom) y Multithreading.</li>
                    <li>Módulos Java (JPMS), Sealed Classes y Pattern Matching.</li>
                    <li>Manejo de Excepciones y I/O de archivos (NIO.2).</li>
                  </ul>
                </div>
              </div>
              <a href="https://education.oracle.com/java-se-17-developer/pexam_1Z0-829" target="_blank" rel="noreferrer" class="btn-view-project" style="align-self: flex-start; margin-top: 10px;">
                Ver Examen Oficial en Oracle &rarr;
              </a>
              <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                <a href="https://education.oracle.com/java-se-17-developer/pexam_1Z0-829" target="_blank" rel="noreferrer" class="btn-view-project" style="align-self: flex-start;">
                  Ver Examen Oficial en Oracle &rarr;
                </a>
                <a href="https://bit.ly/4rpVj43" target="_blank" rel="noreferrer" class="btn-view-project" style="align-self: flex-start; background: var(--color-canvas-default); color: var(--color-accent-fg) !important; border: 1px solid var(--color-border-default);">
                  🎓 Oracle Learner Portal &rarr;
                </a>
              </div>
            </div>

            <!-- CERTIFICACIÓN 2: SPRING BOOT -->
            <div style="background: var(--color-canvas-subtle); border: 1px solid var(--color-border-default); border-radius: 10px; padding: 18px; display: flex; flex-direction: column; justify: space-between;">
              <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                  <span style="font-size: 24px;">🌱</span>
                  <span style="font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 12px; background: rgba(45, 164, 78, 0.15); color: #2da44e;">Broadcom / VMware</span>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; color: var(--color-fg-default);">Spring Certified Professional (Spring Boot 3)</h4>
                <p style="font-size: 13px; line-height: 1.5; color: var(--color-fg-subtle); margin-bottom: 12px;">
                  <strong>Credencial Oficial Credly</strong>: Acredita la capacidad de diseñar, construir y desplegar aplicaciones empresariales listas para producción con Spring Boot 3.
                </p>
                <div style="font-size: 12px; color: var(--color-fg-muted); margin-bottom: 14px;">
                  <strong>Temas Evaluados:</strong>
                  <ul style="padding-left: 16px; margin-top: 4px; margin-bottom: 0;">
                    <li>Spring Core Container, IoC, Beans y Ciclo de Vida.</li>
                    <li>Acceso a datos con Spring Data JPA y Transacciones.</li>
                    <li>APIs RESTful con Spring MVC y ResponseEntity.</li>
                    <li>Seguridad con Spring Security 6 y JWT.</li>
                    <li>Testing automatizado con Spring Boot Test y Mockito.</li>
                  </ul>
                </div>
              </div>
              <a href="https://www.credly.com/org/vmware/badge/spring-certified-professional-2023" target="_blank" rel="noreferrer" class="btn-view-project" style="align-self: flex-start; margin-top: 10px;">
                Ver Credencial en Credly &rarr;
              </a>
            </div>

          </div>
        </article>

        <!-- BLOQUE 2: WEBS OFICIALES Y DOCUMENTACIÓN DE REFERENCIA -->
        <article class="resource-panel" style="margin-bottom: 30px;">
          <div class="resource-panel-header">
            <h3>🌐 Portales Oficiales y Documentación de Referencia</h3>
          </div>

          <p>
            Formarse con fuentes primarias garantiza consultar siempre especificaciones actualizadas, parches de seguridad y estándares de la industria:
          </p>

          <div class="resource-links-list">
            
            <a class="resource-link-card" href="https://spring.io/projects/spring-boot" target="_blank" rel="noreferrer">
              <span class="resource-link-title">🌱 Portal Oficial de Spring Boot (spring.io)</span>
              <span class="resource-link-meta">Documentación de referencia oficial, guías de migración y guías paso a paso (Spring Guides).</span>
            </a>

            <a class="resource-link-card" href="https://dev.java/" target="_blank" rel="noreferrer">
              <span class="resource-link-title">☕ Portal Oficial de Desarrolladores Java (dev.java)</span>
              <span class="resource-link-meta">El portal de Oracle para desarrolladores Java: tutoriales, especificaciones JEP y novedades de JDK 21/22.</span>
            </a>

            <a class="resource-link-card" href="https://bit.ly/4rpVj43" target="_blank" rel="noreferrer">
              <span class="resource-link-title">🎓 Oracle Learner Portal (MyLearn)</span>
              <span class="resource-link-meta">Plataforma oficial de aprendizaje de Oracle para formación y preparación de certificaciones Java SE.</span>
            </a>

            <a class="resource-link-card" href="https://jakarta.ee/" target="_blank" rel="noreferrer">
              <span class="resource-link-title">🏛️ Especificaciones Oficiales de Jakarta EE (jakarta.ee)</span>
              <span class="resource-link-meta">Documentación oficial de Jakarta Persistence (JPA 3.1), Jakarta Validation (3.0) y Jakarta Servlet (6.0).</span>
            </a>

            <a class="resource-link-card" href="https://academy.spring.io/" target="_blank" rel="noreferrer">
              <span class="resource-link-title">🎓 Spring Academy</span>
              <span class="resource-link-meta">Plataforma oficial de aprendizaje de VMware con cursos interactivos orientados a la certificación oficial.</span>
            </a>

            <a class="resource-link-card" href="https://www.baeldung.com/" target="_blank" rel="noreferrer">
              <span class="resource-link-title">📘 Baeldung — Java & Spring Tutorials</span>
              <span class="resource-link-meta">La mayor biblioteca de guías técnicas prácticas y patrones de diseño reales en Spring Boot.</span>
            </a>

            <a class="resource-link-card" href="https://www.sonarsource.com/products/sonarqube/" target="_blank" rel="noreferrer">
              <span class="resource-link-title">🛡️ SonarSource / SonarQube Official</span>
              <span class="resource-link-meta">Reglas y estándares oficiales de análisis estático de código, seguridad OWASP y calidad Java.</span>
            </a>

          </div>
        </article>

        <!-- BLOQUE 3: PLATAFORMAS DE FORMACIÓN Y PRÁCTICA DE CÓDIGO -->
        <article class="resource-roadmap-panel resource-panel">
          <div class="resource-panel-header">
            <h3>🎓 Plataformas de Formación Profesional y Práctica</h3>
          </div>

          <div class="roadmap-grid">
            <div class="roadmap-level roadmap-level-beginner">
              <h4>Cursos Estructurados</h4>
              <ul>
                <li><a href="https://www.udemy.com/courses/search/?q=spring%20boot%203" target="_blank" rel="noreferrer">Udemy: Spring Boot 3 & Microservicios</a></li>
                <li><a href="https://www.pluralsight.com/paths/spring-framework" target="_blank" rel="noreferrer">Pluralsight: Spring Framework Skill Path</a></li>
                <li><a href="https://www.coursera.org/search?query=java%20spring" target="_blank" rel="noreferrer">Coursera: Rutas Universitarias Java</a></li>
              </ul>
            </div>

            <div class="roadmap-level roadmap-level-intermediate">
              <h4>Práctica de Algoritmos</h4>
              <ul>
                <li><a href="https://leetcode.com/problemset/all/?search=java" target="_blank" rel="noreferrer">LeetCode (Track de Java)</a></li>
                <li><a href="https://www.hackerrank.com/domains/java" target="_blank" rel="noreferrer">HackerRank (Java Domain)</a></li>
                <li><a href="https://www.codewars.com/?language=java" target="_blank" rel="noreferrer">CodeWars (Katas de Java)</a></li>
              </ul>
            </div>

            <div class="roadmap-level roadmap-level-advanced">
              <h4>Portafolio y Empleabilidad</h4>
              <ul>
                <li><a href="https://education.github.com/pack" target="_blank" rel="noreferrer">GitHub Student Developer Pack</a></li>
                <li><a href="https://www.credly.com" target="_blank" rel="noreferrer">Credly: Plataforma de Insignias Oficiales</a></li>
                <li><a href="https://owasp.org/www-project-top-ten/" target="_blank" rel="noreferrer">OWASP Top 10 Security Risks</a></li>
              </ul>
            </div>
          </div>
        </article>

      </section>
    </div>
  </div>
</main>

<?php include_once __DIR__ . '/components/footer.php'; ?>
