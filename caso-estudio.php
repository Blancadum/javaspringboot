<?php include_once __DIR__ . '/components/header.php'; ?>
<?php include_once __DIR__ . '/components/sidebar.php'; ?>

    <main class="main-wrapper markdown-body">
      <div class="content-grid">
        <div class="content-main">
          <!-- CASO DE ESTUDIO PRÁCTICO TRANSVERSAL: BIBLIOTECH -->
      <section id="caso-estudio-bibliotech" class="study-section">
        <h2>📚 Caso Práctico Conductor: Plataforma BiblioTech</h2>

        <github-alert type="tip" title="Un Hilo Conductor Real: Aprendizaje Fluido de Principio a Fin">
          <p>
            Uno de los mayores obstáculos al aprender arquitectura backend por primera vez es encontrarse con fragmentos aislados y desconectados (un ejemplo bancario por aquí, un pedido por allá y un usuario por otro lado). En esta guía, <strong>cada concepto teórico se aplica y se demuestra sobre una única aplicación real: la plataforma BiblioTech (Sistema Integral de Biblioteca Digital & Catálogo Editorial)</strong>.
          </p>
          <p>
            A lo largo de los 6 bloques temáticos, verás nacer el sistema desde sus cimientos: cómo viajan las peticiones HTTP a su API, cómo se modelan sus libros y autores en la base de datos, cómo se ejecutan transacciones seguras de préstamo, cómo se protegen los endpoints con JWT y cómo se empaqueta el microservicio en Docker.
          </p>
        </github-alert>

        <h3>1. Mapa del Dominio de BiblioTech: Entidades y Relaciones</h3>
        <p>
          El dominio de BiblioTech está diseñado para cubrir de manera natural todas las situaciones a las que te enfrentarás en proyectos empresariales reales:
        </p>

        <table>
          <thead>
            <tr>
              <th style="width: 22%;">Entidad / Componente</th>
              <th style="width: 28%;">Tipo de Mapeo / Rol</th>
              <th style="width: 50%;">Atributos Clave y Propósito en BiblioTech</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><code>Autor</code></td>
              <td>Entidad JPA (<code>@Entity</code>, Lado Inverso)</td>
              <td><code>id</code>, <code>nombre</code>, <code>nacionalidad</code>, <code>biografia</code>. Contiene la colección bidireccional <code>List&lt;Libro&gt; libros</code> con <code>@OneToMany(mappedBy = "autor")</code>.</td>
            </tr>
            <tr>
              <td><code>Libro</code></td>
              <td>Entidad JPA Central (Lado Propietario)</td>
              <td><code>id</code>, <code>isbn</code> (único), <code>titulo</code>, <code>precio</code>, <code>sinopsis</code> (<code>@Lob</code>), <code>estado</code> (<code>@Enumerated</code>), <code>version</code> (<code>@Version</code>), relación <code>@ManyToOne</code> con <code>Autor</code> y <code>@ManyToMany</code> con <code>Categoria</code>.</td>
            </tr>
            <tr>
              <td><code>Categoria</code></td>
              <td>Entidad JPA (Catálogo temático)</td>
              <td><code>id</code>, <code>nombre</code> (Novela, Ciencia Ficción, Tecnología), <code>descripcion</code>. Vinculada a <code>Libro</code> mediante la tabla de unión física <code>libros_categorias</code>.</td>
            </tr>
            <tr>
              <td><code>DimensionesLibro</code></td>
              <td>Objeto de Valor (<code>@Embeddable</code>)</td>
              <td><code>altoCm</code>, <code>anchoCm</code>, <code>grosorCm</code>, <code>pesoGramos</code>. Se incrusta directamente (<code>@Embedded</code>) como columnas dentro de la tabla de libros sin requerir una tabla adicional.</td>
            </tr>
            <tr>
              <td><code>Publicacion</code></td>
              <td>Herencia Polimórfica (<code>@Inheritance</code>)</td>
              <td>Clase base abstracta con estrategia <code>JOINED</code>. Sus subclases concretas son:
                <br>• <code>LibroFisico</code>: <code>numeroPaginas</code>, <code>ubicacionEstanteria</code>, <code>ejemplaresDisponibles</code>.
                <br>• <code>LibroDigital</code>: <code>tamanoArchivoMb</code>, <code>formatoDescarga</code> (EPUB/PDF), <code>tieneDrm</code>.
              </td>
            </tr>
            <tr>
              <td><code>PrestamoLibro</code></td>
              <td>Entidad Transaccional ACID</td>
              <td><code>id</code>, <code>fechaPrestamo</code>, <code>fechaDevolucionLimite</code>, <code>lectorId</code>, referencia a <code>Libro</code>. Gestionado con <code>@Transactional</code> para asegurar que el descuento de ejemplares y el registro del préstamo ocurran de forma atómica.</td>
            </tr>
          </tbody>
        </table>

        <h3>2. Hoja de Ruta Práctica: Qué Construiremos en Cada Bloque</h3>
        <table>
          <thead>
            <tr>
              <th>Bloque</th>
              <th>Módulo Desarrollado en BiblioTech</th>
              <th>Puesta en Práctica Concreta</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Bloque 1</strong></td>
              <td>Fundamentos, HTTP y Core</td>
              <td>Peticiones HTTP a <code>/api/v1/libros</code>, Servlets primitivos de catálogo, serialización JSON de libros con Jackson, dependencias en Maven, Lombok en <code>Libro</code> y prevención del bucle infinito JPA con <code>Autor</code>. Inversión de Control para enviar notificaciones a lectores por Email/SMS.</td>
            </tr>
            <tr>
              <td><strong>Bloque 2</strong></td>
              <td>Arquitectura y Persistencia Core</td>
              <td>Controlador <code>LibroController</code> con respuestas semánticas (<code>ResponseEntity</code>), capa <code>LibroService</code> inyectada por constructor, transacciones ACID para prestar libros y mapeo de entidades con Hibernate.</td>
            </tr>
            <tr>
              <td><strong>Bloque 3</strong></td>
              <td>Relaciones Avanzadas y DTOs</td>
              <td>Asociaciones 1:N y N:M, consultas JPQL por autor y precio, solución al problema N+1 con <code>JOIN FETCH</code> y contratos seguros con <code>LibroRequestDTO</code> y <code>LibroResponseDTO</code> usando Java Records.</td>
            </tr>
            <tr>
              <td><strong>Bloque 4</strong></td>
              <td>Calidad, Observabilidad y RestClient</td>
              <td>Validaciones de ISBN y precio con Bean Validation, captura global de <code>LibroNotFoundException</code> con <code>@RestControllerAdvice</code>, documentación OpenAPI Swagger y cliente <code>OpenLibraryClient</code> con <code>RestClient</code>.</td>
            </tr>
            <tr>
              <td><strong>Bloque 5</strong></td>
              <td>Testing Automatizado</td>
              <td>Pruebas unitarias de <code>LibroService</code> con dobles simulados (Mockito) y pruebas de integración web de los endpoints con <code>@WebMvcTest</code> / <code>@SpringBootTest</code>, y técnicas profesionales de depuración y diagnóstico.</td>
            </tr>
            <tr>
              <td><strong>Bloque 6</strong></td>
              <td>Seguridad y Despliegue Cloud</td>
              <td>Seguridad stateless con JWT, hashing seguro con BCrypt, control RBAC (<code>@PreAuthorize</code>), contenedorización Docker multi-stage y microservicios síncronos vs asíncronos (Kafka / RabbitMQ).</td>
            </tr>
          </tbody>
        </table>

        <h3>3. 💡 La Guía del Principiante: 5 Conceptos Clave que Debes Saber Antes de Empezar</h3>
        <p>
          Si es la primera vez que estudias desarrollo backend profesional, estos 5 conceptos forman el mapa mental indispensable sobre el que se apoya toda la arquitectura:
        </p>

        <ol>
          <li>
            <strong>¿Qué es un Servidor Backend y por qué no lo hace todo el navegador?</strong><br>
            El navegador web (Frontend) se ejecuta en el ordenador del usuario y puede ser manipulado fácilmente abriendo las herramientas de desarrollador (F12). Si el navegador se conectara directamente a la base de datos o calculara los precios y saldos, cualquier usuario malintencionado podría alterar los valores. El <strong>Backend</strong> es un entorno seguro, controlado por la empresa, donde residen las reglas de negocio, la lógica confidencial y el acceso restringido a los datos.
          </li>
          <li>
            <strong>¿Qué es una API REST y por qué hablamos en JSON?</strong><br>
            Una API REST es como la ventanilla de atención al público de un organismo oficial: tiene una serie de trámites bien definidos (URLs como <code>/api/v1/libros</code>) a los que llamamos usando acciones universales (Verbos HTTP como GET, POST, PUT, DELETE). Para que cualquier aplicación (una web en React, una app móvil en Flutter o un microservicio en Python) se entienda con nuestro backend en Java, intercambiamos información en <strong>JSON</strong>, un formato de texto universal basado en parejas de <code>"clave": "valor"</code>.
          </li>
          <li>
            <strong>¿Por qué usamos un Framework (Spring Boot) en lugar de Java básico?</strong><br>
            Construir una aplicación web en Java estándar "puro" implicaría configurar manualmente un servidor HTTP, gestionar hilos de ejecución concurrentes, escribir cientos de líneas de código JDBC para abrir y cerrar conexiones a la base de datos, y crear a mano cada objeto. <strong>Spring Boot es como un chasis de ingeniería prediseñado</strong>: incluye un servidor web integrado (Tomcat), autoconfigura la conexión a la base de datos y conecta automáticamente todas las piezas del sistema mediante Inversión de Control (IoC).
          </li>
          <li>
            <strong>¿Qué es un ORM (Hibernate / JPA) y por qué lo necesitamos?</strong><br>
            En Java trabajamos con <em>Objetos</em> organizados en memoria (un libro tiene un autor, el autor tiene una lista de libros, etc.). En cambio, las bases de datos relacionales como PostgreSQL u Oracle trabajan con <em>Tablas</em> bidimensionales de filas y columnas vinculadas por números de clave foránea. Esta diferencia se conoce como el <em>desajuste de impedancia objeto-relacional</em>. <strong>JPA/Hibernate actúa como un traductor simultáneo automático</strong>: lee una fila de la tabla SQL y la convierte en un objeto Java en milisegundos, y cuando modificas el objeto en Java, genera automáticamente las sentencias <code>UPDATE</code> o <code>INSERT</code> necesarias.
          </li>
          <li>
            <strong>¿Por qué separamos la aplicación en 3 Capas (Controlador → Servicio → Repositorio)?</strong><br>
            Imagina un restaurante de alta cocina:
            <ul>
              <li><strong>Controlador (El Camarero)</strong>: Recibe al cliente, toma la comanda, comprueba que los datos básicos sean coherentes y la traslada a la cocina. No cocina ni entra a la despensa.</li>
              <li><strong>Servicio (El Chef)</strong>: Contiene la maestría culinaria (reglas de negocio). Decide los tiempos, verifica si hay ingredientes suficientes, ejecuta la receta y coordina la entrega.</li>
              <li><strong>Repositorio (El Encargado del Almacén)</strong>: Es el único con llave de la despensa (Base de Datos). El chef le pide "tráeme el ingrediente X" o "guarda este paquete Y".</li>
            </ul>
            Esta separación garantiza que si mañana cambias de base de datos o de formato de presentación, las reglas de negocio (el chef) permanezcan intactas y sean fáciles de probar.
          </li>
        </div> <!-- Fin de content-main -->

        <aside class="topic-toc" id="dynamic-toc">
          <ul id="toc-list">
            <!-- Generado dinámicamente por app.js -->
          </ul>
        </aside>
      </div> <!-- Fin de content-grid -->
    </main>

<?php include_once __DIR__ . '/components/footer.php'; ?>
