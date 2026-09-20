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

<article id="tema-5">
  <h3>5 — SOLID, Arquitectura en Capas y Autoconfiguración Core</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">5. SOLID & Capas</div>
      <a href="#tema-5-analogia" class="topic-dropdown-item"><span class="item-num">5.1</span> <span class="item-title">Intuición de la Vida Real: La Analogía del Restaurante</span></a>
      <a href="#tema-5-solid" class="topic-dropdown-item"><span class="item-num">5.2</span> <span class="item-title">Los 5 Principios SOLID con Ejemplos Prácticos</span></a>
      <a href="#tema-5-capas" class="topic-dropdown-item"><span class="item-num">5.3</span> <span class="item-title">Arquitectura en Capas: Controller, Service y Repository</span></a>
      <a href="#tema-5-autoconfigure" class="topic-dropdown-item"><span class="item-num">5.4</span> <span class="item-title">Autoconfiguración y Anotaciones Core (@SpringBootApplication)</span></a>
    </div>
  </details>

  <p class="topic-intro">
    Construir software profesional requiere principios de diseño sólidos para evitar la degradación del código con el paso del tiempo. Este tema desglosa los <strong>Principios SOLID</strong>, la <strong>Arquitectura en Capas</strong> recomendada en Spring Boot y el mecanismo interno de <strong>Autoconfiguración Condicional</strong> que permite arrancar aplicaciones completas sin configuración XML.
  </p>

  <h4 id="tema-5-analogia">5.1 Intuición de la Vida Real: La Analogía del Restaurante</h4>
  <github-alert type="note" title="💡 Modelo Mental: ¿Cómo se organiza un Restaurante de Alta Cocina?">
    <p>
      Imagina un restaurante donde una sola persona atiende a los clientes en la mesa, toma la nota, entra a la cocina a cortar carne, limpia los platos, lleva la contabilidad y cobra con el datáfono. Si llega un grupo de 10 personas, el restaurante se colapsa por completo.
    </p>
    <ul>
      <li><strong>Camarero (Capa Web / Controller)</strong>: Atiende al cliente, recibe la comanda (HTTP Request), valida que el formato sea correcto y devuelve el plato listo en la mesa (HTTP Response). El camarero no sabe cocinar ni maneja la sartén.</li>
      <li><strong>Chef Principal (Capa de Negocio / Service)</strong>: Recibe la orden del camarero, aplica las reglas culinarias (cálculo de precios, descuentos, tiempos de cocción, lógica de inventario) y coordina a los ayudantes.</li>
      <li><strong>Jefe de Almacén (Capa de Datos / Repository)</strong>: Guarda e inspecciona las despensas y cámaras frigoríficas (Base de Datos). El cocinero le pide "dame 2 kg de harina" y el almacenero se encarga de buscarlo en la estantería exacta.</li>
      <li><strong>Pasarela de Pago (Abstracción / Interfaz DIP)</strong>: El restaurante cobra mediante un datáfono abstracto. No le importa si el banco emisor es Visa, Mastercard o PayPal; mientras cumpla el contrato de cobro, la cocina no cambia.</li>
    </ul>
  </github-alert>

  <h4 id="tema-5-solid">5.2 Los 5 Principios SOLID con Ejemplos Prácticos</h4>

  <table>
    <thead>
      <tr>
        <th>Principio</th>
        <th>Significado</th>
        <th>Analogía en la Vida Real</th>
        <th>Aplicación en Spring Boot</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>S — Single Responsibility (SRP)</strong></td>
        <td>Una clase debe tener una sola razón para cambiar.</td>
        <td>El mecánico arregla el motor; el contable gestiona la facturación.</td>
        <td>Un <code>@RestController</code> no ejecuta sentencias SQL ni calcula impuestos; delega en el <code>@Service</code>.</td>
      </tr>
      <tr>
        <td><strong>O — Open/Closed (OCP)</strong></td>
        <td>Abierto para extensión, cerrado para modificación.</td>
        <td>Añadir una toma USB a un coche sin desmontar el motor.</td>
        <td>Crear nuevas estrategias de descuento añadiendo nuevas clases que implementan <code>EstrategiaDescuento</code> sin alterar el servicio de facturación.</td>
      </tr>
      <tr>
        <td><strong>L — Liskov Substitution (LSP)</strong></td>
        <td>Las clases derivadas deben poder sustituir a las clases base sin romper el programa.</td>
        <td>Si reemplazas una lámpara incandescente por una LED, el interruptor de la pared sigue funcionando igual.</td>
        <td>Cualquier implementación de <code>PasarelaPago</code> debe poder ser inyectada sin que el servicio de pedidos falle inesperadamente.</td>
      </tr>
      <tr>
        <td><strong>I — Interface Segregation (ISP)</strong></td>
        <td>Muchas interfaces específicas son mejores que una interfaz monolítica multipropósito.</td>
        <td>Un mando de televisión simple vs una consola de avión con 200 botones inútiles para el usuario.</td>
        <td>Dividir una interfaz gigante en <code>Imprimible</code> y <code>ExportablePDF</code> en lugar de obligar a implementar métodos vacíos.</td>
      </tr>
      <tr>
        <td><strong>D — Dependency Inversion (DIP)</strong></td>
        <td>Depender de abstracciones (interfaces), no de implementaciones concretas.</td>
        <td>Enchufar la lámpara a la red eléctrica usando un enchufe estándar en lugar de soldar los cables directamente a la pared.</td>
        <td>Inyectar <code>NotificadorService</code> (interfaz) en el controlador mediante constructor, en lugar de instanciar <code>new EmailNotificadorService()</code>.</td>
      </tr>
    </tbody>
  </table>

  <h4 id="tema-5-capas">5.3 Arquitectura en Capas: Controller, Service y Repository</h4>
  <p>
    A continuación se muestra la comparación entre un código monolítico frágil y una estructura limpia respetando SOLID y la separación en 3 capas.
  </p>

  <div class="code-block-header">❌ CÓDIGO FRÁGIL (Antipatrón Monolítico en una sola clase)</div>
  <pre><code class="language-java">// Antipatrón: Todo en la misma clase web (violación masiva de SRP y DIP)
