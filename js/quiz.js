// Interactive 360° Knowledge Check & Self-Evaluation Engine
(function() {
  const quizDatabase = {
    q1: {
      correct: 'b',
      explanation: '<strong>Correcto (201 Created):</strong> Según la especificación HTTP REST, cuando una petición POST resulta en la creación exitosa de un nuevo recurso, el servidor debe retornar <code>201 Created</code> (idealmente acompañado de la cabecera <code>Location: /api/v1/libros/42</code>). El código <code>200 OK</code> se reserva para consultas GET o actualizaciones PUT/PATCH exitosas que devuelven payload, y <code>204 No Content</code> para borrados.'
    },
    q2: {
      correct: 'c',
      explanation: '<strong>Correcto (PATCH):</strong> El verbo <code>PATCH</code> está diseñado para modificaciones parciales (modificar solo el atributo <code>precio</code>). El verbo <code>PUT</code> requiere el reemplazo completo de la representación del recurso (idempotente total).'
    },
    q3: {
      correct: 'b',
      explanation: '<strong>Correcto (403 Forbidden):</strong> <code>401 Unauthorized</code> significa <em>"Falta autenticación"</em> (no sé quién eres, identifícate con un token). <code>403 Forbidden</code> significa <em>"Falta autorización"</em> (sé perfectamente quién eres, pero tu rol o permisos no te permiten acceder/borrar este recurso).'
    },
    q4: {
      correct: 'a',
      explanation: '<strong>Correcto (Dependencias Descendentes):</strong> La regla de oro establece que las dependencias viajan estrictamente de Presentación → Negocio → Datos. La capa de Datos nunca debe conocer a Negocio ni invocarla, y la Presentación no debe saltarse a Negocio para acceder directamente a Datos, pues rompería el encapsulamiento de las reglas de negocio.'
    },
    q5: {
      correct: 'd',
      explanation: '<strong>Correcto ({ "precio": 29.99 }):</strong> En JSON, las claves deben ir obligatoriamente entre comillas dobles <code>"..."</code>, los números no llevan comillas, no se admiten comentarios y las comas finales (trailing commas) están estrictamente prohibidas.'
    },
    q6: {
      correct: 'a',
      explanation: '<strong>Correcto (ObjectMapper & TypeReference):</strong> Para deserializar un array JSON a una colección genérica como <code>List&lt;Libro&gt;</code>, Jackson necesita <code>new TypeReference&lt;List&lt;Libro&gt;&gt;(){}</code> para superar la eliminación de tipos en tiempo de compilación (Type Erasure) de Java.'
    },
    q7: {
      correct: 'b',
      explanation: '<strong>Correcto (Ciclo de vida secuencial):</strong> En Maven, ejecutar una fase invoca automáticamente todas las fases previas en orden: <code>validate → compile → test → package</code>. Por tanto, los tests unitarios siempre se ejecutan antes del empaquetado.'
    },
    q8: {
      correct: 'c',
      explanation: '<strong>Correcto (Peligro de @Data en JPA):</strong> <code>@Data</code> incluye automáticamente <code>@EqualsAndHashCode</code> y <code>@ToString</code> usando todos los campos. En entidades JPA con relaciones bidireccionales (ej. <code>Autor ↔ Libros</code>), esto desencadena llamadas recursivas infinitas y un fatídico <code>StackOverflowError</code>.'
    },
    q9: {
      correct: 'b',
      explanation: '<strong>Correcto (Acoplamiento y Mocks):</strong> Al crear una dependencia con <code>new ServicioConcreto()</code>, la clase queda estrechamente atada a esa implementación. En tests unitarios es imposible sustituirla por un mock simulado (Mockito), obligando a levantar dependencias reales innecesarias.'
    },
    q10: {
      correct: 'a',
      explanation: '<strong>Correcto (@RestController = @Controller + @ResponseBody):</strong> <code>@Controller</code> está pensado para MVC clásico donde se retornan nombres de vistas HTML (Thymeleaf/JSP). <code>@RestController</code> serializa automáticamente el objeto devuelto por el método a JSON mediante Jackson y lo escribe directo en el cuerpo HTTP.'
    },
    q11: {
      correct: 'b',
      explanation: '<strong>Correcto (Singleton & Stateless):</strong> Por defecto, Spring crea una sola instancia compartida de cada Bean para toda la aplicación. Al ser invocado por múltiples hilos concurrentes simultáneamente, los Beans NO deben almacenar estado mutable en variables de instancia (deben ser stateless).'
    },
    q12: {
      correct: 'c',
      explanation: '<strong>Correcto (@Qualifier):</strong> Cuando coexisten múltiples implementaciones de una misma interfaz, <code>@Qualifier("nombreBean")</code> desambigua explícitamente en el punto de inyección cuál bean concreto debe suministrar el contenedor.'
    },
    q13: {
      correct: 'a',
      explanation: '<strong>Correcto (FetchType.LAZY):</strong> Las relaciones a colecciones (<code>@OneToMany</code>) deben ser perezosas (<code>LAZY</code>) por defecto para evitar cargar en memoria miles de registros innecesarios y prevenir el problema de rendimiento de consultas N+1.'
    },
    q14: {
      correct: 'd',
      explanation: '<strong>Correcto (Desacoplamiento con DTOs):</strong> Exponer entidades JPA en la API expone la estructura interna de la base de datos, corre el riesgo de bucles de serialización JSON y genera sobreexposición de campos sensibles (como contraseñas o datos de auditoría).'
    },
    q15: {
      correct: 'a',
      explanation: '<strong>Correcto (@ControllerAdvice + @ExceptionHandler):</strong> Permite interceptar de forma centralizada cualquier excepción lanzada en la capa de controladores y transformarla en una respuesta HTTP estructurada y predecible (con código de estado y JSON coherente).'
    },
    q16: {
      correct: 'b',
      explanation: '<strong>Correcto (@Mock vs @InjectMocks):</strong> <code>@Mock</code> crea un objeto simulado vacío; <code>@InjectMocks</code> crea una instancia real de la clase que queremos testear e inyecta automáticamente en ella todos los mocks declarados con <code>@Mock</code>.'
    },
    q17: {
      correct: 'a',
      explanation: '<strong>Correcto (Stateless & Cabecera Authorization):</strong> En una API REST segura, el servidor no guarda sesiones en memoria (<code>SessionCreationPolicy.STATELESS</code>). Cada petición del cliente debe adjuntar la cabecera <code>Authorization: Bearer &lt;token&gt;</code>, la cual es validada en cada paso por un filtro como <code>OncePerRequestFilter</code>.'
    }
  };

  function initQuiz() {
    const quizContainers = document.querySelectorAll('.quiz-box');
    if (!quizContainers.length) return;

    quizContainers.forEach(container => {
      const qId = container.dataset.questionId;
      const checkBtn = container.querySelector('.btn-check-quiz');
      const resetBtn = container.querySelector('.btn-reset-quiz');
      const feedback = container.querySelector('.quiz-feedback');
      const radios = container.querySelectorAll('input[type="radio"]');

      if (!checkBtn || !quizDatabase[qId]) return;

      checkBtn.addEventListener('click', () => {
        let selected = null;
        radios.forEach(r => {
          if (r.checked) selected = r.value;
        });

        if (!selected) {
          alert('Por favor, selecciona una opción antes de comprobar.');
          return;
        }

        const data = quizDatabase[qId];
        feedback.className = 'quiz-feedback';
        if (selected === data.correct) {
          feedback.classList.add('correct');
          feedback.innerHTML = '✅ ' + data.explanation;
        } else {
          feedback.classList.add('incorrect');
          feedback.innerHTML = '❌ <strong>Respuesta incorrecta.</strong><br>' + data.explanation;
        }
        feedback.style.display = 'block';
      });

      if (resetBtn) {
        resetBtn.addEventListener('click', () => {
          radios.forEach(r => r.checked = false);
          feedback.style.display = 'none';
        });
      }
    });
  }

  // Exponer API para el Web Component <quiz-card>
  window.getQuizAnswer = function(id) {
    return quizDatabase[id] || null;
  };

  document.addEventListener('DOMContentLoaded', initQuiz);
})();


