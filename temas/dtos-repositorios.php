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

<article id="tema-10">
  <h3>10 — Patrón DTO (Data Transfer Object) y Repositorios Avanzados</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">10. DTO Pattern & Repositorios</div>
      <a href="#tema-10-analogia" class="topic-dropdown-item"><span class="item-num">10.1</span> <span class="item-title">Intuición de la Vida Real: El Control de Aduana vs Expediente Privado</span></a>
      <a href="#tema-10-riesgos" class="topic-dropdown-item"><span class="item-num">10.2</span> <span class="item-title">Riesgos Críticos de Exponer Entidades JPA Directamente</span></a>
      <a href="#tema-10-records" class="topic-dropdown-item"><span class="item-num">10.3</span> <span class="item-title">Implementación Práctica de DTOs Inmutables con Java Records</span></a>
      <a href="#tema-10-repositorios" class="topic-dropdown-item"><span class="item-num">10.4</span> <span class="item-title">Consultas Derivadas y Proyecciones en Repositorios</span></a>
    </div>
  </details>

  <p class="topic-intro">
    Exponer entidades de base de datos directamente en una API REST es una de las fallas de diseño más graves en aplicaciones Java. Este tema enseña a aplicar el <strong>Patrón DTO (Data Transfer Object)</strong> usando <strong>Java Records</strong> inmutables y a construir <strong>Repositorios avanzadas con Spring Data JPA</strong>.
  </p>

  <h4 id="tema-10-analogia">10.1 Intuición de la Vida Real: El Control de Aduana vs Expediente Privado</h4>
  <github-alert type="note" title="💡 Modelo Mental: ¿Por qué necesitas un DTO en la frontera de tu API?">
    <p>
      Imagina un control de seguridad en un aeropuerto internacional (Aduana):
    </p>
    <ul>
      <li><strong>El Pasaporte y la Declaración de Aduana (DTO - Data Transfer Object)</strong>: Cuando viajas, solo le enseñas al agente de frontera un documento público estandarizado con tu foto, nombre, número de pasaporte y lo que declaras transportar. Es un objeto liviano, diseñado exclusivamente para viajar entre países.</li>
      <li><strong>Tu Historia Clínica y Ficha Bancaria Completa (Entidad JPA)</strong>: Tu historial médico completo, tus antecedentes bancarios, las llaves de tu casa y tus notas privadas se quedan guardadas bajo llave en los archivos del país (Base de Datos). El agente del aeropuerto NO necesita ni DEBE ver tu historial bancario completo para dejarte pasar.</li>
      <li><strong>Historias paralelas en software</strong>: La Entidad JPA es la estructura interna de la base de datos (con contraseñas, marcas de auditoría, relaciones cruzadas). El DTO es el "Pasaporte" público formateado estrictamente para la petición HTTP.</li>
    </ul>
  </github-alert>

  <h4 id="tema-10-riesgos">10.2 Riesgos Críticos de Exponer Entidades JPA Directamente</h4>
  <p>
    Retornar o aceptar entidades JPA directamente en métodos <code>@RestController</code> desencadena tres problemas catastróficos:
  </p>
  <ul>
    <li><strong>1. Vulnerabilidad de Asignación Masiva (Mass Assignment)</strong>: Si un endpoint acepta <code>POST /api/usuarios</code> recibiendo la entidad <code>Usuario</code>, un atacante puede inyectar <code>{"esAdmin": true, "saldo": 999999}</code> y JPA actualizará esos campos directamente en SQL.</li>
    <li><strong>2. Bucles Infinitos en JSON (StackOverflowError)</strong>: Relaciones bidireccionales <code>@ManyToOne</code> / <code>@OneToMany</code> causan ciclos infinitos durante la serialización con Jackson (Autor &rarr; Libro &rarr; Autor &rarr; Libro...).</li>
    <li><strong>3. Acoplamiento Destructivo de API</strong>: Refactorizar una columna SQL en la base de datos rompe instantáneamente las aplicaciones móviles o clientes frontend que consumen el JSON.</li>
  </ul>

  <h4 id="tema-10-records">10.3 Implementación Práctica de DTOs Inmutables con Java Records</h4>
  <p>
    Desde Java 16, los <strong>Java Records</strong> son el estándar de la industria para definir DTOs inmutables de forma concisa, con métodos <code>equals()</code>, <code>hashCode()</code> y <code>toString()</code> generados automáticamente.
  </p>

  <div class="code-block-header">Ejemplo: DTOs de Petición (Request) y Respuesta (Response)</div>
  <pre><code class="language-java">// 1. DTO DE PETICIÓN (Entrada con validaciones Bean Validation)
