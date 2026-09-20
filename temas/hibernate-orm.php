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

<article id="tema-8">
          <h3>8 — Hibernate y Mapeo Objeto-Relacional (JPA)</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">8. Hibernate & ORM</div>
            <a href="#tema-8-intro-hibernate" class="topic-dropdown-item"><span class="item-num">8.1</span> <span class="item-title">Introducción a Hibernate y Arquitectura Core</span></a>
            <a href="#tema-8-clases-mapeadas" class="topic-dropdown-item"><span class="item-num">8.2</span> <span class="item-title">JPA y sus Anotaciones: Guía Completa de Mapeo</span></a>
            <a href="#tema-8-estados-objetos" class="topic-dropdown-item"><span class="item-num">8.3</span> <span class="item-title">Trabajo con Objetos: Los 4 Estados y Contexto de Persistencia</span></a>
            <a href="#tema-8-herencia" class="topic-dropdown-item"><span class="item-num">8.4</span> <span class="item-title">Mapeo de Herencia (@MappedSuperclass, SINGLE_TABLE, JOINED)</span></a>
            <a href="#tema-8-crud" class="topic-dropdown-item"><span class="item-num">8.5</span> <span class="item-title">Operaciones CRUD Completas con Hibernate y Spring Data</span></a>
          </div>
        </details>

          <p class="topic-intro">
            El Mapeo Objeto-Relacional (ORM) con Hibernate actúa de puente entre el modelo de datos relacional y las clases Java. Este tema aborda la arquitectura core (<code class="kw">SessionFactory</code>, <code class="kw">Session</code>, dialectos), el mapeo de tablas y componentes embebidos (<code class="ann">@Embeddable</code>), los cuatro estados de una entidad en el contexto de persistencia, estrategias de herencia y operaciones CRUD con Spring Data.
          </p>

          <github-alert type="note" title="💡 Intuición para Principiantes: ¿Por qué inventamos el ORM y Hibernate?">
            <p>
              Antes de que existieran los frameworks ORM como Hibernate, los desarrolladores Java utilizaban <strong>JDBC puro</strong>. Para leer un simple libro de la base de datos, tenían que:
            </p>
            <ol>
              <li>Abrir una conexión TCP a la base de datos y manejar errores de red.</li>
              <li>Escribir la consulta SQL en una cadena de texto propensa a erratas: <code class="kw">"SELECT id, titulo, isbn, precio FROM libros WHERE id = ?"</code>.</li>
              <li>Ejecutar la query y recorrer un cursor llamado <code class="kw">ResultSet</code>: <code class="kw">libro.setId(rs.getLong("id")); libro.setTitulo(rs.getString("titulo")); ...</code> mapeando a mano cada columna.</li>
              <li>Cerrar manualmente la conexión en un bloque <code class="kw">finally</code> para no saturar el servidor.</li>
            </ol>
            <p>
              <strong>El dolor:</strong> Si la tabla cambiaba de nombre o agregabas una columna, tenías que buscar y reescribir decenas de consultas SQL a mano en ficheros de texto. <strong>JPA y Hibernate automatizan este 100%</strong>: tú trabajas con objetos Java normales (<code class="kw">Libro libro = repo.findById(1L);</code>), y el ORM se encarga de generar el SQL perfecto optimizado para tu motor (PostgreSQL, Oracle o H2).
            </p>
          </github-alert>

          <h4 id="tema-8-intro-hibernate">8.1 Introducción a Hibernate y Arquitectura Core</h4>
          <p>
            <strong>Hibernate</strong> es el framework de <strong>Mapeo Objeto-Relacional (ORM)</strong> más extendido en el ecosistema Java y la implementación de referencia del estándar <strong>Jakarta Persistence (JPA)</strong>. Su propósito es erradicar la disparidad de impedancia (impedance mismatch) entre el modelo relacional de tablas SQL y el modelo orientado a objetos de Java.
          </p>

          <p><strong>Arquitectura Interna y Componentes Clave:</strong></p>
          <ul>
            <li><strong>SessionFactory (EntityManagerFactory en JPA)</strong>: Objeto singleton inmutable y <em>thread-safe</em> creado al arrancar la aplicación. Almacena la configuración global, mapeos de entidades, pool de conexiones y la Caché de Segundo Nivel.</li>
            <li><strong>Session (EntityManager en JPA)</strong>: Objeto liviano y <em>no thread-safe</em> que representa una conversación o unidad de trabajo con la base de datos (Contexto de Persistencia y Caché de Primer Nivel). Se abre y se destruye en cada petición o transacción.</li>
            <li><strong>Dialect (Dialecto SQL)</strong>: Abstracción que traduce las consultas HQL/JPQL al dialecto específico de cada motor (PostgreSQL, MySQL, Oracle, H2), aprovechando optimizaciones nativas de paginación (<code class="kw">LIMIT / OFFSET</code>) y tipos de datos propietarios.</li>
          </ul>

          <table>
            <thead>
              <tr>
                <th>Concepto en Modelo ER (SQL)</th>
                <th>Equivalente en Java / JPA</th>
                <th>Anotación Principal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Tabla Relacional</td>
                <td>Clase Entidad persistente</td>
                <td><code class="ann">@Entity</code>, <code class="ann">@Table(name = "...")</code></td>
              </tr>
              <tr>
                <td>Clave Primaria (PK)</td>
                <td>Identificador único del objeto</td>
                <td><code class="ann">@Id</code>, <code class="ann">@GeneratedValue(strategy = GenerationType.IDENTITY)</code></td>
              </tr>
              <tr>
                <td>Columna con restricciones</td>
                <td>Atributo de instancia</td>
                <td><code class="ann">@Column(nullable = false, unique = true, length = ...)</code></td>
              </tr>
              <tr>
                <td>Clave Foránea (FK) de 1 a N</td>
                <td>Referencia a la entidad padre</td>
                <td><code class="ann">@ManyToOne</code> con <code class="ann">@JoinColumn(name = "fk_id")</code></td>
              </tr>
              <tr>
                <td>Tabla de Unión para N a M</td>
                <td>Colección asociativa bidireccional</td>
                <td><code class="ann">@ManyToMany</code> con <code class="ann">@JoinTable(...)</code></td>
              </tr>
            </tbody>
          </table>

          <h4 id="tema-8-clases-mapeadas">8.2 JPA y sus Anotaciones: Guía Completa de Mapeo</h4>
          <p>
            <strong>Jakarta Persistence (JPA)</strong> define un conjunto estandarizado de anotaciones para declarar cómo los objetos Java se corresponden con el esquema relacional SQL sin escribir sentencias DDL manuales.
          </p>

          <p><strong>Catálogo Completo de Anotaciones de Mapeo JPA:</strong></p>
          <table>
            <thead>
              <tr>
                <th style="width: 180px;">Anotación JPA</th>
                <th style="width: 160px;">Nivel</th>
                <th>Propósito Técnico y Parámetros Clave</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><code class="ann">@Entity</code></td>
                <td>Clase</td>
                <td>Declara que la clase Java es una entidad persistente gestionada por el <code class="kw">EntityManager</code>. Requiere constructor público o protegido sin argumentos.</td>
              </tr>
              <tr>
                <td><code class="ann">@Table</code></td>
                <td>Clase</td>
                <td>Personaliza la tabla física en base de datos. Parámetros: <code class="kw">name</code> (nombre de tabla), <code class="kw">schema</code>, <code class="kw">uniqueConstraints</code> e <code class="kw">indexes</code>.</td>
              </tr>
              <tr>
                <td><code class="ann">@Id</code></td>
                <td>Atributo / Getter</td>
                <td>Declara el identificador de la entidad correspondiente a la Clave Primaria (PK) en la tabla relacional.</td>
              </tr>
              <tr>
                <td><code class="ann">@GeneratedValue</code></td>
                <td>Atributo / Getter</td>
                <td>Define la estrategia de generación del ID: <code class="kw">IDENTITY</code> (autoincrement del motor), <code class="kw">SEQUENCE</code> (secuencias de PostgreSQL/Oracle), <code class="kw">TABLE</code> o <code class="kw">AUTO</code>.</td>
              </tr>
              <tr>
                <td><code class="ann">@Column</code></td>
                <td>Atributo / Getter</td>
                <td>Configura la columna física: <code class="kw">name</code>, <code class="kw">nullable = false</code> (NOT NULL), <code class="kw">unique = true</code>, <code class="kw">length</code> (para VARCHAR), <code class="kw">precision</code> y <code class="kw">scale</code> (para BigDecimal), <code class="kw">updatable = false</code>.</td>
              </tr>
              <tr>
                <td><code class="ann">@Enumerated</code></td>
                <td>Atributo</td>
                <td>Mapea un Enum Java. <strong>Regla crítica</strong>: Usar siempre <code class="kw">EnumType.STRING</code> para guardar el texto del enum. Evitar <code class="kw">EnumType.ORDINAL</code> porque guardar índices numéricos corrompe los datos si se reordenan los valores.</td>
              </tr>
              <tr>
                <td><code class="ann">@Transient</code></td>
                <td>Atributo</td>
                <td>Indica que el atributo es puramente de memoria (cálculos auxiliares, campos transitorios) y <strong>no debe persistirse</strong> como columna en la base de datos.</td>
              </tr>
              <tr>
                <td><code class="ann">@Lob</code></td>
                <td>Atributo</td>
                <td>Mapea objetos grandes (Large Objects): <code class="kw">String</code> o <code class="kw">char[]</code> se mapean a <strong>CLOB</strong> (texto largo ilimitado), y <code class="kw">byte[]</code> a <strong>BLOB</strong> (ficheros o imágenes binarias).</td>
              </tr>
              <tr>
                <td><code class="ann">@Version</code></td>
                <td>Atributo</td>
                <td>Habilita el <strong>Bloqueo Optimista (Optimistic Locking)</strong>. Hibernate incrementa automáticamente este campo entero en cada <code class="kw">UPDATE</code>, lanzando <code class="kw">OptimisticLockException</code> si detecta modificaciones concurrentes perdidas.</td>
              </tr>
              <tr>
                <td><code class="ann">@Embeddable</code></td>
                <td>Clase</td>
                <td>Declara un <strong>Objeto de Valor (Value Object)</strong> reutilizable sin identidad propia ni tabla independiente. Sus atributos se incrustan como columnas en la tabla propietaria.</td>
              </tr>
              <tr>
                <td><code class="ann">@Embedded</code></td>
                <td>Atributo</td>
                <td>Se coloca en la entidad propietaria sobre el campo cuyo tipo está anotado con <code class="ann">@Embeddable</code>. Permite usar <code class="ann">@AttributeOverride</code> para renombrar columnas si hay colisión.</td>
              </tr>
            </tbody>
          </table>

          <h5>Ejemplo de Producción en BiblioTech: Entidad Libro con Anotaciones JPA</h5>
          <code-block lang="java">
