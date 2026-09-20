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

<article id="tema-11">
          <h3>11 — Validaciones y Manejo Global de Errores</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">11. Validaciones & Errores</div>
            <a href="#tema-11-advice" class="topic-dropdown-item"><span class="item-num">11.1</span> <span class="item-title">Centralización con @RestControllerAdvice</span></a>
            <a href="#tema-11-notfound" class="topic-dropdown-item"><span class="item-num">11.2</span> <span class="item-title">Gestión de Recursos No Encontrados (404 Not Found)</span></a>
            <a href="#tema-11-validacion" class="topic-dropdown-item"><span class="item-num">11.3</span> <span class="item-title">Captura de Errores de Validación (400 Bad Request)</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Una API profesional debe garantizar que ninguna petición con datos corruptos alcance la capa de negocio y que los errores se reporten con un formato consistente. Aquí aprenderás a validar payloads con Bean Validation (<code class="kw">@Valid</code>) y a centralizar el tratamiento de excepciones mediante <code class="kw">@RestControllerAdvice</code> para generar respuestas legibles con códigos HTTP semánticos.
          </p>

          <div class="tip-box" style="background: var(--color-canvas-subtle); border-left: 4px solid var(--color-primer-border-active); padding: 16px 20px; margin: 20px 0; border-radius: 6px;">
            <h5 style="margin-top: 0; margin-bottom: 8px; font-size: 15px; color: var(--color-fg-default); display: flex; align-items: center; gap: 8px;">
              <span>💡</span> <strong>Intuición para Principiantes: ¿Por qué manejar errores de forma global? (La aduana del aeropuerto y el embajador de reclamos)</strong>
            </h5>
            <p style="margin-bottom: 10px; font-size: 13.5px; line-height: 1.6;">
              Cuando estás empezando a programar backend, es muy tentador pensar: <em>"Si algo falla, capturo la excepción con un bloque <code class="kw">try-catch</code> en el método del controlador, o simplemente dejo que Java lance el error"</em>. Sin embargo, en una aplicación real de producción como <strong>BiblioTech</strong>, esto causa dos problemas graves:
            </p>
            <ol style="margin-bottom: 12px; font-size: 13.5px; line-height: 1.6; padding-left: 20px;">
              <li><strong>Fugas de seguridad y confusión para el cliente</strong>: Si no capturas una excepción, Spring Boot responde con un <code class="kw">500 Internal Server Error</code> y una traza kilométrica (<em>Stack Trace</em>) que expone los nombres de tus archivos internos, clases y consultas SQL. Para el usuario final o la app frontend, esto es ininteligible y supone un riesgo evidente de ciberseguridad.</li>
              <li><strong>Duplicación masiva de código</strong>: Si tienes 50 endpoints y en todos repites <code class="kw">try { ... } catch (Exception e) { ... }</code>, tu código se vuelve farragoso, difícil de leer e imposible de mantener.</li>
            </ol>
            <p style="margin-bottom: 0; font-size: 13.5px; line-height: 1.6;">
              <strong>La solución en dos líneas defensivas:</strong><br>
              1. <strong>Bean Validation (<code class="kw">@Valid</code>) — El escáner de aduanas</strong>: Antes de que la petición toque tu lógica de negocio, Spring valida las anotaciones del DTO (que el ISBN no esté vacío con <code class="kw">@NotBlank</code>, que el precio no sea negativo con <code class="kw">@Positive</code>). Si algo no cumple, se rechaza al instante con <code class="kw">400 Bad Request</code> detallando campo a campo qué corregir.<br>
              2. <strong><code class="kw">@RestControllerAdvice</code> — El embajador de incidencias</strong>: Si en el servicio se produce un error de negocio (por ejemplo, buscar un libro inexistente y lanzar <code class="kw">LibroNotFoundException</code>), no necesitas <code class="kw">try-catch</code> en el controlador. La excepción sube de forma natural y este componente centralizado la atrapa para devolver un JSON limpio, estandarizado (siguiendo el estándar <em>RFC 7807 Problem Details</em>) con el código HTTP semántico correspondiente (<code class="kw">404 Not Found</code>).
            </p>
          </div>

          <h4 id="tema-11-advice">11.1 Centralización con @RestControllerAdvice</h4>
          <p>
            <code class="kw">@RestControllerAdvice</code> actúa como un interceptor global para todas las excepciones del controlador, unificando el formato de respuesta de error en toda la API de BiblioTech.
          </p>

          <h4 id="tema-11-notfound">11.2 Gestión de Recursos No Encontrados (404 Not Found)</h4>
          <p>
            Captura excepciones de negocio personalizadas como <code class="kw">LibroNotFoundException</code> y devuelve un DTO de error con timestamp, código 404 y URI de la petición.
          </p>

          <h4 id="tema-11-validacion">11.3 Captura de Errores de Validación (400 Bad Request)</h4>
          <p>
            Procesa las infracciones de Bean Validation (<code class="kw">@NotNull</code>, <code class="kw">@NotBlank</code>, <code class="kw">@Positive</code>, etc.) mapeando cada campo a su mensaje de error explicativo para la aplicación cliente.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.exception;

