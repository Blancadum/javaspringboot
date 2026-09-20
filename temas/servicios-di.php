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

<article id="tema-7">
          <h3>7 — Capa de Servicio e Inyección por Constructor</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">7. Service Layer</div>
            <a href="#tema-7-servicio" class="topic-dropdown-item"><span class="item-num">7.1</span> <span class="item-title">Responsabilidad de la Capa @Service</span></a>
            <a href="#tema-7-inyeccion" class="topic-dropdown-item"><span class="item-num">7.2</span> <span class="item-title">Inyección de Dependencias por Constructor</span></a>
            <a href="#tema-7-transacciones" class="topic-dropdown-item"><span class="item-num">7.3</span> <span class="item-title">Gestión Declarativa de Transacciones (@Transactional)</span></a>
            <a href="#tema-7-transacciones-avanzadas" class="topic-dropdown-item"><span class="item-num">7.4</span> <span class="item-title">Transacciones ACID: Propagación y Rollback</span></a>
            <a href="#tema-7-acceso-datos" class="topic-dropdown-item"><span class="item-num">7.5</span> <span class="item-title">Acceso a Datos: De JDBC y JdbcTemplate a JPA</span></a>
          </div>
        </details>

          <p class="topic-intro">
            La capa de servicio encapsula las reglas de negocio del sistema de forma independiente de los detalles de entrega HTTP o persistencia SQL. En este tema dominarás la inyección por constructor de dependencias inmutables, el desacoplamiento con DTOs y la gestión transaccional declarativa con <code class="ann">@Transactional</code> (propiedades ACID y modos de propagación).
          </p>

          <h4 id="tema-7-servicio">7.1 Responsabilidad de la Capa @Service</h4>
          <p>
            La capa <code class="ann">@Service</code> concentra las reglas de negocio, políticas operativas y coordinación entre repositorios, manteniéndose completamente aislada de la capa web.
          </p>

          <h4 id="tema-7-inyeccion">7.2 Inyección de Dependencias por Constructor</h4>
          <p>
            Debe recibir sus dependencias exclusivamente por <strong>constructor</strong>, facilitando el testing unitario con dobles (mocks) y garantizando la inmutabilidad de referencias.
          </p>

          <h4 id="tema-7-transacciones">7.3 Gestión Declarativa de Transacciones (@Transactional)</h4>
          <p>
            La anotación <code class="ann">@Transactional(readOnly = true)</code> optimiza lecturas en la base de datos, mientras que en métodos mutacionales asegura la atomicidad y rollback automático ante excepciones.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.service;

<span class="kw">import</span> com.bibliotech.dto.*;
<span class="kw">import</span> com.bibliotech.entity.<span class="typ">Libro</span>;
<span class="kw">import</span> com.bibliotech.repository.<span class="typ">LibroRepository</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> org.springframework.transaction.annotation.<span class="typ">Transactional</span>;
<span class="kw">import</span> java.util.<span class="typ">List</span>;