<pre><code><span class="kw">package</span> com.libreria.entity;

<span class="kw">import</span> jakarta.persistence.*;
<span class="kw">import</span> lombok.*;
<span class="kw">import</span> java.math.<span class="typ">BigDecimal</span>;
<span class="kw">import</span> java.time.<span class="typ">LocalDateTime</span>;

<span class="cmt">// Objeto de Valor incrustable sin tabla independiente: dimensiones del libro</span>
<span class="ann">@Embeddable</span>
<span class="ann">@Getter</span> <span class="ann">@Setter</span> <span class="ann">@NoArgsConstructor</span> <span class="ann">@AllArgsConstructor</span>
<span class="kw">public class</span> <span class="typ">DimensionesLibro</span> {
    <span class="kw">private</span> <span class="typ">Double</span> altoCm;
    <span class="kw">private</span> <span class="typ">Double</span> anchoCm;
    <span class="kw">private</span> <span class="typ">Double</span> grosorCm;
    <span class="kw">private</span> <span class="typ">Integer</span> pesoGramos;
}

<span class="kw">public enum</span> <span class="typ">EstadoLibro</span> {
    DISPONIBLE, PRESTADO, EN_REVISION, DESCATALOGADO
}

<span class="cmt">// Entidad persistente central de BiblioTech mapeada a la tabla 'libros'</span>
<span class="ann">@Entity</span>
<span class="ann">@Table</span>(
    name = <span class="str">"libros"</span>,
    indexes = { <span class="ann">@Index</span>(name = <span class="str">"idx_libro_isbn"</span>, columnList = <span class="str">"isbn"</span>) }
)
<span class="ann">@Getter</span> <span class="ann">@Setter</span> <span class="ann">@NoArgsConstructor</span> <span class="ann">@AllArgsConstructor</span>
<span class="kw">public class</span> <span class="typ">Libro</span> {

    <span class="ann">@Id</span>
    <span class="ann">@GeneratedValue</span>(strategy = <span class="typ">GenerationType</span>.<span class="typ">IDENTITY</span>)
    <span class="kw">private</span> <span class="typ">Long</span> id;

    <span class="ann">@Column</span>(nullable = <span class="kw">false</span>, unique = <span class="kw">true</span>, length = 20)
    <span class="kw">private</span> <span class="typ">String</span> isbn;

    <span class="ann">@Column</span>(nullable = <span class="kw">false</span>, length = 150)
    <span class="kw">private</span> <span class="typ">String</span> titulo;

    <span class="ann">@Lob</span>
    <span class="ann">@Column</span>(columnDefinition = <span class="str">"TEXT"</span>)
    <span class="kw">private</span> <span class="typ">String</span> sinopsis; <span class="cmt">// CLOB: Texto descriptivo sin límite de 255 caracteres</span>

    <span class="ann">@Column</span>(nullable = <span class="kw">false</span>, precision = 10, scale = 2)
    <span class="kw">private</span> <span class="typ">BigDecimal</span> precio;

    <span class="cmt">// Mapeo seguro de enum como String ("DISPONIBLE" en vez del ordinal numérico 0)</span>
    <span class="ann">@Enumerated</span>(<span class="typ">EnumType</span>.STRING)
    <span class="ann">@Column</span>(nullable = <span class="kw">false</span>, length = 20)
    <span class="kw">private</span> <span class="typ">EstadoLibro</span> estado = <span class="typ">EstadoLibro</span>.DISPONIBLE;

    <span class="cmt">// Incrusta alto_cm, ancho_cm, grosor_cm y peso_gramos como columnas en la tabla 'libros'</span>
    <span class="ann">@Embedded</span>
    <span class="kw">private</span> <span class="typ">DimensionesLibro</span> dimensiones = <span class="kw">new</span> <span class="typ">DimensionesLibro</span>();

    <span class="cmt">// Bloqueo optimista: Previene reservas simultáneas del mismo ejemplar (Lost Updates)</span>
    <span class="ann">@Version</span>
    <span class="kw">private</span> <span class="typ">Long</span> version;

    <span class="cmt">// Campo transitorio de cálculo en memoria: NO genera columna física en SQL</span>
    <span class="ann">@Transient</span>
    <span class="kw">public boolean</span> <span class="fn">isAptoParaPrestamo</span>() {
        <span class="kw">return</span> <span class="typ">EstadoLibro</span>.DISPONIBLE.<span class="fn">equals</span>(<span class="kw">this</span>.estado);
    }
}</code></pre>
          </code-block>

          <h4 id="tema-8-estados-objetos">8.3 Trabajo con Objetos: Los 4 Estados y Contexto de Persistencia</h4>
          <p>
            El <strong>Contexto de Persistencia (Persistence Context)</strong> gestionado por el <code class="kw">EntityManager</code> / <code class="kw">Session</code> actúa como un área de memoria intermedia en la que cada instancia de entidad transita por <strong>4 estados fundamentales</strong>:
          </p>

          <table>
            <thead>
              <tr>
                <th>Estado de la Entidad</th>
                <th>Presencia en BD</th>
                <th>Asociada al EntityManager</th>
                <th>Comportamiento de Hibernate</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Transient (Nuevo / Transitorio)</strong></td>
                <td>No</td>
                <td>No</td>
                <td>Instancia creada con <code class="kw">new</code>. Sin ID asignado. Si se pierde su referencia, el recolector de basura (GC) la destruye.</td>
              </tr>
              <tr>
                <td><strong>Persistent / Managed (Gestionado)</strong></td>
                <td>Sí (o pendiente en commit)</td>
                <td><strong>Sí</strong></td>
                <td>Posee ID y está registrada en el Contexto de Persistencia. <strong>Dirty Checking</strong>: Cualquier modificación en sus campos mediante setters se sincroniza automáticamente con la base de datos al confirmar la transacción (no hace falta llamar a <code class="kw">save</code>).</td>
              </tr>
              <tr>
                <td><strong>Detached (Desconectado)</strong></td>
                <td>Sí</td>
                <td>No</td>
                <td>Tiene ID en la base de datos, pero la sesión/transacción donde se obtuvo ha finalizado (o se ejecutó <code class="kw">detach()</code> o <code class="kw">clear()</code>). Modificarla no tiene efecto en base de datos salvo que se reintegre mediante <code class="kw">merge()</code>.</td>
              </tr>
              <tr>
                <td><strong>Removed (Marcado para Borrado)</strong></td>
                <td>Aún en BD (hasta flush)</td>
                <td><strong>Sí</strong></td>
                <td>Entidad programada para su eliminación definitiva mediante <code class="kw">DELETE</code> al vaciar el contexto (flush o commit).</td>
              </tr>
            </tbody>
          </table>

          <code-block lang="java">
