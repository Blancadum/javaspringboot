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

<article id="tema-12">
  <h3>12 — Mapeo Avanzado con MapStruct y Spring Data Specifications</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">12. MapStruct & Specifications</div>
      <a href="#tema-12-mapstruct" class="topic-dropdown-item"><span class="item-num">12.1</span> <span class="item-title">Mapeo de DTOs de Alto Rendimiento con MapStruct</span></a>
      <a href="#tema-12-mapstruct-custom" class="topic-dropdown-item"><span class="item-num">12.2</span> <span class="item-title">Transformaciones Complejas y Mapeadores Personalizados</span></a>
      <a href="#tema-12-specifications" class="topic-dropdown-item"><span class="item-num">12.3</span> <span class="item-title">Filtros Dinámicos con Spring Data Specification & Criteria API</span></a>
      <a href="#tema-12-spec-builder" class="topic-dropdown-item"><span class="item-num">12.4</span> <span class="item-title">Construcción de Criterios Combinables (And/Or) y Paginación</span></a>
    </div>
  </details>

  <p class="topic-intro">
    A medida que las aplicaciones crecen, dos problemas surgen recurrentemente: la redundancia en el código de copia de atributos entre Entidades y DTOs, y la necesidad de ejecutar búsquedas dinámicas con múltiples filtros opcionales. En este tema se estudian dos herramientas clave: <strong>MapStruct</strong> para la generación de mapeos a nivel de compilación y <strong>Spring Data JPA Specifications</strong> para consultas desacopladas.
  </p>

  <h4 id="tema-12-analogia">12.0 Intuición de la Vida Real: La Fábrica Automatizada y el Buscador de Amazon</h4>
  <github-alert type="note" title="💡 Modelo Mental: MapStruct y Specifications en la vida real">
    <p>
      Imagina el funcionamiento de una gran tienda en línea como Amazon:
    </p>
    <ul>
      <li><strong>Cinta de Embalaje Automatizada (MapStruct)</strong>: En lugar de contratar a un operario humano que copie a mano cada dato del paquete a la etiqueta de envío (métodos <code>setNombre()</code> manuales propenso a errores y cansancio), instalas un brazo robótico ultra-rápido diseñado a medida en la fábrica (compilador) que transforma la caja del inventario (Entidad JPA) en el paquete postal precintado (DTO) en milisegundos.</li>
      <li><strong>El Panel de Filtros Laterales de Amazon (JPA Specifications)</strong>: Cuando buscas portátiles, puedes marcar o desmarcar casillas a voluntad: <code>[X] Precio < 1000€</code>, <code>[X] Marca: Lenovo</code>, <code>[ ] Envío Gratis</code>. El buscador va encadenando dinámicamente las condiciones activas sin necesidad de crear 50 métodos fijos diferentes en la base de datos.</li>
    </ul>
  </github-alert>

  <h4 id="tema-12-mapstruct">12.1 Mapeo de DTOs de Alto Rendimiento con MapStruct</h4>
  <p>
    A diferencia de librerías basadas en reflexión (como ModelMapper), <strong>MapStruct</strong> genera clases Java puras durante la fase de compilación (Annotation Processing). Esto garantiza velocidad de ejecución idéntica al código manual y detección inmediata de errores de mapeo antes de la ejecución.
  </p>

  <div class="code-block-header">Ejemplo: Mapper con MapStruct e Inyección de Spring</div>
  <pre><code class="language-java">@Mapper(componentModel = "spring", unmappedTargetPolicy = ReportingPolicy.IGNORE)
public interface ProductoMapper {

    @Mapping(target = "nombreCategoria", source = "categoria.nombre")
    @Mapping(target = "precioFormateado", expression = "java(producto.getPrecio() + \" €\")")
    ProductoDTO toDto(Producto producto);

    @Mapping(target = "id", ignore = true)
    @Mapping(target = "categoria", ignore = true)
    Producto toEntity(CrearProductoCommand command);