<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">LibroService</span> {

    <span class="kw">private final</span> <span class="typ">LibroRepository</span> libroRepository;

    <span class="cmt">// Inyección obligatoria por constructor (SOLID: Inversión de Dependencias)</span>
    <span class="kw">public</span> <span class="fn">LibroService</span>(<span class="typ">LibroRepository</span> libroRepository) {
        <span class="kw">this</span>.libroRepository = libroRepository;
    }

    <span class="ann">@Transactional</span>(readOnly = <span class="kw">true</span>)
    <span class="kw">public</span> <span class="typ">List</span>&lt;<span class="typ">LibroResponseDTO</span>&gt; <span class="fn">obtenerTodos</span>() {
        <span class="kw">return</span> libroRepository.<span class="fn">findAll</span>().<span class="fn">stream</span>()
                .<span class="fn">map</span>(l -&gt; <span class="kw">new</span> <span class="typ">LibroResponseDTO</span>(l.<span class="fn">getId</span>(), l.<span class="fn">getTitulo</span>(), l.<span class="fn">getPrecio</span>()))
                .<span class="fn">toList</span>();
    }

    <span class="ann">@Transactional</span>
    <span class="kw">public</span> <span class="typ">LibroResponseDTO</span> <span class="fn">guardar</span>(<span class="typ">LibroRequestDTO</span> dto) {
        <span class="typ">Libro</span> entidad = <span class="kw">new</span> <span class="typ">Libro</span>(<span class="kw">null</span>, dto.<span class="fn">isbn</span>(), dto.<span class="fn">titulo</span>(), dto.<span class="fn">precio</span>(), <span class="str">"BiblioTech Press"</span>);
        <span class="typ">Libro</span> guardado = libroRepository.<span class="fn">save</span>(entidad);
        <span class="kw">return</span> <span class="kw">new</span> <span class="typ">LibroResponseDTO</span>(guardado.<span class="fn">getId</span>(), guardado.<span class="fn">getTitulo</span>(), guardado.<span class="fn">getPrecio</span>());
    }

    <span class="ann">@Transactional</span>
    <span class="kw">public void</span> <span class="fn">borrar</span>(<span class="typ">Long</span> id) {
        libroRepository.<span class="fn">deleteById</span>(id);
    }
}</code></pre>
          </code-block>
          <h4 id="tema-7-transacciones-avanzadas">7.4 Transacciones Empresariales: Propiedades ACID, Propagación y Rollback</h4>
          <p>
            En la capa de servicio se demarcan los límites transaccionales declarativos mediante <code class="ann">@Transactional</code> para garantizar las propiedades <strong>ACID</strong> (Atomicidad, Consistencia, Aislamiento y Durabilidad):
          </p>
          <ul>
            <li><strong>Propagation.REQUIRED (por defecto)</strong>: Se ejecuta dentro de la transacción activa; si no existe ninguna, crea una nueva.</li>
            <li><strong>Propagation.REQUIRES_NEW</strong>: Suspende cualquier transacción previa y abre una transacción independiente obligatoria (ideal para logs de auditoría que deben persistir incluso si la transacción principal falla).</li>
            <li><strong>Reglas de Rollback (rollbackFor)</strong>: Por defecto, Spring solo ejecuta rollback ante excepciones no comprobadas (subclases de <code class="kw">RuntimeException</code>). Para excepciones comprobadas (<code class="kw">checked Exception</code>), es imperativo indicar <code class="kw">rollbackFor = Exception.class</code>.</li>
            <li><strong>Optimización de Lectura</strong>: Anotar con <code class="ann">@Transactional(readOnly = true)</code> en consultas desactiva el dirty checking de Hibernate en memoria, reduciendo consumo de CPU.</li>
          </ul>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.service;

<span class="kw">import</span> com.bibliotech.entity.<span class="typ">Libro</span>;
<span class="kw">import</span> com.bibliotech.entity.<span class="typ">PrestamoLibro</span>;
<span class="kw">import</span> com.bibliotech.repository.<span class="typ">LibroRepository</span>;
<span class="kw">import</span> com.bibliotech.repository.<span class="typ">PrestamoRepository</span>;
<span class="kw">import</span> com.bibliotech.exception.<span class="typ">LibroNotFoundException</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> org.springframework.transaction.annotation.<span class="typ">Propagation</span>;
<span class="kw">import</span> org.springframework.transaction.annotation.<span class="typ">Transactional</span>;
<span class="kw">import</span> java.time.LocalDate;