<pre><code><span class="cmt">// Ejemplo de transiciones de los 4 estados en el EntityManager para un Libro</span>
<span class="typ">Libro</span> libro = <span class="kw">new</span> <span class="typ">Libro</span>(); <span class="cmt">// Estado: TRANSIENT (solo vive en memoria RAM)</span>
libro.<span class="fn">setTitulo</span>(<span class="str">"Domain-Driven Design"</span>);
libro.<span class="fn">setIsbn</span>(<span class="str">"978-0321125217"</span>);

em.<span class="fn">persist</span>(libro); <span class="cmt">// Estado: PERSISTENT / MANAGED. Hibernate genera el ID y vigila sus cambios</span>

libro.<span class="fn">setPrecio</span>(<span class="typ">BigDecimal</span>.<span class="fn">valueOf</span>(49.99)); <span class="cmt">// Dirty Checking: actualizará la BD sin llamar a save()</span>

em.<span class="fn">flush</span>(); <span class="cmt">// Sincroniza sentencias SQL en la BD sin cerrar la transacción</span>
em.<span class="fn">detach</span>(libro); <span class="cmt">// Estado: DETACHED. Ya no está vinculada al EntityManager</span>

libro.<span class="fn">setPrecio</span>(<span class="typ">BigDecimal</span>.<span class="fn">valueOf</span>(19.99)); <span class="cmt">// Este cambio NO se reflejará en la base de datos</span>

