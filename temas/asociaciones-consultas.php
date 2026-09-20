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

<article id="tema-9">
          <h3>9 — Asociaciones, Consultas y Optimización en Hibernate</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">9. Asociaciones & Consultas</div>
            <a href="#tema-9-relaciones" class="topic-dropdown-item"><span class="item-num">9.1</span> <span class="item-title">Mapeo de Asociaciones: @OneToOne, @ManyToOne y @OneToMany</span></a>
            <a href="#tema-9-manytomany" class="topic-dropdown-item"><span class="item-num">9.2</span> <span class="item-title">Mapeo de Asociaciones: @ManyToMany y Tablas de Unión</span></a>
            <a href="#tema-9-jpql" class="topic-dropdown-item"><span class="item-num">9.3</span> <span class="item-title">Consultas contra la Base de Datos: JPQL, SQL Nativo y Criteria API</span></a>
            <a href="#tema-9-optimizacion" class="topic-dropdown-item"><span class="item-num">9.4</span> <span class="item-title">Optimización en Hibernate: Problema N+1, JOIN FETCH y Caché L1/L2</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Modelar relaciones entre entidades relacionales requiere precisión para evitar cuellos de botella en base de datos. En este tema aprenderás a configurar asociaciones 1:1, 1:N y N:M con <code class="kw">@JoinTable</code>, escribir consultas portables con JPQL y consultas nativas, y aplicar técnicas de optimización críticas como la eliminación del problema N+1 con <code class="kw">JOIN FETCH</code> y el uso de cachés L1/L2.
          </p>

          <github-alert type="note" title="💡 Intuición para Principiantes: Asociaciones y el Problema N+1">
            <p>
              ¿Cómo viajan los datos cuando un autor tiene 50 libros?
            </p>
            <ul>
              <li><strong>Asociaciones en Java</strong>: En lugar de guardar números de ID a mano como harías en SQL, en Java vinculas objetos directamente: <code class="kw">libro.setAutor(autor);</code> o <code class="kw">autor.getLibros().add(libro);</code>. Hibernate se encarga de guardar la clave foránea física en la columna <code class="kw">autor_id</code> de la tabla de libros.</li>
              <li><strong>El Problema N+1 (La pesadilla del rendimiento)</strong>: Imagina un camarero inexperto. En una mesa hay 20 comensales (20 autores). El camarero va a la cocina 1 vez a tomar la comanda. Luego, para saber qué pide cada autor, ¡hace 20 viajes individuales a la cocina, uno por cada autor! (1 consulta para los autores + 20 consultas individuales para sus libros = 21 viajes de red).</li>
              <li><strong>La Solución con <code class="kw">JOIN FETCH</code></strong>: El camarero profesional va a la cocina con un carrito y en <strong>un único viaje</strong> (una única sentencia SQL con <code class="kw">LEFT JOIN</code>) trae todos los autores con sus libros de golpe.</li>
            </ul>
          </github-alert>

          <h4 id="tema-9-relaciones">9.1 Mapeo de Asociaciones: @OneToOne, @ManyToOne y @OneToMany</h4>
          <p>
            En Hibernate, el mapeo de asociaciones traduce las relaciones entre tablas del modelo relacional a referencias entre objetos Java.
          </p>
          <ul>
            <li><strong>Lado Propietario (Owner)</strong>: La entidad que contiene físicamente la columna de clave foránea (FK) en SQL. Se anota con <code class="kw">@JoinColumn(name = "fk_id")</code>. En relaciones 1:N, el lado <code class="kw">@ManyToOne</code> es siempre el propietario.</li>
            <li><strong>Lado Inverso (Inverse)</strong>: Contiene la colección o referencia inversa sin clave foránea física en su tabla. Se anota con <code class="kw">mappedBy = "nombrePropiedadEnLadoPropietario"</code>.</li>
            <li><strong>Propagación de Operaciones (Cascading)</strong>: <code class="kw">cascade = CascadeType.ALL</code> propaga las operaciones del ciclo de vida (persist, merge, remove) del padre a sus hijos. <code class="kw">orphanRemoval = true</code> garantiza que si un hijo se quita de la lista en memoria, Hibernate ejecuta un <code class="kw">DELETE</code> automático en BD.</li>
            <li><strong>Carga Diferida Obligatoria</strong>: Siempre debe definirse <code class="kw">fetch = FetchType.LAZY</code>. En JPA, <code class="kw">@ManyToOne</code> y <code class="kw">@OneToOne</code> son <code class="kw">EAGER</code> por defecto, lo que provoca consultas masivas innecesarias si no se configuran explícitamente como <code class="kw">LAZY</code>.</li>
          </ul>

          <code-block lang="java">
