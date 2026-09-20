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

<article id="tema-4">
          <h3>4 — Core Spring (Inversión de Control y Beans)</h3>

          <details class="topic-dropdown">
          <summary class="topic-dropdown-trigger">
            <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
              <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
            </svg>
            <span>Apartados de este tema</span>
            <span class="topic-dropdown-caret">▼</span>
          </summary>
          <div class="topic-dropdown-menu">
            <div class="topic-dropdown-header">4. IoC & Beans</div>
            <a href="#tema-4-ioc" class="topic-dropdown-item"><span class="item-num">4.1</span> <span class="item-title">Inversión de Control (IoC) y Contrato de Interfaces</span></a>
            <a href="#tema-4-inyeccion" class="topic-dropdown-item"><span class="item-num">4.2</span> <span class="item-title">Inyección por Constructor y Resolución con @Primary</span></a>
            <a href="#tema-4-qualifier" class="topic-dropdown-item"><span class="item-num">4.3</span> <span class="item-title">Resolución de Ambigüedades con @Qualifier</span></a>
            <a href="#tema-4-aop" class="topic-dropdown-item"><span class="item-num">4.4</span> <span class="item-title">Programación Orientada a Aspectos (AOP) y Ciclo de Vida del Bean</span></a>
          </div>
        </details>

          <p class="topic-intro">
            El núcleo de Spring se fundamenta en la Inversión de Control (IoC), donde el <code>ApplicationContext</code> asume la responsabilidad de instanciar, configurar y ensamblar los componentes (Beans). Este tema profundiza en la inyección por constructor, la desambiguación de dependencias, el ciclo de vida del Bean y la modularización de lógica transversal mediante Spring AOP.
          </p>

          <github-alert type="note" title="💡 Intuición para Principiantes: ¿Qué es IoC y la Inyección de Dependencias?">
            <p>
              Imagina que vas a montar una lámpara en tu salón:
            </p>
            <ul>
              <li><strong>El enfoque sin IoC (Antipatrón)</strong>: Para encender la bombilla, fabricas tú mismo una pequeña central eléctrica en el jardín y tiras cables soldados hasta la lámpara (<code>new CentralElectrica()</code>). Tu lámpara está rígidamente acoplada a esa fuente de energía; si la central falla o quieres cambiar a placas solares, tienes que romper la lámpara.</li>
              <li><strong>El enfoque con IoC y Spring</strong>: Tu lámpara solo tiene una clavija universal (un <em>Constructor</em> que pide electricidad). El <strong>Contenedor de Spring es el enchufe de la pared</strong>: él decide de dónde viene la energía (red eléctrica general, batería o generador solar) y te la suministra sin que la lámpara tenga que saber cómo se generó.</li>
            </ul>
            <p>
              En código: tus clases de servicio nunca hacen <code>new</code> de sus colaboradores. Simplemente piden lo que necesitan en su constructor, y Spring se encarga de crear las instancias y conectarlas como piezas de Lego.
            </p>
          </github-alert>

          <h4 id="tema-4-ioc">4.1 Inversión de Control (IoC) y Contrato de Interfaces</h4>
          <p>
            Spring Boot potencia los pilares fundamentales de la <strong>Programación Orientada a Objetos (POO)</strong> (Abstracción, Encapsulamiento, Polimorfismo y Herencia). A través de la <strong>Inversión de Control (IoC)</strong>, el desarrollo en <strong>POO</strong> se desacopla de la instanciación manual de objetos con el operador <code>new</code>, delegando el control del ciclo de vida y las dependencias al contenedor <code>ApplicationContext</code>.
          </p>
          <p>
            La abstracción mediante interfaces desacopla a los consumidores de las implementaciones concretas, permitiendo sustituir componentes y mockear en tests sin esfuerzo.
          </p>

          <h4 id="tema-4-inyeccion">4.2 Inyección por Constructor y Resolución con @Primary</h4>
          <p>
            Cuando existen múltiples implementaciones de una misma interfaz, <code>@Primary</code> marca la candidata preferente para ser inyectada automáticamente por constructor.
          </p>

          <h4 id="tema-4-qualifier">4.3 Resolución de Ambigüedades con @Qualifier</h4>
          <p>
            Si se requiere una implementación distinta a la principal, se utiliza <code>@Qualifier("nombreBean")</code> en el parámetro del constructor para desambiguar explícitamente.
          </p>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.libreria.ioc;