@RestController
public class MalLibroController {

    @PostMapping("/libros-mal")
    public String crearLibro(@RequestBody String body) throws Exception {
        // Parsear manualmente (sin Spring/Jackson DTO)
        JSONObject json = new JSONObject(body);
        
        // Regla de negocio mezclada en la capa web
        double precio = json.getDouble("precio");
        if (precio &lt;= 0) throw new IllegalArgumentException("Precio inválido");

        // Conexión nativa JDBC dentro del controlador (violación de capas)
        Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/db", "root", "pass");
        PreparedStatement stmt = conn.prepareStatement("INSERT INTO libros VALUES (?, ?)");
        stmt.setString(1, json.getString("titulo"));
        stmt.setDouble(2, precio);
        stmt.executeUpdate();

        // Envío manual de email pegado en el controlador
        SendGrid sg = new SendGrid("API_KEY_SECRETA_HARDCODED");
        // ...
        return "OK";
    }
}</code></pre>

  <div class="code-block-header">✅ CÓDIGO LIMPIO EN CAPAS (SOLID & Spring Boot Best Practices)</div>
  <pre><code class="language-java">// 1. CAPA WEB: Controller limpia (Solo HTTP, validación y respuesta)
@RestController
@RequestMapping("/api/v1/libros")
@RequiredArgsConstructor
public class LibroController {

    private final LibroService libroService; // Depende de la abstracción/servicio

    @PostMapping
    public ResponseEntity&lt;LibroResponseDTO&gt; crearLibro(@Valid @RequestBody LibroCreateDTO request) {
        LibroResponseDTO creado = libroService.registrarNuevoLibro(request);
        URI location = ServletUriComponentsBuilder.fromCurrentRequest()
                .path("/{id}")
                .buildAndExpand(creado.id())
                .toUri();
        return ResponseEntity.created(location).body(creado);
    }
}

// 2. CAPA DE NEGOCIO: Service (Lógica pura y orquestación de transacciones)
@Service
@RequiredArgsConstructor
public class LibroServiceImpl implements LibroService {

    private final LibroRepository libroRepository;
    private final NotificadorService notificadorService; // DIP: Interfaz de notificación

    @Override
    @Transactional
    public LibroResponseDTO registrarNuevoLibro(LibroCreateDTO dto) {
        // Reglas de negocio puras
        if (libroRepository.existsByIsbn(dto.isbn())) {
            throw new ElementoDuplicadoException("El ISBN ya existe: " + dto.isbn());
        }

        Libro libro = new Libro(dto.titulo(), dto.isbn(), dto.precio());
        Libro guardado = libroRepository.save(libro);

        notificadorService.notificarNovedad("Nuevo libro registrado: " + guardado.getTitulo());

        return new LibroResponseDTO(guardado.getId(), guardado.getTitulo(), guardado.getPrecio());
    }
}

// 3. CAPA DE PERSISTENCIA: Spring Data Repository (Acceso a datos encapsulado)
@Repository
public interface LibroRepository extends JpaRepository&lt;Libro, Long&gt; {
    boolean existsByIsbn(String isbn);
}</code></pre>

  <h4 id="tema-5-autoconfigure">5.4 Autoconfiguración y Anotaciones Core (@SpringBootApplication)</h4>
  <p>
    La "magia" de Spring Boot para arrancar aplicaciones en segundos reside en la anotación compuesta <code>@SpringBootApplication</code>, que combina tres anotaciones fundamentales:
  </p>

  <pre><code class="language-java">@Target(ElementType.TYPE)
@Retention(RetentionPolicy.RUNTIME)
@Configuration              // 1. Define esta clase como fuente de beans de Spring
@EnableAutoConfiguration     // 2. Activa el motor condicional de autoconfiguración
@ComponentScan               // 3. Escanea paquetes para detectar @Component, @Service, @Controller, @Repository
public @interface SpringBootApplication { ... }</code></pre>

  <github-alert type="tip" title="¿Cómo funciona @EnableAutoConfiguration por dentro?">
    <p>
      Spring Boot inspecciona los archivos <code>META-INF/spring/org.springframework.boot.autoconfigure.AutoConfiguration.imports</code> de las dependencias JAR en tu classpath. Utiliza anotaciones condicionales como:
      <br>• <code>@ConditionalOnClass(DispatcherServlet.class)</code>: Si detecta la librería Web, registra automáticamente el DispatcherServlet.
      <br>• <code>@ConditionalOnMissingBean(DataSource.class)</code>: Si tú no defines un DataSource manualmente, Spring Boot crea uno por ti (ej. H2 o HikariCP).
      <br>• <code>@ConditionalOnProperty(name = "feature.evaluacion.enabled", havingValue = "true")</code>: Activa componentes solo si la propiedad existe en <code>application.properties</code>.
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