public record CrearLibroRequestDTO(
    @NotBlank(message = "El título es obligatorio")
    @Size(min = 2, max = 150, message = "El título debe tener entre 2 y 150 caracteres")
    String titulo,

    @NotBlank(message = "El ISBN es obligatorio")
    @Pattern(regexp = "^(97(8|9))?\\d{9}(\\d|X)$", message = "Formato de ISBN-10 o ISBN-13 inválido")
    String isbn,

    @NotNull(message = "El precio es obligatorio")
    @DecimalMin(value = "0.01", message = "El precio debe ser mayor a 0")
    BigDecimal precio,

    @NotNull(message = "El ID del autor es obligatorio")
    Long autorId
) {}

// 2. DTO DE RESPUESTA (Salida formateada y segura para el cliente)
public record LibroDetalleResponseDTO(
    Long id,
    String titulo,
    String isbn,
    BigDecimal precio,
    String nombreAutor,
    String emailContactoAutor,
    Instant fechaPublicacion
) {
    // Método de mapeo estático desde la Entidad JPA
    public static LibroDetalleResponseDTO fromEntity(Libro libro) {
        return new LibroDetalleResponseDTO(
            libro.getId(),
            libro.getTitulo(),
            libro.getIsbn(),
            libro.getPrecio(),
            libro.getAutor().getNombreCompleto(),
            libro.getAutor().getEmail(),
            libro.getFechaCreacion()
        );
    }
}</code></pre>

  <h4 id="tema-10-repositorios">10.4 Consultas Derivadas y Proyecciones en Repositorios</h4>
  <p>
    Spring Data JPA elimina la necesidad de escribir el patrón <strong>DAO (Data Access Object)</strong> tradicional. Permite declarar repositorios basados en interfaces donde las consultas SQL/JPQL se derivan automáticamente del nombre del método o mediante anotaciones <code>@Query</code>.
  </p>

  <div class="code-block-header">Ejemplo: LibroRepository con Consultas Avanzadas y Proyecciones</div>
  <pre><code class="language-java">@Repository
public interface LibroRepository extends JpaRepository&lt;Libro, Long&gt; {

    // 1. Consulta derivada por nombre (Query Method)
    List&lt;Libro&gt; findByPrecioLessThanOrderByPrecioAsc(BigDecimal precioMaximo);

    // 2. Comprobación de existencia optimizada (Devuelve BOOLEAN sin cargar el objeto entero)
    boolean existsByIsbn(String isbn);

    // 3. Consulta JPQL personalizada orientada a Objetos
    @Query("SELECT l FROM Libro l WHERE l.autor.id = :autorId AND l.precio &gt;= :precioMin")
    List&lt;Libro&gt; buscarLibrosPorAutorYPrecioMinimo(
        @Param("autorId") Long autorId,
        @Param("precioMin") BigDecimal precioMin
    );

    // 4. Consulta SQL Nativa para alto rendimiento
    @Query(value = "SELECT * FROM libros WHERE titulo LIKE %:keyword% LIMIT 10", nativeQuery = true)
    List&lt;Libro&gt; buscarPorPalabraClaveNativa(@Param("keyword") String keyword);
}</code></pre>

  <github-alert type="tip" title="Patrón DAO vs Spring Data JPA">
    <p>
      Históricamente en Java EE, el <strong>Patrón DAO</strong> requería crear una interfaz <code>LibroDao</code> y una clase <code>LibroDaoImpl</code> llena de código <code>EntityManager</code> repetitivo. Spring Data JPA abstrae todo este <em>boilerplate</em>: al extender <code>JpaRepository&lt;Libro, Long&gt;</code>, obtienes gratis más de 20 métodos CRUD (save, findById, delete, findAll, count, flush) e integración con paginación (<code>Pageable</code>).
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
