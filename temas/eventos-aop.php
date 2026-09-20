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
  <h3>5 — Eventos Internos y Programación Orientada a Aspectos (AOP)</h3>

  <details class="topic-dropdown">
    <summary class="topic-dropdown-trigger">
      <svg class="topic-dropdown-icon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
        <path d="M2 3.75C2 2.784 2.784 2 3.75 2h8.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 12.25 14h-8.5A1.75 1.75 0 0 1 2 12.25Zm1.75-.25a.25.25 0 0 0-.25.25v8.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25ZM4.5 5.5h7v1.5h-7Zm0 3.5h7v1.5h-7Z"/>
      </svg>
      <span>Apartados de este tema</span>
      <span class="topic-dropdown-caret">▼</span>
    </summary>
    <div class="topic-dropdown-menu">
      <div class="topic-dropdown-header">5. Eventos y AOP</div>
      <a href="#tema-5-eventos" class="topic-dropdown-item"><span class="item-num">5.1</span> <span class="item-title">Publicación y Escucha de Eventos Internos con @EventListener</span></a>
      <a href="#tema-5-transactional-events" class="topic-dropdown-item"><span class="item-num">5.2</span> <span class="item-title">Eventos Transaccionales con @TransactionalEventListener</span></a>
      <a href="#tema-5-aop-fundamentos" class="topic-dropdown-item"><span class="item-num">5.3</span> <span class="item-title">Fundamentos de Aspect-Oriented Programming (AOP)</span></a>
      <a href="#tema-5-aop-custom" class="topic-dropdown-item"><span class="item-num">5.4</span> <span class="item-title">Creación de Aspectos Personalizados para Auditoría y Trazabilidad</span></a>
    </div>
  </details>

  <p class="topic-intro">
    El desacoplamiento de componentes y la separación de incumbencias cruzadas (cross-cutting concerns) son pilares fundamentales para mantener arquitecturas mantenibles. Spring framework proporciona dos herramientas nativas clave para lograrlo: el sistema de <strong>Eventos de Aplicación</strong> y el soporte para <strong>Programación Orientada a Aspectos (AOP)</strong>.
  </p>

  <h4 id="tema-5-analogia">5.0 Intuición de la Vida Real: Las Cámaras de Seguridad y la Alarma del Banco</h4>
  <github-alert type="note" title="💡 Modelo Mental: ¿Cómo funcionan AOP y los Eventos en un Banco?">
    <p>
      Imagina una sucursal bancaria con sus cajeros, la caja fuerte y el sistema de seguridad:
    </p>
    <ul>
      <li><strong>El Cajero del Banco (Lógica de Negocio Pura / Service)</strong>: Su única responsabilidad es contar dinero, verificar el saldo e ingresarlo o entregarlo al cliente. No debería preocuparse por activar manualmente la cámara de seguridad, tomar una foto de cada cliente ni enviar un email al director.</li>
      <li><strong>Cámaras de Vigilancia en el Techo (Aspectos / AOP)</strong>: Las cámaras están colgadas en el techo interceptando silenciosamente cada movimiento. Graban cuándo entra un cliente, cuánto tarda la operación y si hay algún problema, todo sin que el cajero tenga una sola línea de código en sus manos para accionar la cámara.</li>
      <li><strong>El Pulsador de Alarma de Incendios (Eventos / ApplicationEventPublisher)</strong>: Cuando el sistema detecta que se ha completado una transferencia importante, el cajero simplemente pulsa el botón "Operación Completada" (publica un Evento). Múltiples departamentos (Impresión de recibos, Notificación SMS, Auditoría fiscal) escuchan esa alarma y reaccionan de forma totalmente independiente sin que el cajero sepa quiénes son ni cuántos hay.</li>
    </ul>
  </github-alert>

  <h4 id="tema-5-eventos">5.1 Publicación y Escucha de Eventos Internos con @EventListener</h4>
  <p>
    El patrón Publicador-Subscriptor interno permite que los componentes notifiquen cambios de estado sin conocer a los receptores. En Spring Boot 3, cualquier POJO o Java Record puede actuar como evento sin necesidad de extender ninguna clase base.
  </p>

  <div class="code-block-header">Ejemplo: Publicación de un Evento de Creación de Usuario</div>
  <pre><code class="language-java">// Evento inmutable representado como Java Record
public record UsuarioCreadoEvent(Long usuarioId, String email, Instant fechaCreacion) {}

// Servicio Publicador
@Service
@RequiredArgsConstructor
public class UsuarioService {
    private final ApplicationEventPublisher eventPublisher;
    private final UsuarioRepository usuarioRepository;

    @Transactional
    public UsuarioDTO registrarUsuario(CrearUsuarioRequest request) {
        Usuario usuario = usuarioRepository.save(new Usuario(request.nombre(), request.email()));
        
        // Emisión del evento en el ApplicationContext
        eventPublisher.publishEvent(new UsuarioCreadoEvent(usuario.getId(), usuario.getEmail(), Instant.now()));
        
        return UsuarioDTO.fromEntity(usuario);
    }
}

// Oyente (Listener) desacoplado
@Component
@Slf4j
public class NotificacionListener {

