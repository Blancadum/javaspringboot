<?php
  $in_bloque_context = true;
  include_once __DIR__ . "/../components/header.php";
  include_once __DIR__ . "/../components/sidebar.php";
?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- BLOQUE 2: ARQUITECTURA LIMPIA Y CORE SPRING BOOT -->
          <section id="fase-2" class="study-section">
            <h2>Bloque 2: Arquitectura Limpia y Core de Spring Boot</h2>

            <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
            <div class="block-intro-layout">
              <div class="block-summary-side">
                <div class="block-summary-card" style="margin-top: 0; background: var(--color-canvas-default); border: 1px solid var(--color-border-muted); border-radius: 8px; padding: 20px;">
                    <h4 style="margin-top: 0; color: var(--color-accent);">🚀 Visión General del Bloque</h4>
                    <p style="font-size: 14px; line-height: 1.6; color: var(--color-fg-subtle);">
                        El Bloque 2 es el corazón arquitectónico de la aplicación. Pasamos de la teoría a la estructura real, implementando una <strong>Arquitectura en Capas</strong> que separa la web, la lógica de negocio y la persistencia.
                        <br><br>
                        Aprenderemos cómo Spring Boot "magia" la configuración mediante la <strong>Autoconfiguración</strong>, cómo exponer servicios robustos mediante <strong>REST Controllers</strong> y cómo garantizar la integridad de los datos utilizando el manejo de <strong>Transacciones ACID</strong>.
                    </p>
                </div>
              </div>

              <div class="block-intro-main">
                <h3 style="margin-top: 0;">Objetivos de Aprendizaje — Bloque 2</h3>
                <div class="study-checks-grid">
                    <study-check id="f2_t1">Aplicar principios SOLID al diseño de clases backend.</study-check>
                    <study-check id="f2_t2">Entender el mecanismo de Autoconfiguración de Spring Boot.</study-check>
                    <study-check id="f2_t3">Implementar Controladores REST con ResponseEntity semántica.</study-check>
                    <study-check id="f2_t4">Aislar la lógica de negocio en la capa @Service.</study-check>
                    <study-check id="f2_t5">Modelar entidades JPA con mapeos ORM avanzados.</study-check>
                    <study-check id="f2_t6">Gestionar transacciones ACID mediante @Transactional.</study-check>
                </div>

              </div>
            </div>

            <div class="block-flow-container" style="display: flex; align-items: center; justify-content: space-between; margin: 25px 0; padding: 15px; background: var(--color-canvas-subtle); border-radius: 10px; border: 1px dashed var(--color-border-muted); font-size: 13px; text-align: center;">
                <div style="flex: 1;"><strong>1. Diseño</strong><br>SOLID & Capas</div>
                <div style="padding: 0 10px; color: var(--color-fg-subtle);">➔</div>
                <div style="flex: 1;"><strong>2. Exposición</strong><br>REST & MVC</div>
                <div style="padding: 0 10px; color: var(--color-fg-subtle);">➔</div>
                <div style="flex: 1;"><strong>3. Lógica</strong><br>Servicios & Tx</div>
                <div style="padding: 0 10px; color: var(--color-fg-subtle);">➔</div>
                <div style="flex: 1;"><strong>4. Datos</strong><br>JPA & ORM</div>
            </div>

            <div class="block-topic-cluster">
              <div class="block-topic-cluster-header">
                <h3>Temas del bloque</h3>
              </div>
              <div class="block-topic-cluster-grid">
                <a class="block-topic-card" href="<?php echo $base_url; ?>core-spring-boot/solid-capas"><span>5</span> SOLID y capas</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>core-spring-boot/rest-responseentity"><span>6</span> REST y ResponseEntity</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>core-spring-boot/servicios-di"><span>7</span> Servicios y DI</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>core-spring-boot/hibernate-orm"><span>8</span> Hibernate y ORM</a>
              </div>
            </div>

            <figure class="block-summary-figure">
              <img src="<?php echo $base_url; ?>img/FASE2.png" alt="Fase 2: Arquitectura Limpia y Core de Spring Boot">
              <figcaption>Figura 3: Diseño en capas y Core de Spring Boot</figcaption>
            </figure>
        <div class="block-quick-ref" style="margin: 30px 0; padding: 20px; background: var(--color-canvas-subtle); border-left: 5px solid var(--color-accent); border-radius: 0 8px 8px 0;">
            <h4 style="margin-top: 0; display: flex; align-items: center; gap: 10px; color: var(--color-fg-default);">
                <span>⌨️</span> Quick-Reference: Anotaciones Core
            </h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-family: monospace; font-size: 12px; color: var(--color-fg-default);">
                <div>
                    <strong style="color: var(--color-accent);">Web & Core</strong>
                    <ul style="list-style: none; padding-left: 0; margin-top: 10px;">
                        <li><code class="kw">@RestController</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(API JSON)</span></li>
                        <li><code class="kw">@RequestMapping</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Rutas base)</span></li>
                        <li><code class="kw">@SpringBootApplication</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Arranque)</span></li>
                        <li><code class="kw">@Value</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Propiedades)</span></li>
                    </ul>
                </div>
                <div>
                    <strong style="color: accent;">Lógica & Datos</strong>
                    <ul style="list-style: none; padding-left: 0; margin-top: 10px;">
                        <li><code class="kw">@Service</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Lógica negocio)</span></li>
                        <li><code class="kw">@Transactional</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(ACID/Rollback)</span></li>
                        <li><code class="kw">@Entity</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(Mapeo DB)</span></li>
                        <li><code class="kw">@Id / @GeneratedValue</code> <span style="color: var(--color-fg-subtle); font-style: italic;">(PK)</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- TABLA DE CONCEPTOS CLAVE DEL BLOQUE 2 -->
        <div class="block-concepts-box">
          <h4>⚙️ Conceptos Clave del Bloque 2 — Arquitectura Limpia y Core de Spring Boot</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Principios SOLID</strong></td>
                <td>
                  Cinco pilares de la programación orientada a objetos (Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion) para lograr código desacoplado y mantenible.<br>
                  <em>Ejemplo</em>: Invertir dependencias inyectando la interfaz <code class="kw">PasarelaPago</code> en lugar de instanciar la clase concreta <code class="kw">StripePasarela</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Autoconfiguración de Spring Boot</strong></td>
                <td>
                  Mecanismo inteligente (<code class="ann">@EnableAutoConfiguration</code>) que infiere y registra automáticamente beans de infraestructura evaluando librerías en el classpath mediante anotaciones como <code class="ann">@ConditionalOnClass</code>.<br>
                  <em>Ejemplo</em>: Incluir <code class="kw">spring-boot-starter-web</code> autoconfigura el servidor embebido Tomcat, Jackson y el <code class="kw">DispatcherServlet</code> en el puerto 8080 sin XML.
                </td>
              </tr>
              <tr>
                <td><strong>Ciclo del DispatcherServlet</strong></td>
                <td>
                  Front Controller central de Spring MVC: intercepta todas las peticiones HTTP, consulta el <code class="kw">HandlerMapping</code> para hallar el controlador, resuelve argumentos con <code class="kw">HandlerAdapter</code> y serializa la respuesta.<br>
                  <em>Ejemplo</em>: <code class="kw">GET /api/v1/libros/5</code> &rarr; <code class="kw">DispatcherServlet</code> enruta a <code class="kw">LibroController.buscarPorId(5)</code> y serializa el retorno a JSON.
                </td>
              </tr>
              <tr>
                <td><strong>Controladores REST (@RestController y ResponseEntity)</strong></td>
                <td>
                  <code class="ann">@RestController</code> combina <code class="ann">@Controller</code> y <code class="ann">@ResponseBody</code> para emitir datos JSON directamente. <code class="kw">ResponseEntity&lt;T&gt;</code> permite controlar el código de estado semántico y cabeceras de red.<br>
                  <em>Ejemplo</em>: <code class="kw">return ResponseEntity.created(URI.create("/api/libros/" + id)).body(nuevoLibro);</code> (devuelve <code class="kw">201 Created</code> con cabecera <code class="kw">Location</code>).
                </td>
              </tr>
              <tr>
                <td><strong>Inyección por Constructor en Servicios</strong></td>
                <td>
                  Patrón recomendado de inyección de dependencias declarando campos <code class="kw">private final</code> inicializados por constructor. Garantiza inmutabilidad y facilita pruebas unitarias sin Spring.<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="kw">public LibroService(LibroRepository repo) { this.repo = repo; }</code> evita la fragilidad de <code class="ann">@Autowired</code> sobre campos privados.
                </td>
              </tr>
              <tr>
                <td><strong>Transacciones ACID (@Transactional)</strong></td>
                <td>
                  Garantía de Atomicidad, Consistencia, Aislamiento y Durabilidad en operaciones de persistencia. Ante cualquier <code class="kw">RuntimeException</code> no capturada, el aspecto intercepta y revierte (<em>rollback</em>) los cambios.<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="ann">@Transactional public void prestarLibro(...) { verificarDisponibilidad(); registrarPrestamo(); descontarEjemplar(); }</code> (si falla el registro del préstamo, el stock se revierte íntegrame).
                </td>
              </tr>
              <tr>
                <td><strong>Acceso a Datos (JDBC, JdbcTemplate y DataAccessException)</strong></td>
                <td>
                  Evolución histórica: JDBC clásico (gestión manual), <code class="kw">JdbcTemplate</code> (patrón Template, <code class="kw">RowMapper</code> tipado) y la jerarquía unificada de excepciones <code class="kw">DataAccessException</code> (desacoplada del proveedor de BD).<br>
                  <em>Ejemplo</em>: <code class="kw">jdbcTemplate.query("SELECT * FROM libros WHERE id = ?", rowMapper, id)</code> traduce automáticamente errores SQL nativos a excepciones runtime de Spring.
                </td>
              </tr>
              <tr>
                <td><strong>Arquitectura Hibernate (SessionFactory / Session)</strong></td>
                <td>
                  <code class="kw">SessionFactory</code> (Singleton global, en JPA: <code class="kw">EntityManagerFactory</code>) almacena metadatos y pool de conexiones. <code class="kw">Session</code> (alcance por hilo/transacción, en JPA: <code class="kw">EntityManager</code>) gestiona la Caché L1 y el Contexto de Persistencia.
                </td>
              </tr>
              <tr>
                <td><strong>Clases Mapeadas (@Entity, @Table, @Embeddable)</strong></td>
                <td>
                  Mapeo declarativo ORM: <code class="ann">@Entity</code> declara persistencia con clave primaria (<code class="ann">@Id</code>); <code class="ann">@Table</code> define el nombre físico; y <code class="ann">@Embeddable</code> declara objetos de valor incrustados como columnas en la entidad propietaria (<code class="ann">@Embedded</code>).<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="ann">@Embedded DimensionesLibro dimensiones</code> mapea <code class="kw">alto_cm</code>, <code class="kw">ancho_cm</code> y <code class="kw">peso_gramos</code> directamente en la tabla <code class="kw">libros</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Ciclo de Vida de Objetos JPA (4 Estados)</strong></td>
                <td>
                  Estados de una entidad frente al <code class="kw">EntityManager</code>: <strong>Transient</strong> (nueva en memoria), <strong>Managed</strong> (rastreada con <em>dirty checking</em> automático), <strong>Detached</strong> (sesión cerrada) y <strong>Removed</strong> (pendiente de borrado SQL).
                </td>
              </tr>
              <tr>
                <td><strong>Mapeo de Herencia (@Inheritance)</strong></td>
                <td>
                  Estrategias para modelar polimorfismo en SQL: <code class="kw">SINGLE_TABLE</code> (una sola tabla con discriminador), <code class="kw">JOINED</code> (tabla base y tablas derivadas unidas por FK) y <code class="kw">TABLE_PER_CLASS</code> (tablas independientes).<br>
                  <em>Ejemplo en BiblioTech</em>: <code class="ann">@Inheritance(strategy = InheritanceType.JOINED) public abstract class Publicacion {}</code> con hijas <code class="kw">LibroFisico</code> y <code class="kw">LibroDigital</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Operaciones CRUD con Spring Data JPA</strong></td>
                <td>
                  Abstracción que implementa automáticamente Create, Read, Update y Delete al heredar de <code class="kw">JpaRepository&lt;Entidad, ID&gt;</code> sin escribir código SQL ni implementaciones manuales.<br>
                  <em>Ejemplo</em>: <code class="kw">libroRepository.save(libro)</code>, <code class="kw">libroRepository.findById(id)</code>, <code class="kw">libroRepository.deleteById(id)</code> y <code class="kw">libroRepository.findAll()</code>.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div> <!-- Fin de content-main -->
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
