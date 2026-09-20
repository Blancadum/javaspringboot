<?php include_once __DIR__ . '/components/header.php'; ?>
<?php include_once __DIR__ . '/components/sidebar.php'; ?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- RUTA DE APRENDIZAJE Y ARQUITECTURA DEL CONTENIDO -->
          <section id="ruta-aprendizaje" class="study-section">
            <h2>Estructura y Ruta de Aprendizaje</h2>
            <p>
              El contenido está organizado de forma progresiva en <strong>6 Bloques Temáticos</strong> y <strong>15 Temas</strong> que cubren desde los fundamentos del protocolo HTTP y la Inversión de Control (IoC), hasta la arquitectura en capas, persistencia avanzada, testing automatizado y despliegue con Docker.
            </p>

            <table>
              <thead>
                <tr>
                  <th>Bloque</th>
                  <th>Temas Incluidos</th>
                  <th>Enfoque Técnico y Competencias Clave</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>Bloque 1</strong><br><a href="<?php echo $base_url; ?>fundamentos#fase-1" class="gh-badge primary">Fundamentos</a></td>
                  <td>Tema 1 a 4</td>
                  <td>Arquitectura Web (MPA vs SPA), protocolo HTTP/HTTPS, serialización JSON con Jackson, ciclo de vida Maven, Lombok, Records, Inversión de Control (IoC), Contenedor de Beans y Desarrollo Basado en Aspectos (Spring AOP).</td>
                </tr>
                <tr>
                  <td><strong>Bloque 2</strong><br><a href="<?php echo $base_url; ?>core-spring-boot#fase-2" class="gh-badge success">Core Spring Boot</a></td>
                  <td>Tema 5 a 8</td>
                  <td>Principios SOLID, autoconfiguración, ciclo del DispatcherServlet en Spring MVC, controladores REST, transacciones ACID, arquitectura Hibernate (SessionFactory/Session), clases mapeadas (@Embeddable), ciclo de vida de objetos (4 estados), mapeo de herencia (@Inheritance) y operaciones CRUD.</td>
                </tr>
                <tr>
                  <td><strong>Bloque 3</strong><br><a href="<?php echo $base_url; ?>persistencia-dtos#fase-3" class="gh-badge attention">Persistencia & DTOs</a></td>
                  <td>Tema 9 y 10</td>
                  <td>Mapeo de asociaciones (<code>@OneToOne</code>, <code>@OneToMany</code>, <code>@ManyToOne</code>, <code>@ManyToMany</code> con tablas de unión), consultas avanzadas (JPQL, SQL nativo, Criteria API), optimización en Hibernate (solución N+1 con <code>JOIN FETCH</code>, <code>@EntityGraph</code>, Caché L1/L2, batching) y desacoplamiento con DTOs.</td>
                </tr>
                <tr>
                  <td><strong>Bloque 4</strong><br><a href="<?php echo $base_url; ?>calidad-ops#fase-4" class="gh-badge attention">Calidad & Operaciones</a></td>
                  <td>Tema 11 y 12</td>
                  <td>Validaciones declarativas (Bean Validation), manejo global de excepciones, observabilidad con SLF4J, perfiles, documentación OpenAPI, monitoreo con Spring Boot Actuator y consumo de APIs con RestClient.</td>
                </tr>
                <tr>
                  <td><strong>Bloque 5</strong><br><a href="<?php echo $base_url; ?>testing#fase-5" class="gh-badge done">Testing Automatizado</a></td>
                  <td>Tema 13 y 14</td>
                  <td>Pirámide de testing, pruebas unitarias con JUnit 5 y Mockito, pruebas de integración web con <code>@WebMvcTest</code> / <code>@SpringBootTest</code>, y técnicas profesionales de depuración y diagnóstico.</td>
                </tr>
                <tr>
                  <td><strong>Bloque 6</strong><br><a href="<?php echo $base_url; ?>seguridad-docker#fase-6" class="gh-badge danger">Seguridad & Docker</a></td>
                  <td>Tema 15</td>
                  <td>Seguridad stateless con JWT, hashing seguro con BCrypt, control RBAC (<code>@PreAuthorize</code>), contenedorización Docker multi-stage y microservicios síncronos vs asíncronos (Kafka / RabbitMQ).</td>
                </tr>
              </tbody>
            </table>
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