<span class="kw">import</span> org.springframework.http.*;
<span class="kw">import</span> org.springframework.web.bind.<span class="typ">MethodArgumentNotValidException</span>;
<span class="kw">import</span> org.springframework.web.bind.annotation.*;
<span class="kw">import</span> jakarta.servlet.http.<span class="typ">HttpServletRequest</span>;
<span class="kw">import</span> java.time.<span class="typ">Instant</span>;
<span class="kw">import</span> java.util.*;

<span class="cmt">// 1. Excepción de dominio personalizada para BiblioTech</span>
<span class="kw">public class</span> <span class="typ">LibroNotFoundException</span> <span class="kw">extends</span> <span class="typ">RuntimeException</span> {
    <span class="kw">public</span> <span class="fn">LibroNotFoundException</span>(<span class="typ">Long</span> id) {
        <span class="kw">super</span>(<span class="str">"El libro con ID "</span> + id + <span class="str">" no fue encontrado en el catálogo de BiblioTech."</span>);
    }
}

<span class="cmt">// 2. Interceptor global de errores (@RestControllerAdvice)</span>
<span class="ann">@RestControllerAdvice</span>
<span class="kw">public class</span> <span class="typ">GlobalExceptionHandler</span> {

    <span class="kw">public record</span> <span class="typ">ErrorResponse</span>(<span class="typ">Instant</span> timestamp, <span class="kw">int</span> status, <span class="typ">String</span> error, <span class="typ">String</span> mensaje, <span class="typ">String</span> path) {}

    <span class="cmt">// Captura errores de negocio: 404 Not Found</span>
    <span class="ann">@ExceptionHandler</span>(<span class="typ">LibroNotFoundException</span>.<span class="kw">class</span>)
    <span class="kw">public</span> <span class="typ">ResponseEntity</span>&lt;<span class="typ">ErrorResponse</span>&gt; <span class="fn">handleLibroNotFound</span>(<span class="typ">LibroNotFoundException</span> ex, <span class="typ">HttpServletRequest</span> req) {
        <span class="typ">ErrorResponse</span> err = <span class="kw">new</span> <span class="typ">ErrorResponse</span>(<span class="typ">Instant</span>.<span class="fn">now</span>(), 404, <span class="str">"Not Found"</span>, ex.<span class="fn">getMessage</span>(), req.<span class="fn">getRequestURI</span>());
        <span class="kw">return</span> <span class="typ">ResponseEntity</span>.<span class="fn">status</span>(<span class="typ">HttpStatus</span>.NOT_FOUND).<span class="fn">body</span>(err);
    }

    <span class="cmt">// Captura fallos en Bean Validation (@Valid): 400 Bad Request</span>
    <span class="ann">@ExceptionHandler</span>(<span class="typ">MethodArgumentNotValidException</span>.<span class="kw">class</span>)
    <span class="kw">public</span> <span class="typ">ResponseEntity</span>&lt;<span class="typ">Map</span>&lt;<span class="typ">String</span>, <span class="typ">Object</span>&gt;&gt; <span class="fn">handleValidation</span>(<span class="typ">MethodArgumentNotValidException</span> ex) {
        <span class="typ">Map</span>&lt;<span class="typ">String</span>, <span class="typ">String</span>&gt> errores = <span class="kw">new</span> <span class="typ">HashMap</span>&lt;&gt;();
        ex.<span class="fn">getBindingResult</span>().<span class="fn">getFieldErrors</span>().<span class="fn">forEach</span>(err -&gt; errores.<span class="fn">put</span>(err.<span class="fn">getField</span>(), err.<span class="fn">getDefaultMessage</span>()));

        <span class="typ">Map</span>&lt;<span class="typ">String</span>, <span class="typ">Object</span>&gt; body = <span class="kw">new</span> <span class="typ">HashMap</span>&lt;&gt;();
        body.<span class="fn">put</span>(<span class="str">"timestamp"</span>, <span class="typ">Instant</span>.<span class="fn">now</span>());
        body.<span class="fn">put</span>(<span class="str">"status"</span>, 400);
        body.<span class="fn">put</span>(<span class="str">"error"</span>, <span class="str">"Bad Request - Validación Fallida en Payload"</span>);
        body.<span class="fn">put</span>(<span class="str">"errores"</span>, errores);

        <span class="kw">return</span> <span class="typ">ResponseEntity</span>.<span class="fn">badRequest</span>().<span class="fn">body</span>(body);
    }
}</code></pre>
          </code-block>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
