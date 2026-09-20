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
  <h3>9 — Gestión de Excepciones Globales y RFC 7807 (ProblemDetail)</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">9. Excepciones & RFC 7807</div>
      <a href="#tema-9-advice" class="topic-dropdown-item"><span class="item-num">9.1</span> <span class="item-title">Manejo Global de Excepciones con @RestControllerAdvice</span></a>
      <a href="#tema-9-rfc7807" class="topic-dropdown-item"><span class="item-num">9.2</span> <span class="item-title">El Estándar RFC 7807 (ProblemDetail) en Spring Boot 3</span></a>
      <a href="#tema-9-custom-exceptions" class="topic-dropdown-item"><span class="item-num">9.3</span> <span class="item-title">Jerarquía de Excepciones de Dominio Personalizadas</span></a>
      <a href="#tema-9-validation-errors" class="topic-dropdown-item"><span class="item-num">9.4</span> <span class="item-title">Mapeo Estructurado de Errores de Validación Bean Validation</span></a>
    </div>
  </details>

  <p class="topic-intro">
    En una API REST profesional, las respuestas de error deben ser tan consistentes y descriptivas como las respuestas exitosas. Spring Boot 3 adopta formalmente la especificación <strong>RFC 7807 (Problem Details for HTTP APIs)</strong> a través del tipo de objeto <code>ProblemDetail</code>, permitiendo estandarizar los payloads de error en todos los microservicios.
  </p>

  <h4 id="tema-9-analogia">9.0 Intuición de la Vida Real: El Parte Médico Estandarizado (RFC 7807) vs Una Nota Adhesiva Confusa</h4>
  <github-alert type="note" title="💡 Modelo Mental: ¿Por qué necesitamos un formato estandarizado de errores?">
    <p>
      Imagina que vas al hospital porque te duele el tobillo:
    </p>
    <ul>
      <li><strong>El Enfoque Caótico (Sin RFC 7807)</strong>: Un médico te da una servilleta que dice <code>"Error 500: Algo falló"</code>. Otro médico en otro piso te da un papelito que dice <code>{"msg": "mal", "code": 99}</code>. Tu seguro médico no entiende nada y el paciente queda desamparado sin saber qué ocurrió ni cómo solucionarlo.</li>
      <li><strong>El Parte Médico Estandarizado (RFC 7807 - ProblemDetail)</strong>: Todos los médicos del mundo rellenan un formulario oficial idéntico:
        <br>• <strong>Type</strong>: <code>https://hospital.com/errors/esguince-grado-2</code> (Enlace a la documentación médica del error).
        <br>• <strong>Title</strong>: <code>"Esguince de Tobillo"</code> (Título conciso).
        <br>• <strong>Status</strong>: <code>400 Bad Request</code> / <code>404 Not Found</code> (Código HTTP estándar).
        <br>• <strong>Detail</strong>: <code>"El ligamento lateral presenta una distensión tras torcedura jugando a fútbol"</code> (Explicación clara).
        <br>• <strong>Instance</strong>: <code>/pacientes/8492/urgencias/2026-09-20</code> (Identificador único del episodio).
      </li>
    </ul>
  </github-alert>

  <h4 id="tema-9-advice">9.1 Manejo Global de Excepciones con @RestControllerAdvice</h4>
  <p>
    La anotación <code>@RestControllerAdvice</code> actúa como una interceptación transversal alrededor de todos los controladores REST de la aplicación. Permite capturar cualquier excepción no controlada lanzada por la capa de servicio o controlador y traducirla en un código de estado HTTP adecuado con un payload JSON limpio.
  </p>

  <h4 id="tema-9-rfc7807">9.2 El Estándar RFC 7807 (ProblemDetail) en Spring Boot 3</h4>
  <p>
    El estándar RFC 7807 define un formato JSON unificado para representar fallos HTTP con los siguientes campos estándar:
  </p>
  <ul>
    <li><code>type</code>: URI que identifica el tipo de problema.</li>
    <li><code>title</code>: Resumen breve y legible por humanos del tipo de error.</li>
    <li><code>status</code>: Código de estado HTTP (ej. 404, 400, 409).</li>
    <li><code>detail</code>: Explicación detallada del error específico ocurrido en esta petición.</li>
    <li><code>instance</code>: URI que identifica el recurso concreto afectado o la petición procesada.</li>
  </ul>

  <div class="code-block-header">Ejemplo: Asesor Global con ProblemDetail</div>
  <pre><code class="language-java">@RestControllerAdvice