<span class="typ">Libro</span> reconectado = em.<span class="fn">merge</span>(libro); <span class="cmt">// Estado: PERSISTENT nuevamente (copia gestionada devuelta)</span>
em.<span class="fn">remove</span>(reconectado); <span class="cmt">// Estado: REMOVED. Se ejecutará DELETE al hacer commit</span></code></pre>
          </code-block>

          <h4 id="tema-8-herencia">8.4 Mapeo de Herencia en Hibernate (@MappedSuperclass, SINGLE_TABLE, JOINED)</h4>
          <p>
            Dado que las bases de datos relacionales carecen del concepto nativo de herencia de clases, JPA y Hibernate ofrecen <strong>estrategias de mapeo polimórfico</strong>:
          </p>

          <ul>
            <li>
              <strong>1. <code class="ann">@MappedSuperclass</code></strong>: Define una superclase abstracta con atributos compartidos (ej. <code class="kw">id</code>, <code class="kw">fechaCreacion</code>). <em>No es una entidad</em>, no genera tabla en BD y sus columnas se replican en las tablas hijas.
            </li>
            <li>
              <strong>2. <code class="kw">InheritanceType.SINGLE_TABLE</code> (Estrategia por defecto)</strong>: Toda la jerarquía de clases se mapea en <strong>una única tabla física</strong>. Requiere una columna discriminadora (<code class="ann">@DiscriminatorColumn</code>) para indicar el tipo concreto. Muy rápida (sin JOINs), pero las columnas de las subclases deben permitir nulos (<code class="kw">nullable = true</code>).
            </li>
            <li>
              <strong>3. <code class="kw">InheritanceType.JOINED</code></strong>: Cada clase (padre e hijas) tiene su <strong>propia tabla normalizada</strong>. La tabla hija utiliza como clave primaria y foránea (FK) la misma clave de la tabla padre. Realiza sentencias <code class="kw">JOIN</code> en consultas polimórficas.
            </li>
            <li>
              <strong>4. <code class="kw">InheritanceType.TABLE_PER_CLASS</code></strong>: Genera una tabla independiente por cada clase concreta conteniendo todos los atributos. Consultas sobre la clase base requieren sentencias <code class="kw">UNION</code> más costosas.
            </li>
          </ul>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.libreria.entity.herencia;

