<?php
  $in_bloque_context = true;
  include_once __DIR__ . "/../components/header.php";
  include_once __DIR__ . "/../components/sidebar.php";
?>



    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- BLOQUE 3: PERSISTENCIA AVANZADA Y DTOS -->
          <section id="fase-3" class="study-section">
            <h2>Bloque 3: Persistencia Avanzada y DTOs</h2>

            <!-- VISION GENERAL IZQUIERDA / OBJETIVOS DERECHA / IMAGEN DEBAJO CENTRADA -->
            <div class="block-intro-layout">
              <div class="block-summary-side">
                <div class="block-summary-card">
                    <h4 class="block-summary-title">🚀 Visión General del Bloque</h4>
                    <p class="block-summary-text">
                        En este bloque saltamos de la persistencia básica a la <strong>Persistencia de Grado Empresarial</strong>. No basta con guardar datos; debemos hacerlo de forma eficiente y segura.
                        <br><br>
                        Aprenderemos a modelar relaciones complejas entre entidades, a optimizar el acceso a datos para evitar el colapso del servidor (Problema N+1) y a utilizar el <strong>Patrón DTO</strong> para que nuestra API sea profesional y segura.
                        <br><br>
                        Finalmente, cerramos el ciclo implementando una estrategia de <strong>Testing automatizado</strong>, asegurando que cada cambio en la persistencia o los DTOs no rompa la aplicación.
                    </p>
                </div>
              </div>

              <div class="block-intro-main">
                <h3 class="block-intro-heading">Objetivos de Aprendizaje — Bloque 3</h3>
                <div class="study-checks-grid">
                    <study-check id="f3_t1">Configurar relaciones bidireccionales con mappedBy y CascadeType.</study-check>
                    <study-check id="f3_t2">Optimizar el rendimiento eliminando el problema N+1 con JOIN FETCH.</study-check>
                    <study-check id="f3_t3">Escribir consultas potentes usando JPQL y SQL Nativo.</study-check>
                    <study-check id="f3_t4">Implementar el patrón DTO para blindar la API de la base de datos.</study-check>
                    <study-check id="f3_t5">Validar la lógica de negocio mediante Pruebas Unitarias y de Integración.</study-check>
                </div>

              </div>
            </div>

            <div class="block-flow-container">
                <div class="block-flow-item"><strong>1. Relaciones</strong><br>ORM & Mapping</div>
                <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
                <div class="block-flow-item"><strong>2. Consultas</strong><br>JPQL & SQL</div>
                <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
                <div class="block-flow-item"><strong>3. Transferencia</strong><br>DTOs & Records</div>
                <div class="block-flow-separator"><span class="flow-arrow-horiz">➔</span><span class="flow-arrow-vert">⬇</span></div>
                <div class="block-flow-item"><strong>4. Calidad</strong><br>JUnit & Mockito</div>
            </div>

            <div class="block-topic-cluster">
              <div class="block-topic-cluster-header">
                <h3>Temas del bloque</h3>
              </div>
              <div class="block-topic-cluster-grid">
                <a class="block-topic-card" href="<?php echo $base_url; ?>persistencia-dtos/asociaciones-consultas"><span>11</span> Asociaciones y consultas</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>persistencia-dtos/dtos-repositorios"><span>12</span> DTOs y repositorios</a>
                <a class="block-topic-card" href="<?php echo $base_url; ?>persistencia-dtos/mapstruct-specifications"><span>13</span> MapStruct & Specifications</a>
              </div>
            </div>

            <figure class="block-summary-figure">
              <img src="<?php echo $base_url; ?>img/FASE3.png" alt="Fase 3: Persistencia Avanzada y DTOs">
              <figcaption>Figura 4: Persistencia Avanzada y DTOs</figcaption>
            </figure>
        <div class="block-quick-ref">
            <h4 class="block-quick-ref-title">
                <span>⌨️</span> Quick-Reference: Optimización y Calidad
            </h4>
            <div class="quick-ref-grid">
                <div class="quick-ref-col">
                    <strong>JPA & Hibernate</strong>
                    <ul class="quick-ref-list">
                        <li><code class="kw">JOIN FETCH l.libros</code> <span class="quick-ref-comment">(Cura el N+1)</span></li>
                        <li><code class="kw">mappedBy = "autor"</code> <span class="quick-ref-comment">(Lado inverso)</span></li>
                        <li><code class="kw">CascadeType.ALL</code> <span class="quick-ref-comment">(Propagación)</span></li>
                        <li><code class="kw">FetchType.LAZY</code> <span class="quick-ref-comment">(Carga perezosa)</span></li>
                    </ul>
                </div>
                <div class="quick-ref-col">
                    <strong>Testing & QA</strong>
                    <ul class="quick-ref-list">
                        <li><code class="kw">@Test</code> <span class="quick-ref-comment">(Método de prueba)</span></li>
                        <li><code class="kw">@Mock / @InjectMocks</code> <span class="quick-ref-comment">(Aislamiento)</span></li>
                        <li><code class="kw">assertEquals(exp, act)</code> <span class="quick-ref-comment">(Validación)</span></li>
                        <li><code class="kw">@DataJpaTest</code> <span class="quick-ref-comment">(Slicing de datos)</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- TABLA DE CONCEPTOS CLAVE DEL BLOQUE 3 -->
        <div class="block-concepts-box">
          <h4>🗄️ Conceptos Clave del Bloque 3 — Persistencia Avanzada y DTOs</h4>
          <table>
            <thead>
              <tr>
                <th style="width: 28%;">Concepto</th>
                <th style="width: 72%;">Definición Técnica y Ejemplo Práctico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Mapeo de Asociaciones (@OneToMany, @ManyToOne, etc.)</strong></td>
                <td>
                  Representación orientada a objetos de claves foráneas relacionales. En asociaciones bidireccionales, el lado con la clave foránea física define <code class="kw">@JoinColumn</code> (lado propietario) y el lado inverso especifica <code class="kw">mappedBy</code> para no duplicar columnas.<br>
                  <em>Ejemplo</em>: <code class="kw">@OneToMany(mappedBy = "departamento", cascade = CascadeType.ALL, orphanRemoval = true) private List&lt;Empleado&gt; empleados;</code>.
                  <em>Ejemplo</em>: En BiblioTech, <code class="kw">@OneToMany(mappedBy = "autor", cascade = CascadeType.ALL, orphanRemoval = true) private List&lt;Libro&gt; libros;</code> vincula al autor con todas sus obras en cascada.
                </td>
              </tr>
              <tr>
                <td><strong>Consultas Avanzadas (JPQL, SQL Nativo y Criteria API)</strong></td>
                <td>
                  <strong>JPQL</strong> consulta sobre entidades de dominio (<code class="kw">SELECT l FROM Libro l WHERE l.precio &gt; :p</code>); <strong>SQL Nativo</strong> (<code class="kw">nativeQuery = true</code>) envía sentencias directas al motor SQL; y <strong>Criteria API</strong> construye consultas programáticas y tipadas en tiempo de compilación.<br>
                  <em>Ejemplo</em>: <code class="kw">@Query("SELECT e FROM Empleado e WHERE e.salario &gt;= :min") List&lt;Empleado&gt; findPorSalario(@Param("min") Double min);</code>
                  <em>Ejemplo</em>: <code class="kw">@Query("SELECT l FROM Libro l WHERE l.precio &gt;= :min") List&lt;Libro&gt; findPorPrecioMinimo(@Param("min") BigDecimal min);</code>
                </td>
              </tr>
              <tr>
                <td><strong>Optimización en Hibernate (Solución N+1 con JOIN FETCH)</strong></td>
                <td>
                  El antipatrón N+1 surge al cargar N entidades y disparar N consultas secundarias individuales para leer sus relaciones perezosas (<code class="kw">FetchType.LAZY</code>). Se resuelve forzando un único viaje a la BD mediante <code class="kw">JOIN FETCH</code> o grafos <code class="kw">@EntityGraph</code>.<br>
                  <em>Ejemplo</em>: <code class="kw">SELECT a FROM Autor a JOIN FETCH a.libros</code> reduce 101 consultas SQL automáticas a una única sentencia con <code class="kw">LEFT JOIN</code>.
                </td>
              </tr>
              <tr>
                <td><strong>Caché L1 y L2, Batching</strong></td>
                <td>
                  Niveles de optimización: <strong>Caché L1</strong> (nivel de sesión/transacción, evita re-consultar la misma entidad); <strong>Caché L2</strong> (global entre sesiones, ej. Redis); y <strong>Batching</strong> (agrupa inserciones/actualizaciones en lotes de red con <code class="kw">hibernate.jdbc.batch_size=50</code>).<br>
                  <em>Ejemplo</em>: Guardar 500 entidades con batch de 50 genera únicamente 10 viajes de red TCP a la base de datos en vez de 500.
                  <em>Ejemplo en BiblioTech</em>: Importar un catálogo de 500 libros con batch de 50 genera únicamente 10 viajes de red TCP a PostgreSQL en vez de 500.
                </td>
              </tr>
              <tr>
                <td><strong>Desacoplamiento con el Patrón DTO</strong></td>
                <td>
                  Separación estricta entre las entidades de la base de datos y los contratos públicos de la API. Impide la exposición no autorizada de campos sensibles (hashes, claves internas) y corta de raíz los bucles recursivos de serialización JSON.<br>
                  <em>Ejemplo</em>: Entidad <code class="kw">Usuario</code> tiene <code class="kw">passwordHash</code>; el endpoint retorna <code class="kw">UsuarioDTO(id, nombre, email)</code> sin exponer credenciales.
                  <em>Ejemplo en BiblioTech</em>: La entidad de socios <code class="kw">Usuario</code> contiene <code class="kw">passwordHash</code>; el endpoint retorna un record inmutable <code class="kw">UsuarioResponseDTO(id, nombre, email)</code> sin exponer credenciales.
                </td>
              </tr>
              <tr>
                <td><strong>Java Records como DTOs Inmutables</strong></td>
                <td>
                  Implementación compacta e inmutable de objetos de transferencia en Java 16+. Son seguros en entornos concurrentes, generan automáticamente métodos de acceso directo y se integran sin configuración con Jackson.<br>
                  <em>Ejemplo</em>: <code class="kw">public record PedidoResumenDTO(Long id, BigDecimal importe, String estado) {}</code>.
                  <em>Ejemplo</em>: <code class="kw">public record LibroResumenDTO(Long id, String titulo, BigDecimal precio) {}</code>.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div> <!-- Fin de content-main -->
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
