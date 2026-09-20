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

<article id="tema-2">
          <h3>2 — Serialización JSON y Jackson</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">2. JSON & Jackson</div>
            <a href="#tema-2-tipos" class="topic-dropdown-item"><span class="item-num">2.1</span> <span class="item-title">Los 6 Tipos Primitivos de JSON</span></a>
            <a href="#tema-2-jackson" class="topic-dropdown-item"><span class="item-num">2.2</span> <span class="item-title">Jackson en Spring Boot: ObjectMapper en Acción</span></a>
            <a href="#tema-2-colecciones" class="topic-dropdown-item"><span class="item-num">2.3</span> <span class="item-title">Serialización y Deserialización de Colecciones</span></a>
          </div>
        </details>

          <p class="topic-intro">
            En una arquitectura desacoplada, el servidor y el cliente se comunican a través de un formato de intercambio de datos universal: <strong>JSON (JavaScript Object Notation)</strong>. Este tema profundiza en el estándar JSON y en la librería Jackson, el motor de serialización por defecto en Spring Boot que automatiza la conversión entre objetos Java y texto JSON.
          </p>

          <h4 id="tema-2-tipos">2.1 Los 6 Tipos Primitivos de JSON</h4>
          <github-alert type="note" title="Los 6 Tipos Primitivos de JSON">
            <p>
              1. <strong>String</strong>: Texto obligatorio entre comillas dobles (<code>"texto"</code>).<br>
              2. <strong>Number</strong>: Entero o decimal sin comillas (<code>42</code>, <code>19.99</code>).<br>
              3. <strong>Boolean</strong>: <code>true</code> o <code>false</code> en minúsculas y sin comillas.<br>
              4. <strong>null</strong>: Ausencia de valor (<code>null</code>).<br>
              5. <strong>Array</strong>: Lista ordenada entre corchetes (<code>[1, 2, 3]</code>).<br>
              6. <strong>Object</strong>: Colección de pares clave-valor entre llaves (<code>{"clave": "valor"}</code>).<br>
              <em>Nota: Las comas al final del último elemento (trailing commas) son ilegales en JSON estricto.</em>
            </p>
          </github-alert>

          <h4 id="tema-2-jackson">2.2 Jackson en Spring Boot: ObjectMapper en Acción</h4>
          <p>
            En Spring Boot, Jackson viene preinstalado. Cuando un método anotado con <code>@RestController</code> devuelve un objeto Java, Jackson lo <strong>serializa</strong> a JSON automáticamente. Cuando el cliente envía un cuerpo en la petición, Jackson lo <strong>deserializa</strong> a un objeto Java.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">import</span> com.fasterxml.jackson.databind.<span class="typ">ObjectMapper</span>;
<span class="kw">import</span> com.fasterxml.jackson.core.type.<span class="typ">TypeReference</span>;
<span class="kw">import</span> java.util.<span class="typ">List</span>;

<span class="kw">public class</span> <span class="typ">JacksonDemo</span> {

    <span class="cmt">// Modelo inmutable mediante Java Record (Java 16+)</span>
    <span class="kw">public record</span> <span class="typ">LibroDTO</span>(<span class="typ">Long</span> id, <span class="typ">String</span> titulo, <span class="typ">Double</span> precio, <span class="kw">boolean</span> disponible) {}

    <span class="kw">public static void</span> <span class="fn">main</span>(<span class="typ">String</span>[] args) <span class="kw">throws</span> <span class="typ">Exception</span> {
        <span class="typ">ObjectMapper</span> mapper = <span class="kw">new</span> <span class="typ">ObjectMapper</span>();

        <span class="cmt">// 1. SERIALIZACIÓN: Java Object → JSON String</span>
        <span class="typ">LibroDTO</span> libro = <span class="kw">new</span> <span class="typ">LibroDTO</span>(1L, <span class="str">"Domain-Driven Design"</span>, 45.00, <span class="kw">true</span>);
        <span class="typ">String</span> jsonString = mapper.<span class="fn">writeValueAsString</span>(libro);
        <span class="typ">System</span>.out.<span class="fn">println</span>(<span class="str">"JSON generado: "</span> + jsonString);

        <span class="cmt">// 2. DESERIALIZACIÓN: JSON String → Java Object</span>
        <span class="typ">String</span> entradaJson = <span class="str">"""
            {"id": 2, "titulo": "Refactoring", "precio": 38.50, "disponible": true}
            """</span>;
        <span class="typ">LibroDTO</span> libroRecuperado = mapper.<span class="fn">readValue</span>(entradaJson, <span class="typ">LibroDTO</span>.<span class="kw">class</span>);
        <span class="typ">System</span>.out.<span class="fn">println</span>(<span class="str">"Título parseado: "</span> + libroRecuperado.<span class="fn">titulo</span>());

        <span class="cmt">// 3. DESERIALIZACIÓN DE COLECCIONES: Requiere TypeReference por el Type Erasure</span>
        <span class="typ">String</span> listaJson = <span class="str">"[{\"id\":10,\"titulo\":\"A\",\"precio\":10.0,\"disponible\":true}]"</span>;
        <span class="typ">List</span>&lt;<span class="typ">LibroDTO</span>&gt; libros = mapper.<span class="fn">readValue</span>(listaJson, <span class="kw">new</span> <span class="typ">TypeReference</span>&lt;<span class="typ">List</span>&lt;<span class="typ">LibroDTO</span>&gt;&gt;() {});
        <span class="typ">System</span>.out.<span class="fn">println</span>(<span class="str">"Total en lista: "</span> + libros.<span class="fn">size</span>());
    }
}</code></pre>
          </code-block>

          <h4 id="tema-2-colecciones">2.3 Serialización y Deserialización de Colecciones</h4>
          <p>
            Para listas genéricas, Jackson requiere <code>TypeReference</code> con el objetivo de preservar la información de tipos frente al <em>Type Erasure</em> de la JVM en tiempo de ejecución.
          </p>
        </article>

        <!-- TEMA 3 -->
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