<span class="kw">import</span> jakarta.persistence.*;
<span class="kw">import</span> lombok.Getter;
<span class="kw">import</span> lombok.Setter;
<span class="kw">import</span> java.math.<span class="typ">BigDecimal</span>;

<span class="cmt">// ── ESTRATEGIA JOINED EN BIBLIOTECH: Jerarquía de publicaciones editoriales ──</span>
<span class="ann">@Entity</span>
<span class="ann">@Table</span>(name = <span class="str">"publicaciones"</span>)
<span class="ann">@Inheritance</span>(strategy = <span class="typ">InheritanceType</span>.JOINED)
<span class="ann">@Getter</span> <span class="ann">@Setter</span>
<span class="kw">public abstract class</span> <span class="typ">Publicacion</span> {
    <span class="ann">@Id</span> <span class="ann">@GeneratedValue</span>(strategy = <span class="typ">GenerationType</span>.<span class="typ">IDENTITY</span>)
    <span class="kw">private</span> <span class="typ">Long</span> id;
    <span class="kw">private</span> <span class="typ">String</span> isbn;
    <span class="kw">private</span> <span class="typ">String</span> titulo;
    <span class="kw">private</span> <span class="typ">BigDecimal</span> precio;
}

<span class="cmt">// Tabla física 'libros_fisicos' vinculada por FK = publicaciones.id</span>
<span class="ann">@Entity</span>
<span class="ann">@Table</span>(name = <span class="str">"libros_fisicos"</span>)
<span class="kw">public class</span> <span class="typ">LibroFisico</span> <span class="kw">extends</span> <span class="typ">Publicacion</span> {
    <span class="kw">private</span> <span class="typ">Integer</span> numeroPaginas;
    <span class="kw">private</span> <span class="typ">String</span> ubicacionEstanteria;
    <span class="kw">private</span> <span class="typ">Integer</span> ejemplaresDisponibles;
}

