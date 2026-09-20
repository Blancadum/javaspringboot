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
          <h3>10 — La Filosofía del Patrón DTO (Data Transfer Object)</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">10. DTO Pattern</div>
            <a href="#tema-10-peligros" class="topic-dropdown-item"><span class="item-num">10.1</span> <span class="item-title">Riesgos de Exponer Entidades JPA Directamente</span></a>
            <a href="#tema-10-records" class="topic-dropdown-item"><span class="item-num">10.2</span> <span class="item-title">Implementación de DTOs Inmutables con Java Records</span></a>
          </div>
        </details>

          <p class="topic-intro">
            Exponer directamente entidades JPA en endpoints REST es un antipatrón grave que compromete la seguridad y degrada el rendimiento. Este tema enseña a implementar el patrón DTO para definir contratos de entrada y salida desacoplados de la base de datos, aprovechando la inmutabilidad y concisión de los Java Records.
          </p>

          <github-alert type="note" title="💡 Intuición para Principiantes: ¿Por qué necesitamos DTOs? (El menú del restaurante)">
            <p>
              ¿Por qué no podemos devolver directamente la entidad <code class="kw">Libro</code> o <code class="kw">Usuario</code> que nos da la base de datos?
            </p>
            <ul>
              <li><strong>La Cocina vs El Menú</strong>: La entidad JPA es la cocina y el almacén privado del restaurante (ingredientes crudos, recetas secretas, costes internos). El <strong>DTO (Data Transfer Object)</strong> es el menú plastificado que le entregas al comensal en la mesa: solo muestra los platos que puede pedir y la información que le interesa ver.</li>
              <li><strong>Peligro de Vulnerabilidad (Mass Assignment)</strong>: Si expones la entidad directamente en un endpoint <code class="kw">POST</code> o <code class="kw">PUT</code>, un atacante podría enviar un JSON con <code class="kw">{"precio": 0.0, "version": 999}</code> y JPA lo guardaría directamente en tu base de datos sobreescribiendo valores críticos.</li>
              <li><strong>Peligro de Fuga de Información</strong>: Si la entidad <code class="kw">Usuario</code> tiene un campo <code class="kw">passwordHash</code>, devolver la entidad a través de la API enviará ese hash al navegador en texto plano.</li>
              <li><strong>Protección contra Bucles Infinitos</strong>: Como viste en la Sección 3.3, las entidades bidireccionales (`Autor` &harr; `Libro`) provocan que Jackson entre en una espiral sin fin al intentar serializar a JSON. Los DTOs cortan de raíz la recursión.</li>
            </ul>
          </github-alert>

          <h4 id="tema-10-peligros">10.1 Riesgos de Exponer Entidades JPA Directamente</h4>
          <github-alert type="caution" title="Por qué NUNCA debes retornar entidades JPA en tu API REST">
            <p>
              1. <strong>Fuga de seguridad</strong>: Exposición involuntaria de campos internos (contraseñas hasheadas, tokens de reseteo, marcas de auditoría de borrado lógico).<br>
              2. <strong>Bucles infinitos en serialización JSON</strong>: Causa común de <code class="kw">StackOverflowError</code> en relaciones bidireccionales.<br>
              3. <strong>Acoplamiento destructivo</strong>: Cambiar una tabla de la BBDD rompe el contrato JSON de las aplicaciones cliente.
            </p>
          </github-alert>

          <h4 id="tema-10-records">10.2 Implementación de DTOs Inmutables con Java Records</h4>
          <p>
            La solución estándar es usar <strong>DTOs</strong> (preferiblemente Records en Java moderno) que desacoplan el contrato exterior del esquema relacional interno:
          </p>

          <code-block lang="java">
<pre><code><span class="cmt">// Lo que el cliente envía para crear un libro</span>
<span class="kw">public record</span> <span class="typ">LibroRequestDTO</span>(
    <span class="typ">String</span> titulo,
    <span class="typ">String</span> isbn,
    <span class="typ">BigDecimal</span> precio,
    <span class="typ">Long</span> autorId
) {}

<span class="cmt">// Lo que la API devuelve (exclusivamente los datos públicos requeridos)</span>
<span class="kw">public record</span> <span class="typ">LibroResponseDTO</span>(
    <span class="typ">Long</span> id,
    <span class="typ">String</span> titulo,
    <span class="typ">BigDecimal</span> precio,
    <span class="typ">String</span> nombreAutor
) {}</code></pre>
          </code-block>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
