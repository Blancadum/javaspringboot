<?php
  $in_bloque_context = true;
  include_once __DIR__ . '/components/header.php';
  include_once __DIR__ . '/components/sidebar.php';
?>

<main class="main-wrapper markdown-body">
  <div class="content-grid">
    <div class="content-main">
      <section id="primeros-pasos" class="study-section">
        <h2>Instalación y primeros pasos</h2>

        <p class="topic-intro">
          Antes de escribir tu primera anotación <code>@RestController</code> o configurar tu primera entidad JPA, es fundamental comprender qué herramientas conforman el ecosistema backend moderno, <strong>por qué existe cada una</strong> y cuáles son las diferencias clave entre el lenguaje Java, el framework Spring y la plataforma Spring Boot.
        </p>

        <!-- SECCIÓN 1: DISTINCIÓN CONCEPTUAL -->
        <article class="resource-panel resource-panel-primary" style="margin-bottom: 30px;">
          <div class="resource-panel-header">
            <h3>🏛️ 1. Java vs. Spring Framework vs. Spring Boot: No son lo mismo</h3>
          </div>

          <p>
            Uno de los errores más comunes al iniciarse en el desarrollo backend en Java es confundir el lenguaje de programación con los frameworks que lo rodean. A continuación desglosamos la jerarquía y evolución de estas tres capas:
          </p>

          <github-alert type="important" title="La Evolución del Backend en Java">
            <p>
              • <strong>Java (El Lenguaje y la JVM)</strong>: Creado por Sun Microsystems en 1995 (ahora mantenido por Oracle). Es el lenguaje de programación tipado y el motor de ejecución (Java Virtual Machine). Proporciona la sintaxis básica, las estructuras de datos (List, Map) y la orientación a objetos.
              <br><br>
              • <strong>Spring Framework (La Base de Inversión de Control)</strong>: Creado por Rod Johnson en 2002 para sustituir los pesados e ineficientes EJB (Enterprise JavaBeans) de Java EE. Introdujo la <strong>Inversión de Control (IoC)</strong> y la <strong>Inyección de Dependencias (DI)</strong>. Sin embargo, configurar Spring Framework clásico requería escribir cientos de líneas de XML complejo y configurar manualmente los servidores web.
              <br><br>
              • <strong>Spring Boot (La Capa de Autoconfiguración Opinada)</strong>: Lanzado en 2014 por Pivotal (ahora VMware/Broadcom). <strong>Spring Boot NO es un framework distinto de Spring</strong>: es una capa inteligente sobre Spring Framework que elimina la configuración XML mediante <em>opiniones por defecto</em> y servidores Tomcat embebidos.
            </p>
          </github-alert>

          <table>
            <thead>
              <tr>
                <th>Tecnología</th>
                <th>Rol Principal</th>
                <th>Analogía de la Vida Real</th>
                <th>Ejemplo de Código / Configuración</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Java (LTS 17/21)</strong></td>
                <td>Lenguaje y Máquina Virtual (JVM)</td>
                <td>El motor de combustión y los materiales del coche.</td>
                <td><code>public class Libro { private String titulo; }</code></td>
              </tr>
              <tr>
                <td><strong>Spring Framework</strong></td>
                <td>Contenedor IoC, DI y AOP</td>
                <td>El chasis, la dirección asistida y el sistema eléctrico.</td>
                <td><code>@Service public class LibroService { ... }</code> (Configuración XML o <code>@Configuration</code> manual).</td>
              </tr>
              <tr>
                <td><strong>Spring Boot 3</strong></td>
                <td>Autoconfiguración opinada y ejecutable</td>
                <td>El coche terminado de fábrica con arranque por botón, GPS y aire acondicionado automático.</td>
                <td><code>@SpringBootApplication public class App { main() }</code> (Arriba en puerto 8080 en 2 segundos sin XML).</td>
              </tr>
            </tbody>
          </table>

          <h4 style="margin-top: 24px;">🚀 ¿Qué hay de nuevo en el ecosistema actual (Java 21 & Spring Boot 3)?</h4>
          <ul>
            <li><strong>Java 17 & Java 21 LTS (Virtual Threads / Project Loom)</strong>: Hilos virtuales ultraligeros que permiten manejar cientos de miles de peticiones HTTP concurrentes sin agotar la memoria de la JVM.</li>
            <li><strong>Spring Boot 3.x</strong>: Migración obligatoria a <strong>Jakarta EE 10</strong> (cambio del paquete <code>javax.*</code> a <code>jakarta.*</code>), soporte nativo para compilar a binarios superrápidos con <strong>GraalVM Native Image</strong> y estándar <strong>RFC 7807 (ProblemDetail)</strong> para respuestas de error REST.</li>
          </ul>
        </article>

        <!-- SECCIÓN 2: HERRAMIENTAS INDISPENSABLES -->
        <article class="resource-panel" style="margin-bottom: 30px;">
          <div class="resource-panel-header">
            <h3>🛠️ 2. El Ecosistema de Herramientas: Instalación y Razón de Ser</h3>
          </div>

          <p>
            Para construir y mantener proyectos empresariales, un desarrollador Spring Boot necesita un conjunto de utilidades complementarias. A continuación explicamos la función de cada una y <strong>por qué son estrictamente necesarias</strong>:
          </p>

          <div class="glossary-list resource-glossary-list">
            
            <!-- 1. JDK -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>☕ 1. JDK 17 / 21 LTS (Java Development Kit)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> El Kit de Desarrollo oficial que contiene el compilador de código (<code>javac</code>) y el motor de ejecución (<code>JVM</code>).</p>
                <p><strong>¿Por qué es necesario?</strong> Sin el JDK es imposible compilar clases <code>.java</code> ni ejecutar aplicaciones en tu máquina. Para trabajar con Spring Boot 3 es obligatorio contar con <strong>Java 17 o Java 21 LTS</strong> (distribuciones recomendadas: Eclipse Temurin u OpenJDK).</p>
                <code># Comprobar versión en la terminal