<span class="cmt">// Tabla física 'libros_digitales' vinculada por FK = publicaciones.id</span>
<span class="ann">@Entity</span>
<span class="ann">@Table</span>(name = <span class="str">"libros_digitales"</span>)
<span class="kw">public class</span> <span class="typ">LibroDigital</span> <span class="kw">extends</span> <span class="typ">Publicacion</span> {
    <span class="kw">private</span> <span class="typ">Double</span> tamanoArchivoMb;
    <span class="kw">private</span> <span class="typ">String</span> formatoDescarga; <span class="cmt">// EPUB, PDF</span>
    <span class="kw">private</span> <span class="typ">Boolean</span> tieneDrm;
}</code></pre>
          </code-block>

          <h4 id="tema-8-crud">8.5 Operaciones CRUD Completas con Hibernate y Spring Data</h4>
          <p>
            Al extender <code class="kw">JpaRepository&lt;T, ID&gt;</code>, Spring Data JPA provee la implementación automática de las operaciones CRUD fundamentales gestionadas en la sesión de Hibernate:
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.service;

<span class="kw">import</span> com.bibliotech.entity.<span class="typ">Libro</span>;
<span class="kw">import</span> com.bibliotech.repository.<span class="typ">LibroRepository</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> org.springframework.transaction.annotation.<span class="typ">Transactional</span>;
<span class="kw">import</span> java.util.List;