    List&lt;ProductoDTO&gt; toDtoList(List&lt;Producto&gt; productos);
}</code></pre>

  <h4 id="tema-12-mapstruct-custom">12.2 Transformaciones Complejas y Mapeadores Personalizados</h4>
  <p>
    MapStruct permite integrar lógica customizada mediante métodos con <code>@Named</code> o métodos <code>@AfterMapping</code> para enriquecer datos tras la conversión.
  </p>

  <pre><code class="language-java">@Mapper(componentModel = "spring")
public abstract class ClienteMapper {

    @Autowired
    protected CriptoService criptoService;

    @Mapping(target = "tarjetaEnmascarada", source = "numeroTarjeta", qualifiedByName = "enmascarar")
    public abstract ClienteDTO toDto(Cliente cliente);

    @Named("enmascarar")
    protected String enmascararTarjeta(String numeroTarjeta) {
        if (numeroTarjeta == null || numeroTarjeta.length() &lt; 4) return "****";
        return "****-****-****-" + numeroTarjeta.substring(numeroTarjeta.length() - 4);
    }
}</code></pre>

  <h4 id="tema-12-specifications">12.3 Filtros Dinámicos con Spring Data Specification & Criteria API</h4>
  <p>
    La interfaz <code>Specification&lt;T&gt;</code> de Spring Data JPA encapsula una condición de búsqueda basada en la <strong>JPA Criteria API</strong>. Permite construir filtros reutilizables y componibles sin escribir JPQL concatenado manualmente.
  </p>

  <pre><code class="language-java">public class ProductoSpecifications {

  public static Specification&lt;Producto&gt; tieneNombre(String nombre) {
    return (root, query, cb) -&gt; 
      nombre == null ? null : cb.like(cb.lower(root.get("nombre")), "%" + nombre.toLowerCase() + "%");
  }

  public static Specification&lt;Producto&gt; precioEntre(BigDecimal min, BigDecimal max) {
    return (root, query, cb) -&gt; {
      if (min == null && max == null) return null;
      if (min != null && max != null) return cb.between(root.get("precio"), min, max);
      if (min != null) return cb.greaterThanOrEqualTo(root.get("precio"), min);
      return cb.lessThanOrEqualTo(root.get("precio"), max);
    };
  }

  public static Specification&lt;Producto&gt; esActivo() {
    return (root, query, cb) -&gt; cb.equal(root.get("activo"), true);
  }
}</code></pre>

  <h4 id="tema-12-spec-builder">12.4 Construcción de Criterios Combinables (And/Or) y Paginación</h4>
  <p>
    Para ejecutar la consulta, el repositorio JPA debe extender <code>JpaSpecificationExecutor&lt;T&gt;</code>:
  </p>

  <pre><code class="language-java">@Repository
public interface ProductoRepository extends JpaRepository&lt;Producto, Long&gt;, JpaSpecificationExecutor&lt;Producto&gt; {
}

// Servicio combinando especificaciones con Specification.where()
@Service
@RequiredArgsConstructor
public class BusquedaProductoService {

    private final ProductoRepository productoRepository;
    private final ProductoMapper productoMapper;

    public Page&lt;ProductoDTO&gt; buscarProductos(String nombre, BigDecimal min, BigDecimal max, Pageable pageable) {
        Specification&lt;Producto&gt; spec = Specification.where(ProductoSpecifications.esActivo())
            .and(ProductoSpecifications.tieneNombre(nombre))
            .and(ProductoSpecifications.precioEntre(min, max));

        Page&lt;Producto&gt; pagina = productoRepository.findAll(spec, pageable);
        return pagina.map(productoMapper::toDto);
    }
}</code></pre>

  <github-alert type="tip" title="Ventaja principal de Specifications">
    <p>
      Al combinar especificaciones con <code>and()</code> o <code>or()</code>, Spring Data JPA ignora automáticamente los predicados que devuelven <code>null</code>, generando una única sentencia SQL optimizada con la clausula <code>WHERE</code> adecuada según los parámetros que el cliente haya enviado.
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>