<pre><code><span class="cmt">// Lado Padre (No dueño de la foreign key en SQL)</span>
<span class="ann">@Entity</span>
<span class="kw">public class</span> <span class="typ">Autor</span> {
    <span class="ann">@Id</span> <span class="ann">@GeneratedValue</span>(strategy = <span class="typ">GenerationType</span>.<span class="typ">IDENTITY</span>)
    <span class="kw">private</span> <span class="typ">Long</span> id;

    <span class="kw">private</span> <span class="typ">String</span> nombre;

    <span class="ann">@OneToMany</span>(mappedBy = <span class="str">"autor"</span>, cascade = <span class="typ">CascadeType</span>.<span class="typ">ALL</span>, orphanRemoval = <span class="kw">true</span>, fetch = <span class="typ">FetchType</span>.<span class="typ">LAZY</span>)
    <span class="kw">private</span> <span class="typ">List</span>&lt;<span class="typ">Libro</span>&gt; libros = <span class="kw">new</span> <span class="typ">ArrayList</span>&lt;&gt;();
}

<span class="cmt">// Lado Hijo (Dueño de la foreign key en SQL)</span>
<span class="ann">@Entity</span>
<span class="kw">public class</span> <span class="typ">Libro</span> {
    <span class="ann">@Id</span> <span class="ann">@GeneratedValue</span>(strategy = <span class="typ">GenerationType</span>.<span class="typ">IDENTITY</span>)
    <span class="kw">private</span> <span class="typ">Long</span> id;

    <span class="kw">private</span> <span class="typ">String</span> titulo;

    <span class="ann">@ManyToOne</span>(fetch = <span class="typ">FetchType</span>.<span class="typ">LAZY</span>)
    <span class="ann">@JoinColumn</span>(name = <span class="str">"autor_id"</span>, nullable = <span class="kw">false</span>)
    <span class="kw">private</span> <span class="typ">Autor</span> autor;
}</code></pre>
          </code-block>

          <h4 id="tema-9-manytomany">9.2 Mapeo de Asociaciones: @ManyToMany y Tablas de Unión</h4>
          <p>
            Cuando varias filas de una tabla se asocian con múltiples filas de otra (ej. un <code class="kw">Libro</code> pertenece a varias <code class="kw">Categoria</code>s y cada categoría contiene múltiples libros), el modelo relacional requiere una <strong>tabla asociativa o de unión</strong>. En JPA se modela mediante <code class="kw">@ManyToMany</code> y <code class="kw">@JoinTable</code>. Es una buena práctica estricta utilizar colecciones <code class="kw">Set&lt;T&gt;</code> en lugar de <code class="kw">List&lt;T&gt;</code> para prevenir la eliminación y reinserción masiva de filas en Hibernate:
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.libreria.entity;

<span class="kw">import</span> jakarta.persistence.*;
<span class="kw">import</span> lombok.Getter;
<span class="kw">import</span> lombok.Setter;
<span class="kw">import</span> java.util.HashSet;
<span class="kw">import</span> java.util.Set;