<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">LibroService</span> {

    <span class="kw">private final</span> <span class="typ">LibroRepository</span> repository;

    <span class="kw">public</span> <span class="fn">LibroService</span>(<span class="typ">LibroRepository</span> repository) {
        <span class="kw">this</span>.repository = repository;
    }

    <span class="ann">@Transactional</span>
    <span class="kw">public</span> <span class="typ">Libro</span> <span class="fn">crear</span>(<span class="typ">Libro</span> l) {
        <span class="kw">return</span> repository.<span class="fn">save</span>(l); <span class="cmt">// Ejecuta INSERT si id es null</span>
    }

    <span class="ann">@Transactional</span>(readOnly = <span class="kw">true</span>)
    <span class="kw">public</span> <span class="typ">Libro</span> <span class="fn">buscarPorId</span>(<span class="typ">Long</span> id) {
        <span class="kw">return</span> repository.<span class="fn">findById</span>(id)
            .<span class="fn">orElseThrow</span>(() -&gt; <span class="kw">new</span> <span class="typ">EntityNotFoundException</span>(<span class="str">"Libro no encontrado: "</span> + id));
    }

    <span class="ann">@Transactional</span>
    <span class="kw">public</span> <span class="typ">Libro</span> <span class="fn">actualizarPrecio</span>(<span class="typ">Long</span> id, <span class="typ">Double</span> nuevoPrecio) {
        <span class="typ">Libro</span> libro = <span class="fn">buscarPorId</span>(id);
        libro.<span class="fn">setPrecio</span>(java.math.<span class="typ">BigDecimal</span>.<span class="fn">valueOf</span>(nuevoPrecio));
        <span class="kw">return</span> repository.<span class="fn">save</span>(libro);
    }

    <span class="ann">@Transactional</span>
    <span class="kw">public void</span> <span class="fn">eliminar</span>(<span class="typ">Long</span> id) {
        <span class="kw">if</span> (!repository.<span class="fn">existsById</span>(id)) {
            <span class="kw">throw new</span> <span class="typ">EntityNotFoundException</span>(<span class="str">"ID inexistente"</span>);
        }
        repository.<span class="fn">deleteById</span>(id);
    }
}</code></pre>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
