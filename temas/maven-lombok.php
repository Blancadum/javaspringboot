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

<article id="tema-3">
          <h3>3 — Apache Maven y Reducción de Código con Lombok</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">3. Maven & Lombok</div>
            <a href="#tema-3-estructura" class="topic-dropdown-item"><span class="item-num">3.1</span> <span class="item-title">Estructura Estándar de Maven</span></a>
            <a href="#tema-3-lombok" class="topic-dropdown-item"><span class="item-num">3.2</span> <span class="item-title">Lombok: Eliminación de Boilerplate y Patrón Builder</span></a>
            <a href="#tema-3-data-danger" class="topic-dropdown-item"><span class="item-num">3.3</span> <span class="item-title">@Data en Entidades JPA: El Bucle infinito (StackOverflowError)</span></a>
          </div>
        </details>

          <p class="topic-intro">
            La base de cualquier proyecto Java profesional reside en la reproducibilidad de su compilación y la limpieza de su código fuente. Aquí dominarás el ciclo de vida de Apache Maven (<code>pom.xml</code>, dependencias transitivas y plugins) junto con el uso riguroso de Project Lombok para eliminar código repetitivo sin comprometer el encapsulamiento.
          </p>

          <github-alert type="note" title="💡 Intuición para Principiantes: ¿Qué problemas resuelven Maven y Lombok?">
            <p>
              Cuando programas en Java por primera vez, dos tareas consumen el 70% de tu tiempo si no tienes las herramientas adecuadas:
            </p>
            <ul>
              <li><strong>Maven (El Jefe de Logística)</strong>: En lugar de buscar manualmente por internet decenas de ficheros <code>.jar</code> de librerías, descárgalos a mano y resolver conflictos de versiones, defines lo que necesitas en el <code>pom.xml</code>. Maven descarga automáticamente todas las dependencias y sus transitivas, compila el código y empaqueta el archivo <code>.jar</code> ejecutable con un solo comando (<code>mvn clean package</code>).</li>
              <li><strong>Lombok (El Asistente Mecanógrafo)</strong>: En Java estándar, crear una clase de datos con 5 propiedades exige escribir más de 60 líneas repetitivas (*boilerplate*: getters, setters, constructores, <code>equals</code>, <code>hashCode</code> y <code>toString</code>). Lombok lee tus anotaciones y genera todo ese código automáticamente en memoria durante la compilación, manteniendo tus clases limpias y legibles.</li>
            </ul>
          </github-alert>

          <h4 id="tema-3-estructura">3.1 Estructura Estándar de Maven</h4>
          <code-block lang="text">
<pre><code>mi-proyecto-spring/
├── pom.xml                     ← Fichero maestro de configuración y dependencias
└── src/
    ├── main/
    │   ├── java/               ← Código fuente de la aplicación (.java)
    │   └── resources/          ← Ficheros de configuración (application.properties, schemas)
    └── test/
        ├── java/               ← Pruebas unitarias e integración
        └── resources/          ← Configuración aislada de test</code></pre>
          </code-block>

          <h4 id="tema-3-lombok">3.2 Lombok: Eliminación de Boilerplate y Patrón Builder</h4>
          <code-block lang="java">
<pre><code><span class="kw">package</span> com.libreria.model;

<span class="kw">import</span> lombok.*;
<span class="kw">import</span> java.math.<span class="typ">BigDecimal</span>;

<span class="ann">@Getter</span>
<span class="ann">@Setter</span>
<span class="ann">@NoArgsConstructor</span>
<span class="ann">@AllArgsConstructor</span>
<span class="ann">@Builder</span>
<span class="kw">public class</span> <span class="typ">Libro</span> {
    <span class="kw">private</span> <span class="typ">Long</span> id;
    <span class="kw">private</span> <span class="typ">String</span> isbn;
    <span class="kw">private</span> <span class="typ">String</span> titulo;
    <span class="kw">private</span> <span class="typ">BigDecimal</span> precio;
    <span class="kw">private</span> <span class="typ">String</span> editorial;
}