<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Component</span>;
<span class="kw">import</span> org.springframework.stereotype.<span class="typ">Service</span>;
<span class="kw">import</span> org.springframework.context.annotation.<span class="typ">Primary</span>;
<span class="kw">import</span> org.springframework.beans.factory.annotation.<span class="typ">Qualifier</span>;

<span class="cmt">// 1. Contrato (Interfaz de notificación en BiblioTech)</span>
<span class="kw">public interface</span> <span class="typ">NotificacionService</span> {
    <span class="kw">void</span> <span class="fn">enviar</span>(<span class="typ">String</span> destino, <span class="typ">String</span> msg);
}

<span class="cmt">// 2. Implementación A: Notificación por Email marcada como Primaria por defecto</span>
<span class="ann">@Component</span>(<span class="str">"emailNotif"</span>)
<span class="ann">@Primary</span>
<span class="kw">public class</span> <span class="typ">EmailNotificacionService</span> <span class="kw">implements</span> <span class="typ">NotificacionService</span> {
    <span class="ann">@Override</span>
    <span class="kw">public void</span> <span class="fn">enviar</span>(<span class="typ">String</span> destino, <span class="typ">String</span> msg) {
        <span class="typ">System</span>.out.<span class="fn">println</span>(<span class="str">"[EMAIL a "</span> + destino + <span class="str">"]: "</span> + msg);
    }
}

<span class="cmt">// 3. Implementación B: Notificación urgente por SMS para avisos críticos</span>
<span class="ann">@Component</span>(<span class="str">"smsNotif"</span>)
<span class="kw">public class</span> <span class="typ">SmsNotificacionService</span> <span class="kw">implements</span> <span class="typ">NotificacionService</span> {
    <span class="ann">@Override</span>
    <span class="kw">public void</span> <span class="fn">enviar</span>(<span class="typ">String</span> destino, <span class="typ">String</span> msg) {
        <span class="typ">System</span>.out.<span class="fn">println</span>(<span class="str">"[SMS a "</span> + destino + <span class="str">"]: "</span> + msg);
    }
}

<span class="cmt">// 4. Consumo habitual: Recibe EmailNotificacionService automáticamente gracias a @Primary</span>
<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">PrestamoLibroService</span> {
    <span class="kw">private final</span> <span class="typ">NotificacionService</span> notificacion;

    <span class="kw">public</span> <span class="fn">PrestamoLibroService</span>(<span class="typ">NotificacionService</span> notificacion) {
        <span class="kw">this</span>.notificacion = notificacion;
    }
}

<span class="cmt">// 5. Consumo con @Qualifier: Desambigua explícitamente e inyecta "smsNotif"</span>
<span class="ann">@Service</span>
<span class="kw">public class</span> <span class="typ">AlertaDevolucionVencidaService</span> {
    <span class="kw">private final</span> <span class="typ">NotificacionService</span> notificacion;

    <span class="kw">public</span> <span class="fn">AlertaDevolucionVencidaService</span>(<span class="ann">@Qualifier</span>(<span class="str">"smsNotif"</span>) <span class="typ">NotificacionService</span> notificacion) {
        <span class="kw">this</span>.notificacion = notificacion;
    }
}
</code></pre>
          </code-block>
          <h4 id="tema-4-aop">4.4 Desarrollo Basado en Aspectos (Spring AOP) y Ciclo de Vida del Bean</h4>
          <p>
            La <strong>Programación Orientada a Aspectos (AOP)</strong> permite modularizar <em>preocupaciones transversales</em> (cross-cutting concerns) como auditoría, medición de rendimiento, seguridad y gestión transaccional, sin contaminar las clases de negocio:
          </p>
          <ul>
            <li><strong>Aspect (Aspecto)</strong>: Clase modularizadora anotada con <code>@Aspect</code> y <code>@Component</code>.</li>
            <li><strong>JoinPoint</strong>: Punto de ejecución del flujo (ej. invocación de cualquier método de un servicio).</li>
            <li><strong>Pointcut</strong>: Expresión de corte que selecciona qué JoinPoints interceptar (ej. <code>execution(* com.accenture.demo.service..*(..))</code>).</li>
            <li><strong>Advice</strong>: Lógica interceptora: <code>@Before</code>, <code>@After</code>, <code>@AfterReturning</code>, <code>@AfterThrowing</code> o <code>@Around</code> (el más potente, envuelve la llamada con <code>ProceedingJoinPoint</code>).</li>
          </ul>

          <code-block lang="java">