public class GlobalExceptionHandler {

    @ExceptionHandler(RecursoNoEncontradoException.class)
    public ProblemDetail handleRecursoNoEncontrado(RecursoNoEncontradoException ex, HttpServletRequest request) {
        ProblemDetail problem = ProblemDetail.forStatusAndDetail(HttpStatus.NOT_FOUND, ex.getMessage());
        problem.setTitle("Recurso No Encontrado");
        problem.setType(URI.create("https://api.empresa.com/errors/not-found"));
        problem.setInstance(URI.create(request.getRequestURI()));
        problem.setProperty("timestamp", Instant.now());
        return problem;
    }

    @ExceptionHandler(ConflictException.class)
    public ProblemDetail handleConflict(ConflictException ex, HttpServletRequest request) {
        ProblemDetail problem = ProblemDetail.forStatusAndDetail(HttpStatus.CONFLICT, ex.getMessage());
        problem.setTitle("Conflicto de Estado");
        problem.setType(URI.create("https://api.empresa.com/errors/conflict"));
        problem.setProperty("codigoErrorInterno", ex.getCodigoInterno());
        return problem;
    }
}</code></pre>

  <h4 id="tema-9-custom-exceptions">9.3 Jerarquía de Excepciones de Dominio Personalizadas</h4>
  <p>
    Para mantener limpia la capa de negocio, es recomendable crear una jerarquía base de excepciones de runtime abstractas de dominio:
  </p>

  <pre><code class="language-java">public abstract class DomainException extends RuntimeException {
    protected DomainException(String message) {
        super(message);
    }
}

public class RecursoNoEncontradoException extends DomainException {
    public RecursoNoEncontradoException(String entidad, Object id) {
        super(String.format("No se encontró %s con identificador: %s", entidad, id));
    }
}

public class SaldoInsuficienteException extends DomainException {
    public SaldoInsuficienteException(BigDecimal saldoActual, BigDecimal MontoRequerido) {
        super(String.format("Saldo insuficiente (%s €). Se requerían: %s €", saldoActual, MontoRequerido));
    }
}</code></pre>

  <h4 id="tema-9-validation-errors">9.4 Mapeo Estructurado de Errores de Validación Bean Validation</h4>
  <p>
    Cuando falla la validación de un DTO de entrada anotado con <code>@Valid</code>, Spring lanza una <code>MethodArgumentNotValidException</code>. A continuación se muestra cómo transformar esa lista de errores en un <code>ProblemDetail</code> enriquecido con la propiedad extendida <code>invalidParams</code>.
  </p>

  <pre><code class="language-java">@ExceptionHandler(MethodArgumentNotValidException.class)
public ProblemDetail handleValidacionCampos(MethodArgumentNotValidException ex) {
    ProblemDetail problem = ProblemDetail.forStatusAndDetail(
        HttpStatus.BAD_REQUEST, 
        "La petición contiene campos no válidos."
    );
    problem.setTitle("Error de Validación de Datos");
    problem.setType(URI.create("https://api.empresa.com/errors/bad-request"));

    List&lt;Map&lt;String, String&gt;&gt; invalidParams = ex.getBindingResult()
        .getFieldErrors()
        .stream()
        .map(error -&gt; Map.of(
            "field", error.getField(),
            "message", Optional.ofNullable(error.getDefaultMessage()).orElse("inválido"),
            "rejectedValue", String.valueOf(error.getRejectedValue())
        ))
        .collect(Collectors.toList());

    problem.setProperty("invalidParams", invalidParams);
    return problem;
}</code></pre>

  <github-alert type="important" title="Habilitar ProblemDetail de forma nativa en Spring Boot 3">
    <p>
      Para que los controladores nativos de Spring (como los errores 404 por defecto o los lanzados por <code>ResponseStatusException</code>) devuelvan automáticamente respuestas RFC 7807, añade la siguiente propiedad en tu <code>application.properties</code>:
      <br><code>spring.mvc.problemdetails.enabled=true</code>
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>