    @EventListener
    public void enviarEmailBienvenida(UsuarioCreadoEvent event) {
        log.info("Enviando correo de bienvenida al usuario ID: {} ({})", event.usuarioId(), event.email());
        // Lógica de envío de correo...
    }
}</code></pre>

  <h4 id="tema-5-transactional-events">5.2 Eventos Transaccionales con @TransactionalEventListener</h4>
  <p>
    Cuando la publicación de un evento ocurre dentro de una transacción activa de base de datos, ejecutar el oyente inmediatamente puede provocar inconsistencias si la transacción posteriormente falla (Rollback). Con <code>@TransactionalEventListener</code>, el oyente solo se ejecuta cuando la transacción ha sido confirmada satisfactoriamente (Phase <code>AFTER_COMMIT</code> por defecto).
  </p>

  <pre><code class="language-java">@Component
@Slf4j
public class AuditoriaTransaccionalListener {

    @TransactionalEventListener(phase = TransactionPhase.AFTER_COMMIT)
    public void registrarAuditoriaPostCommit(UsuarioCreadoEvent event) {
        log.info("Transacción confirmada con éxito. Registrando auditoría externa para: {}", event.usuarioId());
    }

    @TransactionalEventListener(phase = TransactionPhase.AFTER_ROLLBACK)
    public void notificarFalloTransaccion(UsuarioCreadoEvent event) {
        log.warn("La transacción de registro falló para el usuario: {}. Cancelando tareas secundarias.", event.email());
    }
}</code></pre>

  <h4 id="tema-5-aop-fundamentos">5.3 Fundamentos de Aspect-Oriented Programming (AOP)</h4>
  <p>
    La Programación Orientada a Aspectos permite encapsular comportamientos transversales (como logs, control de tiempos de ejecución, seguridad o gestión de transacciones) que de otro modo contaminarían múltiples clases de la capa de servicio.
  </p>

  <table>
    <thead>
      <tr>
        <th>Concepto AOP</th>
        <th>Definición</th>
        <th>Ejemplo en Spring</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>Aspect (Aspecto)</strong></td>
        <td>Módulo que encapsula una funcionalidad transversal.</td>
        <td>Clase anotada con <code>@Aspect</code> y <code>@Component</code>.</td>
      </tr>
      <tr>
        <td><strong>Join Point (Punto de Unión)</strong></td>
        <td>Punto candidato en la ejecución del programa donde se puede aplicar un aspecto.</td>
        <td>Ejecución de un método en un bean de Spring.</td>
      </tr>
      <tr>
        <td><strong>Pointcut (Punto de Corte)</strong></td>
        <td>Expresión de predicado que selecciona uno o varios Join Points.</td>
        <td><code>execution(* com.example.service.*.*(..))</code></td>
      </tr>
      <tr>
        <td><strong>Advice (Consejo)</strong></td>
        <td>Acción concreta ejecutada en el Join Point (Before, After, Around).</td>
        <td><code>@Around("@annotation(Auditable)")</code></td>
      </tr>
    </tbody>
  </table>

  <h4 id="tema-5-aop-custom">5.4 Creación de Aspectos Personalizados para Auditoría y Trazabilidad</h4>
  <p>
    A continuación se muestra cómo construir un aspecto personalizado para medir el tiempo de ejecución de cualquier método anotado con una anotación custom <code>@MedirTiempoExecution</code>.
  </p>

  <div class="code-block-header">Paso 1: Anotación Personalizada</div>
  <pre><code class="language-java">@Target(ElementType.METHOD)
@Retention(RetentionPolicy.RUNTIME)
public @interface MedirTiempoExecution {
    String valor() default "";
}</code></pre>

  <div class="code-block-header">Paso 2: Implementación del Aspecto con @Around</div>
  <pre><code class="language-java">@Aspect
@Component
@Slf4j
public class TrazabilidadAspect {

    @Around("@annotation(medirTiempo)")
    public Object medirTiempoEjecucion(ProceedingJoinPoint joinPoint, MedirTiempoExecution medirTiempo) throws Throwable {
        long inicio = System.currentTimeMillis();
        String nombreMetodo = joinPoint.getSignature().toShortString();

        try {
            // Ejecutar el método objetivo
            Object resultado = joinPoint.proceed();
            long duracion = System.currentTimeMillis() - inicio;
            log.info("[METRICA] El método {} [{}] finalizó en {} ms", nombreMetodo, medirTiempo.valor(), duracion);
            return resultado;
        } catch (Throwable ex) {
            long duracion = System.currentTimeMillis() - inicio;
            log.error("[ERROR METRICA] El método {} falló tras {} ms con mensaje: {}", nombreMetodo, duracion, ex.getMessage());
            throw ex;
        }
    }
}</code></pre>

  <github-alert type="tip" title="Spring AOP vs AspectJ Compile-Time Weaving">
    <p>
      Spring AOP utiliza Proxies dinámicos de Java (JDK Dynamic Proxies para interfaces o CGLIB para clases concretas) creados en tiempo de ejecución. Solo puede interceptar llamadas a métodos públicos ejecutados entre beans gestionados por Spring. Si necesitas interceptar llamadas internas dentro de la misma clase (self-invocation) o métodos privados, requerirás la compilación con AspectJ nativo.
    </p>
  </github-alert>
</article>

<?php if ($is_standalone): ?>
        </div>
      </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>
<?php endif; ?>