<pre><code><span class="kw">package</span> com.bibliotech.aspect;

<span class="kw">import</span> org.aspectj.lang.ProceedingJoinPoint;
<span class="kw">import</span> org.aspectj.lang.annotation.Around;
<span class="kw">import</span> org.aspectj.lang.annotation.Aspect;
<span class="kw">import</span> org.slf4j.Logger;
<span class="kw">import</span> org.slf4j.LoggerFactory;
<span class="kw">import</span> org.springframework.stereotype.Component;

<span class="ann">@Aspect</span>
<span class="ann">@Component</span>
<span class="kw">public class</span> <span class="typ">RendimientoAspect</span> {

    <span class="kw">private static final</span> <span class="typ">Logger</span> log = <span class="typ">LoggerFactory</span>.<span class="fn">getLogger</span> (<span class="typ">RendimientoAspect</span>.<span class="kw">class</span>);

    <span class="ann">@Around</span>(<span class="str">"execution(* com.bibliotech.service..*(..))"</span>)
    <span class="kw">public</span> <span class="typ">Object</span> <span class="fn">medirTiempo</span>(<span class="typ">ProceedingJoinPoint</span> joinPoint) <span class="kw">throws</span> <span class="typ">Throwable</span> {
        <span class="kw">long</span> inicio = <span class="typ">System</span>.<span class="fn">currentTimeMillis</span>();
        <span class="kw">try</span> {
            <span class="kw">return</span> joinPoint.<span class="fn">proceed</span>(); <span class="cmt">// Ejecuta el método original interceptado</span>
        } <span class="kw">finally</span> {
            <span class="kw">long</span> duracion = <span class="typ">System</span>.<span class="fn">currentTimeMillis</span>() - inicio;
            log.<span class="fn">info</span>(<span class="str">"[AOP Rendimiento] {}.{}() ejecutado en {} ms"</span>,
                joinPoint.<span class="fn">getSignature</span>().<span class="fn">getDeclaringType</span>().<span class="fn">getSimpleName</span>(),
                joinPoint.<span class="fn">getSignature</span>().<span class="fn">getName</span>(),
                duracion);
        }
    }
}</code></pre>
          </code-block>
          <h5>Mecanismo Interno de AOP: Proxies Dinámicos (JDK vs CGLIB)</h5>
          <p>
            Spring AOP no modifica el bytecode de tus archivos <code>.class</code> originales, sino que implementa el <strong>Patrón Proxy</strong> mediante envoltura en tiempo de ejecución:
          </p>
          <ul>
            <li><strong>JDK Dynamic Proxies</strong>: Si la clase a interceptar implementa una interfaz Java, Spring crea dinámicamente un proxy que implementa esa misma interfaz (mediante <code>java.lang.reflect.Proxy</code>).</li>
            <li><strong>CGLIB Proxies (estándar en Spring Boot)</strong>: Si la clase no tiene interfaz (o por defecto en Spring Boot moderno), Spring genera mediante la librería CGLIB una subclase heredada en caliente (ej. <code>PrestamoLibroService$$SpringCGLIB$$0</code>) que sobreescribe los métodos para intercalar los advices.</li>
            <li><strong>La trampa de la auto-invocación (Self-Invocation)</strong>: Si dentro de un método de <code>PrestamoLibroService</code> llamas a <code>this.metodoTransaccional()</code>, la llamada ocurre internamente en la instancia original sin pasar por el proxy de Spring, por lo que <code>@Transactional</code> o los aspectos <strong>no se ejecutarán</strong>. Para que un aspecto actúe, la invocación debe venir siempre desde un colaborador externo a través del proxy.</li>
          </ul>

          <p>
            <strong>Ciclo de vida del Bean de Spring:</strong> Comprende:
            <em>Instanciación</em> &rarr; <em>Inyección de dependencias</em> &rarr; <em>Callbacks de inicialización (<code>@PostConstruct</code>)</em> &rarr; <em>Servicio activo gestionado</em> &rarr; <em>Callbacks de destrucción (<code>@PreDestroy</code>)</em> al cerrar el contexto.
          </p>
        </article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>