<span class="cmt">// Uso elegante del patrón Builder generado automáticamente en BiblioTech:</span>
<span class="typ">Libro</span> cleanCode = <span class="typ">Libro</span>.<span class="fn">builder</span>()
    .<span class="fn">isbn</span>(<span class="str">"978-0132350884"</span>)
    .<span class="fn">titulo</span>(<span class="str">"Clean Code"</span>)
    .<span class="fn">precio</span>(<span class="typ">BigDecimal</span>.<span class="fn">valueOf</span>(39.95))
    .<span class="fn">editorial</span>(<span class="str">"Prentice Hall"</span>)
    .<span class="fn">build</span>();</code></pre>
          </code-block>

          <h4 id="tema-3-data-danger">3.3 @Data en Entidades JPA: El Bucle infinito (StackOverflowError)</h4>
          <p>
            En el desarrollo con Lombok, <code>@Data</code> es una de las anotaciones más populares debido a su comodidad: combina automáticamente <code>@Getter</code>, <code>@Setter</code>, <code>@ToString</code>, <code>@EqualsAndHashCode</code> y <code>@RequiredArgsConstructor</code> sobre <strong>todos</strong> los campos de una clase.
          </p>

          <p>
            Sin embargo, <strong>utilizar <code>@Data</code> sobre entidades JPA (Jakarta Persistence / Hibernate) es uno de los errores más graves en arquitecturas Spring Boot</strong>. Provoca el temido fenómeno del <strong>bucle infinito (recursión cíclica)</strong> que satura la pila de ejecución y colapsa la aplicación con un error irrecuperable: <code>java.lang.StackOverflowError</code>.
          </p>

          <figure class="readme-figure full-width">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1040 530" width="100%" height="auto" role="img" aria-label="Bucle infinito por @Data en JPA: StackOverflowError por recursión circular entre toString() de Autor y Libro">
              <defs>
                <style>
                  .bg { fill: #ffffff; stroke: #d0d7de; stroke-width: 1.2; rx: 8px; }
                  .header-title { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 700; fill: #0f172a; }
                  .header-desc { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 13.5px; fill: #475569; }
                  .badge-danger-bg { fill: #fee2e2; stroke: #fca5a5; stroke-width: 1; rx: 4px; }
                  .badge-danger-txt { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 700; fill: #b91c1c; }

                  .card-bg { fill: #f8fafc; stroke: #cbd5e1; stroke-width: 1.2; rx: 6px; }
                  .card-header-bg { fill: #f1f5f9; stroke: #cbd5e1; stroke-width: 1; rx: 6px; }
                  .card-title { font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace; font-size: 15px; font-weight: 700; fill: #0284c7; }
                  .card-badge-bg { fill: #e0f2fe; stroke: #7dd3fc; stroke-width: 0.8; rx: 3px; }
                  .card-badge-txt { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 10.5px; font-weight: 600; fill: #0369a1; }

                  .code-txt { font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace; font-size: 12px; fill: #0f172a; }
                  .code-kw { fill: #dc2626; font-weight: 600; }
                  .code-ann { fill: #7c3aed; font-weight: 600; }
                  .code-typ { fill: #c2410c; }
                  .code-cmt { fill: #64748b; font-style: italic; }
                  .code-err { fill: #dc2626; font-weight: bold; }

                  .loop-box-bg { fill: #fef9c3; stroke: #ca8a04; stroke-width: 1.5; rx: 6px; }
                  .loop-box-title { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 13px; font-weight: 700; fill: #854d0e; text-anchor: middle; }
                  .loop-box-desc { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 11.5px; fill: #713f12; text-anchor: middle; }

                  .arrow-cycle { fill: none; stroke: #dc2626; stroke-width: 3.5; stroke-linecap: round; stroke-dasharray: 6 3; }
                  .arrow-label { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 11.5px; font-weight: 600; fill: #b91c1c; text-anchor: middle; }

                  .stack-box-bg { fill: #ffffff; stroke: #dc2626; stroke-width: 1.5; rx: 6px; }
                  .stack-header-txt { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 11.5px; font-weight: 700; fill: #b91c1c; }
                  .stack-frame-danger { fill: #fee2e2; stroke: #f87171; stroke-width: 1; }
                  .stack-frame-danger-txt { font-family: "SFMono-Regular", Consolas, monospace; font-size: 11.5px; font-weight: 700; fill: #b91c1c; text-anchor: middle; }
                  .stack-frame { fill: #f1f5f9; stroke: #cbd5e1; stroke-width: 1; }
                  .stack-frame-txt { font-family: "SFMono-Regular", Consolas, monospace; font-size: 11px; fill: #1e293b; text-anchor: middle; }

                  .sol-bg { fill: #f0fdf4; stroke: #4ade80; stroke-width: 1.5; rx: 6px; }
                  .sol-badge-bg { fill: #16a34a; rx: 3px; }
                  .sol-badge-txt { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 10.5px; font-weight: 700; fill: #ffffff; }
                  .sol-txt-bold { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700; fill: #16a34a; }
                </style>
              </defs>
              <rect class="bg" x="0" y="0" width="1040" height="530" />
              <text class="header-title" x="520" y="40" text-anchor="middle">El Fenómeno del Bucle Infinito en JPA (Recursión Circular)</text>
              <text class="header-desc" x="520" y="65" text-anchor="middle">Análisis de colapso de pila por @Data en relaciones bidireccionales</text>

              <rect class="card-bg" x="60" y="100" width="360" height="220" />
              <rect class="card-header-bg" x="60" y="100" width="360" height="35" />
              <text class="card-title" x="80" y="122" text-anchor="start">Entidad Autor</text>
              <text class="card-badge-txt" x="380" y="122" text-anchor="end">@Entity</text>
              <text class="code-txt" x="80" y="155" text-anchor="start">private String nombre;</text>
              <text class="code-txt" x="80" y="175" text-anchor="start">private List&lt;Libro&gt; libros;</text>
              <text class="code-txt" x="80" y="195" text-anchor="start" fill="#b91c1c">@Override public String toString() {</text>
              <text class="code-txt" x="80" y="215" text-anchor="start">  return "Autor{nombre=" + nombre + ", libros=" + libros + "}";</text>
              <text class="code-txt" x="80" y="235" text-anchor="start">}</text>

              <rect class="card-bg" x="620" y="100" width="360" height="220" />
              <rect class="card-header-bg" x="620" y="100" width="360" height="35" />
              <text class="card-title" x="640" y="122" text-anchor="start">Entidad Libro</text>
              <text class="card-badge-txt" x="960" y="122" text-anchor="end">@Entity</text>
              <text class="code-txt" x="640" y="155" text-anchor="start">private String titulo;</text>
              <text class="code-txt" x="640" y="175" text-anchor="start">private Autor autor;</text>
              <text class="code-txt" x="640" y="195" text-anchor="start" fill="#b91c1c">@Override public String toString() {</text>
              <text class="code-txt" x="640" y="215" text-anchor="start">  return "Libro{titulo=" + titulo + ", autor=" + autor + "}";</text>
              <text class="code-txt" x="640" y="235" text-anchor="start">}</text>

              <path class="arrow-cycle" d="M420 160 C 480 160, 520 160, 560 160" stroke-linecap="round" />
              <text class="arrow-label" x="490" y="150" text-anchor="middle">1. Autor.toString() llama a libros.toString()</text>
              <path class="arrow-cycle" d="M560 260 C 520 260, 480 260, 420 260" stroke-linecap="round" />
              <text class="arrow-label" x="490" y="275" text-anchor="middle">2. Libro.toString() llama a autor.toString()</text>

              <rect class="loop-box-bg" x="460" y="340" width="120" height="60" />
              <text class="loop-box-title" x="520" y="355" text-anchor="middle">Bucle Infinito</text>
              <text class="loop-box-desc" x="520" y="375" text-anchor="middle">Recursión Circular</text>

              <rect class="stack-box-bg" x="700" y="340" width="280" height="150" />
              <text class="stack-header-txt" x="720" y="355" text-anchor="start">JVM Stack Trace</text>
              <rect class="stack-frame-danger" x="710" y="365" width="260" height="25" />
              <text class="stack-frame-danger-txt" x="840" y="382" text-anchor="middle">Autor.toString()</text>
              <rect class="stack-frame" x="710" y="390" width="260" height="25" />
              <text class="stack-frame-txt" x="840" y="407" text-anchor="middle">Libro.toString()</text>
              <rect class="stack-frame" x="710" y="415" width="260" height="25" />
              <text class="stack-frame-txt" x="840" y="432" text-anchor="middle">Autor.toString()</text>
              <rect class="stack-frame" x="710" y="440" width="260" height="25" />
              <text class="stack-frame-txt" x="840" y="462" text-anchor="middle">Libro.toString()</text>
              <text class="stack-frame-danger-txt" x="840" y="482" text-anchor="middle">StackOverflowError</text>

              <rect class="sol-bg" x="100" y="340" width="320" height="100" />
              <rect class="sol-badge-bg" x="110" y="345" width="60" height="20" />
              <text class="sol-badge-txt" x="120" y="360" text-anchor="middle">SOLUCIÓN</text>
              <text class="sol-txt-bold" x="120" y="380" text-anchor="start">Excluir el campo recursivo en @ToString</text>
              <text class="code-txt" x="120" y="400" text-anchor="start">@ToString.Exclude la relación bidireccional</text>
              <text class="code-txt" x="120" y="420" text-anchor="start">Usar @Getter/@Setter en lugar de @Data</text>
            </svg>
          </figure>
        </article>

        <!-- TEMA 4 -->
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