java -version
javac -version</code>
              </div>
            </div>

            <!-- 2. MAVEN / GRADLE -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>📦 2. Apache Maven / Gradle (Gestor de Construcción)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> La herramienta que gestiona el ciclo de vida del proyecto, descarga librerías de internet y empaqueta el resultado final.</p>
                <p><strong>¿Por qué es necesario?</strong> Una aplicación Spring Boot utiliza decenas de librerías externas (Jackson, Hibernate, Drivers de Base de Datos). Maven lee el archivo <code>pom.xml</code>, descarga automáticamente las versiones correctas y empaqueta tu proyecto en un archivo <code>.jar</code> ejecutable con Tomcat embebido.</p>
                <code># Comando para compilar y empaquetar sin instalar Maven global
./mvnw clean package</code>
              </div>
            </div>

            <!-- 3. IDE -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>💻 3. Entorno de Desarrollo (IntelliJ IDEA / VS Code)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> El editor especializado donde escribes y depuras el código fuente.</p>
                <p><strong>¿Por qué es necesario?</strong> Proporciona autocompletado inteligente para anotaciones de Spring Boot, detecta errores de sintaxis antes de compilar, ofrece refactorizaciones automáticas y permite ejecutar el proyecto en modo depuración (<em>Debug</em>) con puntos de interrupción.</p>
              </div>
            </div>

            <!-- 4. LOMBOK VS RECORDS -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>🌶️ 4. Project Lombok vs. Java Records (El Dilema del Código Repetitivo)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué son?</strong> Dos soluciones para eliminar el código repetitivo (*boilerplate*) como getters, setters, constructores y métodos <code>equals/hashCode</code>.</p>
                <p><strong>¿Por qué son necesarios y cómo se combinan?</strong></p>
                <ul>
                  <li><strong>Project Lombok (Librería + Plugin)</strong>: Procesa anotaciones en compilación (<code>@Data</code>, <code>@Getter</code>, <code>@Builder</code>, <code>@RequiredArgsConstructor</code>). Es la solución ideal para <strong>Entidades JPA mutables</strong> que requieren constructores complejos o patrones Builder.</li>
                  <li><strong>Java Records (Característica Nativa de Java 16+)</strong>: Define clases inmutables concisas (<code>public record LibroDTO(Long id, String titulo) {}</code>). Es el estándar recomendado para <strong>DTOs de entrada y salida en APIs REST</strong>.</li>
                </ul>
                <code>// Lombok en Entidades JPA (Base de Datos):
@Entity @Getter @Setter @NoArgsConstructor @AllArgsConstructor
public class Libro { @Id private Long id; private String titulo; }