<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">PrestamoLibroService</span> {

    <span class="kw">private final</span> <span class="typ">LibroRepository</span> libroRepo;
    <span class="kw">private final</span> <span class="typ">PrestamoRepository</span> prestamoRepo;
    <span class="kw">private final</span> <span class="typ">AuditoriaPrestamoService</span> auditoriaService;

    <span class="kw">public</span> <span class="fn">PrestamoLibroService</span>(<span class="typ">LibroRepository</span> l, <span class="typ">PrestamoRepository</span> p, <span class="typ">AuditoriaPrestamoService</span> a) {
        <span class="kw">this</span>.libroRepo = l;
        <span class="kw">this</span>.prestamoRepo = p;
        <span class="kw">this</span>.auditoriaService = a;
    }

    <span class="ann">@Transactional</span>(propagation = <span class="typ">Propagation</span>.REQUIRED, rollbackFor = <span class="typ">Exception</span>.<span class="kw">class</span>)
    <span class="kw">public</span> <span class="typ">PrestamoLibro</span> <span class="fn">formalizarPrestamo</span>(<span class="typ">Long</span> libroId, <span class="typ">Long</span> lectorId) <span class="kw">throws</span> <span class="typ">Exception</span> {
        <span class="typ">Libro</span> libro = libroRepo.<span class="fn">findById</span>(libroId)
            .<span class="fn">orElseThrow</span>(() -&gt; <span class="kw">new</span> <span class="typ">LibroNotFoundException</span>(libroId));

        <span class="cmt">// 1. Descuenta el ejemplar disponible</span>
        libro.<span class="fn">decrementarEjemplares</span>();

        <span class="cmt">// 2. Crea el registro del préstamo</span>
        <span class="typ">PrestamoLibro</span> prestamo = <span class="kw">new</span> <span class="typ">PrestamoLibro</span>(<span class="kw">null</span>, <span class="typ">LocalDate</span>.<span class="fn">now</span>(), <span class="typ">LocalDate</span>.<span class="fn">now</span>().<span class="fn">plusDays</span>(14), lectorId, libro);
        <span class="typ">PrestamoLibro</span> guardado = prestamoRepo.<span class="fn">save</span>(prestamo);

        <span class="cmt">// 3. El servicio de auditoría utiliza REQUIRES_NEW para garantizar persistencia independiente</span>
        auditoriaService.<span class="fn">registrarOperacion</span>(<span class="str">"PRESTAMO_CONFIRMADO"</span>, libroId, lectorId);

        <span class="kw">return</span> guardado;
    }
}</code></pre>
          </code-block>

          <h4 id="tema-7-acceso-datos">7.5 Acceso a Datos en Spring: De JDBC Tradicional y JdbcTemplate a Spring Data JPA</h4>
          <p>
            Para comprender por qué Spring Data JPA revolucionó el desarrollo empresarial, es fundamental conocer la evolución de las técnicas de persistencia relacional en el ecosistema Java:
          </p>

          <ol>
            <li>
              <strong>El dolor del JDBC Tradicional (Java Database Connectivity)</strong>:<br>
              En los inicios de Java EE, interactuar con una base de datos requería escribir decenas de líneas repetitivas (<em>boilerplate</em>): abrir manualmente la conexión (<code class="kw">Connection</code>), compilar la sentencia (<code class="kw">PreparedStatement</code>), iterar el cursor (<code class="kw">ResultSet</code>) para extraer columna por columna a mano (<code class="kw">rs.getString("titulo")</code>) y cerrar obligatoriamente todos los recursos en bloques <code class="kw">finally</code> para no agotar el pool de conexiones. Además, JDBC arrojaba la excepción comprobada (<em>checked exception</em>) <code class="kw">java.sql.SQLException</code>, obligando a atraparla en cada método y acoplando el código de negocio a los códigos de error específicos de cada fabricante de base de datos (Oracle, MySQL, PostgreSQL).
            </li>
            <li>
              <strong>La solución de Spring Framework: <code class="kw">JdbcTemplate</code></strong>:<br>
              Spring introdujo el patrón de diseño <em>Template Method</em> mediante la clase <code class="kw">JdbcTemplate</code>. Spring se encarga de abrir la conexión del <code class="kw">DataSource</code>, compilar la sentencia SQL, mapear los tipos de datos, traducir excepciones y cerrar los recursos de forma transparente. Para convertir cada fila del <code class="kw">ResultSet</code> en una instancia de dominio Java, Spring proporciona la interfaz funcional <code class="kw">RowMapper&lt;T&gt;</code>:
            </li>
          </ol>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.repository;

<span class="kw">import</span> com.bibliotech.model.<span class="typ">Libro</span>;
<span class="kw">import</span> org.springframework.jdbc.core.<span class="typ">JdbcTemplate</span>;
<span class="kw">import</span> org.springframework.jdbc.core.<span class="typ">RowMapper</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Repository</span>;
<span class="kw">import</span> java.util.<span class="typ">List</span>;
<span class="kw">import</span> java.util.<span class="typ">Optional</span>;