<span class="cmt">// Entidad Categoria (ej. "Ciencia Ficción", "Arquitectura Software", "Bases de Datos")</span>
<span class="ann">@Entity</span>
<span class="ann">@Table</span>(name = <span class="str">"categorias"</span>)
<span class="ann">@Getter</span> <span class="ann">@Setter</span>
<span class="kw">public class</span> <span class="typ">Categoria</span> {

    <span class="ann">@Id</span>
    <span class="ann">@GeneratedValue</span>(strategy = <span class="typ">GenerationType</span>.<span class="typ">IDENTITY</span>)
    <span class="kw">private</span> <span class="typ">Long</span> id;

    <span class="kw">private</span> <span class="typ">String</span> titulo;
    <span class="ann">@Column</span>(nullable = <span class="kw">false</span>, unique = <span class="kw">true</span>, length = 50)
    <span class="kw">private</span> <span class="typ">String</span> nombre;

    <span class="cmt">// Lado propietario que define la tabla asociativa física en base de datos</span>
    <span class="ann">@ManyToMany</span>(cascade = { <span class="typ">CascadeType</span>.PERSIST, <span class="typ">CascadeType</span>.MERGE })
    <span class="ann">@JoinTable</span>(
        name = <span class="str">"curso_estudiante"</span>,
        joinColumns = <span class="ann">@JoinColumn</span>(name = <span class="str">"curso_id"</span>),
        inverseJoinColumns = <span class="ann">@JoinColumn</span>(name = <span class="str">"estudiante_id"</span>)
    )
    <span class="kw">private</span> <span class="typ">Set</span>&lt;<span class="typ">Estudiante</span>&gt; estudiantes = <span class="kw">new</span> <span class="typ">HashSet</span>&lt;&gt;();
}

<span class="cmt">// Lado inverso: mappedBy apunta al atributo 'categorias' en Libro</span>
<span class="ann">@ManyToMany</span>(mappedBy = <span class="str">"categorias"</span>)
<span class="kw">private</span> <span class="typ">Set</span>&lt;<span class="typ">Libro</span>&gt; libros = <span class="kw">new</span> <span class="typ">HashSet</span>&lt;&gt;();
}

<span class="cmt">// En la entidad Libro: Lado propietario que declara la tabla física 'libros_categorias'</span>
<span class="ann">@ManyToMany</span>(cascade = { <span class="typ">CascadeType</span>.PERSIST, <span class="typ">CascadeType</span>.MERGE })
<span class="ann">@JoinTable</span>(
    name = <span class="str">"libros_categorias"</span>,
    joinColumns = <span class="ann">@JoinColumn</span>(name = <span class="str">"libro_id"</span>),
    inverseJoinColumns = <span class="ann">@JoinColumn</span>(name = <span class="str">"categoria_id"</span>)
)
<span class="kw">private</span> <span class="typ">Set</span>&lt;<span class="typ">Categoria</span>&gt; categorias = <span class="kw">new</span> <span class="typ">HashSet</span>&lt;&gt;();</code></pre>
          </code-block>

          <h4 id="tema-9-jpql">9.3 Consultas contra la Base de Datos: JPQL, SQL Nativo y Criteria API</h4>
          <p>
            Hibernate y Spring Data proporcionan tres mecanismos complementarios para ejecutar consultas contra la base de datos:
          </p>
          <ol>
            <li>
              <strong>JPQL (Java Persistence Query Language) / HQL</strong>: Consulta orientada a objetos que opera sobre nombres de entidades y atributos Java en lugar de tablas y columnas SQL. Es <em>portable</em> entre diferentes motores de base de datos. Se parametrizan con parámetros nombrados (<code class="kw">:param</code>) para prevenir inyecciones SQL.
            </li>
            <li>
              <strong>Consultas SQL Nativas (<code class="kw">nativeQuery = true</code>)</strong>: Consultas escritas directamente en el dialecto SQL de la base de datos subyacente. Necesarias cuando se requiere aprovechar sintaxis propietaria (funciones ventana <code class="kw">OVER()</code>, CTEs recursivas, índices JSON de PostgreSQL).
            </li>
            <li>
              <strong>Criteria API</strong>: API tipada y programática con <code class="kw">CriteriaBuilder</code> y <code class="kw">CriteriaQuery</code> para construir consultas dinámicas en tiempo de compilación sin concatenar cadenas, ideal para pantallas de búsqueda con filtros condicionales opcionales.
            </li>
          </ol>

          <code-block lang="java">