// Java Record en DTOs (API REST):
public record LibroResponseDTO(Long id, String titulo, Double precio) {}</code>
              </div>
            </div>

            <!-- 5. SONARQUBE & SONARLINT -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>🛡️ 5. SonarQube & SonarLint (Calidad de Código y Análisis Estático)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> Plataforma e inspectores de análisis estático de código que auditan la calidad del software sin necesidad de ejecutarlo.</p>
                <p><strong>¿Por qué es necesario en entornos profesionales?</strong></p>
                <ul>
                  <li><strong>Detección de Bugs y Code Smells</strong>: Identifica variables no utilizadas, nulos no controlados (<code>NullPointerException</code>) o métodos demasiado complejos.</li>
                  <li><strong>Seguridad (Vulnerabilidades OWASP)</strong>: Alerta sobre contraseñas o tokens hardcodeados en el código, inyecciones SQL o configuraciones de CORS inseguras.</li>
                  <li><strong>Cobertura de Test y Deuda Técnica</strong>: Mide el porcentaje de código cubierto por pruebas unitarias e indica cuántas horas costaría corregir el código defectuoso antes de pasar a producción.</li>
                </ul>
                <code>Tip: Instala el plugin gratuito "SonarLint" en tu IDE (IntelliJ o VS Code) para recibir alertas de calidad en tiempo real mientras escribes código.</code>
              </div>
            </div>

            <!-- 6. DOCKER & DOCKER DESKTOP -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>🐳 6. Docker & Docker Desktop (Bases de Datos y Servicios en Contenedores)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> Una plataforma de virtualización mediante contenedores ligeros e independientes.</p>
                <p><strong>¿Por qué es necesario?</strong> Te permite arrancar bases de datos reales (PostgreSQL, MySQL), almacenes de caché (Redis) o gestores de eventos (Kafka) con un archivo <code>docker-compose.yml</code> en 5 segundos, sin necesidad de instalar servidores nativos pesados en tu ordenador personal.</p>
                <code># Ejemplo de arranque de PostgreSQL con Docker Compose
docker compose up -d</code>
              </div>
            </div>

            <!-- 7. CLIENTES HTTP -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>📮 7. Clientes HTTP (Postman, Bruno, cURL)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> Aplicaciones para ejecutar y simular peticiones HTTP hacia tu backend.</p>
                <p><strong>¿Por qué es necesario?</strong> Las APIs REST devuelven respuestas en formato JSON sin interfaz web visual. Un cliente HTTP permite enviar peticiones <code>POST</code>, <code>PUT</code> o <code>DELETE</code> pasando cuerpos JSON, probar encabezados de seguridad (tokens JWT) y verificar los códigos de estado HTTP (200, 201, 400, 404, 500).</p>
              </div>
            </div>

            <!-- 8. GIT & GITHUB -->
            <div class="glossary-item">
              <button class="glossary-trigger" type="button" aria-expanded="true">
                <span>🐙 8. Git & GitHub (Control de Versiones y Repositorio Cloud)</span>
                <span class="glossary-toggle-indicator">-</span>
              </button>
              <div class="glossary-content">
                <p><strong>¿Qué es?</strong> Git es el sistema de control de versiones distribuido local y GitHub la plataforma en la nube para alojar tu código.</p>
                <p><strong>¿Por qué es necesario?</strong> Te permite guardar puntos de restauración de tu avance, trabajar en ramas desacopladas y subir tus proyectos a la nube para construir tu portafolio técnico profesional.</p>
              </div>
            </div>

          </div>
        </article>

        <!-- SECCIÓN 3: RUTA PASO A PASO -->
        <article class="resource-roadmap-panel resource-panel">
          <div class="resource-panel-header">
            <h3>🧭 3. Guía Paso a Paso para Configurar tu Entorno de Desarrollo</h3>
          </div>

          <div class="roadmap-grid">
            <div class="roadmap-level roadmap-level-beginner">
              <h4>Paso 1: Instalación del Motor</h4>
              <ul>
                <li>Descargar e instalar **JDK 17 o 21 LTS** (ej. Eclipse Temurin).</li>
                <li>Verificar en terminal con <code>java -version</code>.</li>
                <li>Instalar **IntelliJ IDEA Community** o **VS Code** con el plugin *SonarLint*.</li>
              </ul>
            </div>

            <div class="roadmap-level roadmap-level-intermediate">
              <h4>Paso 2: Generar el Proyecto</h4>
              <ul>
                <li>Entrar en <a href="https://start.spring.io" target="_blank" rel="noreferrer">start.spring.io</a>.</li>
                <li>Seleccionar **Maven**, **Java 17/21** y **Spring Boot 3.x**.</li>
                <li>Añadir dependencias: <code>Spring Web</code>, <code>Lombok</code>, <code>Spring Data JPA</code>.</li>
                <li>Descargar el ZIP, descomprimir y abrir en el IDE.</li>
              </ul>
            </div>

            <div class="roadmap-level roadmap-level-advanced">
              <h4>Paso 3: Entorno Profesional</h4>
              <ul>
                <li>Instalar **Docker Desktop** y crear un <code>docker-compose.yml</code> para PostgreSQL.</li>
                <li>Instalar **Postman** o **Bruno** para probar tus endpoints REST.</li>
                <li>Inicializar Git (<code>git init</code>) y publicar tu repositorio en GitHub.</li>
              </ul>
            </div>
          </div>
        </article>

      </section>
    </div>
  </div>
</main>

<?php include_once __DIR__ . '/components/footer.php'; ?>