<span class="ann">@Repository</span>
<span class="kw">public class</span> <span class="typ">LibroJdbcRepository</span> {

    <span class="kw">private final</span> <span class="typ">JdbcTemplate</span> jdbcTemplate;

    <span class="cmt">// Inyección del DataSource preconfigurado por Spring Boot</span>
    <span class="kw">public</span> <span class="fn">LibroJdbcRepository</span>(<span class="typ">JdbcTemplate</span> jdbcTemplate) {
        <span class="kw">this</span>.jdbcTemplate = jdbcTemplate;
    }

    <span class="cmt">// RowMapper: Mapea cada tupla de la consulta SQL al modelo de dominio Libro</span>
    <span class="kw">private final</span> <span class="typ">RowMapper</span>&lt;<span class="typ">Libro</span>&gt; libroRowMapper = (rs, rowNum) -&gt; {
        <span class="typ">Libro</span> libro = <span class="kw">new</span> <span class="typ">Libro</span>();
        libro.<span class="fn">setId</span>(rs.<span class="fn">getLong</span>(<span class="str">"id"</span>));
        libro.<span class="fn">setIsbn</span>(rs.<span class="fn">getString</span>(<span class="str">"isbn"</span>));
        libro.<span class="fn">setTitulo</span>(rs.<span class="fn">getString</span>(<span class="str">"titulo"</span>));
        libro.<span class="fn">setPrecio</span>(rs.<span class="fn">getBigDecimal</span>(<span class="str">"precio"</span>));
        <span class="kw">return</span> libro;
    };

    <span class="kw">public</span> <span class="typ">Optional</span>&lt;<span class="typ">Libro</span>&gt; <span class="fn">buscarPorIsbn</span>(<span class="typ">String</span> isbn) {
        <span class="typ">String</span> sql = <span class="str">"SELECT id, isbn, titulo, precio FROM libros WHERE isbn = ?"</span>;
        <span class="typ">List</span>&lt;<span class="typ">Libro</span>&gt; resultados = jdbcTemplate.<span class="fn">query</span>(sql, libroRowMapper, isbn);
        <span class="kw">return</span> resultados.<span class="fn">stream</span>().<span class="fn">findFirst</span>();
    }
}</code></pre>
          </code-block>

          <p>
            <strong>La Jerarquía Unificada de Excepciones: <code class="kw">DataAccessException</code></strong>:<br>
            Una de las mayores innovaciones del acceso a datos en Spring es su traductor automático de excepciones. Spring intercepta cualquier <code class="kw">SQLException</code> nativa del proveedor SQL y la traduce a una subclase de <code class="kw">org.springframework.dao.DataAccessException</code> (que es una <strong>excepción no comprobada / RuntimeException</strong>).
          </p>
          <ul>
            <li><code class="kw">DuplicateKeyException</code>: Se produce al violar una restricción de unicidad (por ejemplo, intentar insertar un libro con un ISBN ya existente en BiblioTech).</li>
            <li><code class="kw">DataIntegrityViolationException</code>: Se produce al violar una clave foránea (intentar asociar un libro a un autor inexistente) o una restricción NOT NULL.</li>
            <li><code class="kw">CannotAcquireLockException</code>: Se produce por interbloqueos (<em>deadlocks</em>) o tiempos de espera de bloqueo en transacciones concurrentes.</li>
          </ul>
          <p>
            Esta jerarquía garantiza que tu código de servicio o controlador <strong>nunca quede acoplado al motor de base de datos</strong>: la misma excepción se lanzará tanto si trabajas con Oracle como con PostgreSQL, MySQL o H2.
          </p>

          <p>
            <strong>El salto definitivo: De JdbcTemplate a Spring Data JPA</strong>:<br>
            Aunque <code class="kw">JdbcTemplate</code> simplificó enormemente JDBC, aún requería redactar sentencias SQL a mano y mapear relaciones complejas (un libro con sus autores, categorías y préstamos). Como verás en los Temas 8 y 9, <strong>Spring Data JPA</strong> culmina este camino unificando el motor ORM (Hibernate) con repositorios automáticos (<code class="kw">JpaRepository&lt;Libro, Long&gt;</code>), permitiendo persistir grafos de objetos completos sin redactar código de infraestructura.
          </p>
        </article>

        <!-- TEMA 8 -->
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