<pre><code><span class="kw">public interface</span> <span class="typ">LibroRepository</span> <span class="kw">extends</span> <span class="typ">JpaRepository</span>&lt;<span class="typ">Libro</span>, <span class="typ">Long</span>&gt; {

    <span class="cmt">// 1. Consulta JPQL sobre entidades de dominio</span>
    <span class="ann">@Query</span>(<span class="str">"SELECT l FROM Libro l WHERE l.autor.nombre = :nombreAutor AND l.precio &lt;= :precioMax"</span>)
    <span class="typ">List</span>&lt;<span class="typ">Libro</span>&gt; <span class="fn">buscarLibrosPorAutorYPrecio</span>(
        <span class="ann">@Param</span>(<span class="str">"nombreAutor"</span>) <span class="typ">String</span> nombreAutor,
        <span class="ann">@Param</span>(<span class="str">"precioMax"</span>) <span class="typ">BigDecimal</span> precioMax
    );

    <span class="cmt">// 2. Consulta SQL Nativa para aprovechar funciones propietarias del motor</span>
    <span class="ann">@Query</span>(value = <span class="str">"SELECT * FROM libros WHERE MATCH(titulo) AGAINST(:termino IN BOOLEAN MODE)"</span>, nativeQuery = <span class="kw">true</span>)
    <span class="typ">List</span>&lt;<span class="typ">Libro</span>&gt; <span class="fn">busquedaTextoCompleto</span>(<span class="ann">@Param</span>(<span class="str">"termino"</span>) <span class="typ">String</span> termino);

    <span class="cmt">// 3. Métodos derivados de Spring Data (generan JPQL automáticamente)</span>
    <span class="typ">List</span>&lt;<span class="typ">Libro</span>&gt; <span class="fn">findByTituloContainingIgnoreCase</span>(<span class="typ">String</span> palabra);
}</code></pre>
          </code-block>

          <h4 id="tema-9-optimizacion">9.4 Optimización en Hibernate: Problema N+1, JOIN FETCH y Caché L1/L2</h4>
          <p>
            El rendimiento de una aplicación empresarial con Hibernate depende de mitigar los costes de I/O de base de datos mediante técnicas de optimización especializadas:
          </p>

          <ul>
            <li>
              <strong>El Problema N+1 Queries</strong>: Se produce al consultar una lista de <code class="kw">N</code> entidades padre (1 consulta) y, al iterar sobre sus colecciones relacionadas perezosas (<code class="kw">LAZY</code>), Hibernate emite <code class="kw">N</code> consultas SQL individuales adicionales. Si hay 1.000 autores, se ejecutan 1.001 consultas.
            </li>
            <li>
              <strong>Solución 1 — <code class="kw">JOIN FETCH</code> en JPQL</strong>:
              Fuerza a Hibernate a traer en una única sentencia SQL la entidad y sus asociaciones relacionadas mediante un <code class="kw">INNER JOIN</code> o <code class="kw">LEFT JOIN</code>:
              <pre><code class="kw">@Query("SELECT a FROM Autor a JOIN FETCH a.libros WHERE a.activo = true")
List&lt;Autor&gt; findAllConLibros();</code></pre>
            </li>
            <li>
              <strong>Solución 2 — <code class="kw">@EntityGraph</code></strong>:
              Permite redefinir dinámicamente el plan de carga de atributos a nivel de método de repositorio sin alterar las anotaciones fijas de la entidad:
              <pre><code class="kw">@EntityGraph(attributePaths = {"libros", "libros.categorias"})
List&lt;Autor&gt; findByNacionalidad(String nacionalidad);</code></pre>
            </li>
            <li>
              <strong>Caché de Primer Nivel (L1 - Sesión)</strong>:
              Integrada y siempre activa a nivel del <code class="kw">EntityManager</code> / transacción actual. Si en la misma transacción se solicita el mismo ID en múltiples ocasiones, Hibernate recupera la instancia de memoria sin emitir sentencias SQL adicionales.
            </li>
            <li>
              <strong>Caché de Segundo Nivel (L2)</strong>:
              Caché compartida a través de todos los <code class="kw">EntityManager</code> de la aplicación (o distribuida entre réplicas con Redis o Ehcache). Se activa con <code class="kw">@Cacheable</code> y configurando <code class="kw">spring.jpa.properties.hibernate.cache.use_second_level_cache=true</code> para entidades leídas frecuentemente y poco modificadas (ej. países, categorías).
            </li>
            <li>
              <strong>Procesamiento por Lotes (Batch Fetching / Batch Inserts)</strong>:
              Configurar <code class="kw">spring.jpa.properties.hibernate.jdbc.batch_size=30</code> agrupa inserciones y actualizaciones en bloques para reducir roundtrips de red, y <code class="kw">@BatchSize(size = 25)</code> agrupa consultas de colecciones secundarias mediante cláusulas <code class="kw">IN (?, ?, ...)</code>.
            </li>
          </ul>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
