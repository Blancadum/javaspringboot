# Guía de Estudio Interactiva: Spring Boot & Ecosistema Backend

Proyecto personal de estudio y referencia técnica sobre **Spring Boot**, arquitectura backend y buenas prácticas de desarrollo en Java. La web está estructurada como una guía modular con teoría, ejemplos, diagramas y contenido práctico para seguir un aprendizaje progresivo.

## ¿Qué es este proyecto?

Esta guía está pensada para estudiar de forma ordenada el ecosistema de Spring Boot y sus conceptos clave:

- fundamentos de la programación y la arquitectura
- inyección de dependencias e inversión de control
- capas y diseño del backend
- persistencia con JPA y repositorios
- validación, seguridad y testing
- buenas prácticas de diseño y mantenimiento del código

La estructura combina **contenido teórico**, **fragmentos de código reales** y **material visual** para facilitar la comprensión sin depender solo de apuntes estáticos.

## Características principales

- 📖 Diseño tipo documentación técnica con estilo GitHub/Developer
- 🧩 Bloques temáticos organizados por conceptos clave
- ☕ Ejemplos de código en Java, Spring Boot, JPA, Maven y herramientas del ecosistema
- 🖼️ Diagramas y recursos visuales integrados dentro del contenido
- 🎯 Evaluación interactiva con preguntas y retroalimentación
- 📋 Checklist de progreso guardado en el navegador
- ⚡ Buscador rápido para localizar términos relevantes
- 🌗 Soporte de tema claro/oscuro

## Estructura del proyecto

```text
.
├── bloques/                 # Contenido principal por bloques y temas
├── components/              # Cabecera, sidebar, footer y piezas reutilizables
├── css/                     # Estilos principales y theme tokens
├── img/                     # Imágenes y recursos visuales
├── js/                      # JavaScript para checklist, buscador y navegación
├── index.php                # Página principal
├── index.html               # Entrada alternativa
├── README.md                # Documentación del proyecto
├── caso-estudio.php         # Caso de estudio
├── filosofia.php            # Conceptos de filosofía y arquitectura
├── ruta.php                 # Enrutado o referencias auxiliares
└── ...
```

## Cómo ejecutar la guía localmente

### Opción 1: servidor PHP local

Desde la raíz del proyecto:

```bash
cd guia-estudio
php -S localhost:8080
```

Luego abre en el navegador:

- <http://localhost:8080/>
- o bien, si el proyecto está montado dentro de otra estructura local:
  <http://localhost:8080/proyectos/plantillas/guia-estudio/>

### Opción 2: servidor Apache local

Si estás usando Apache con tu entorno local, asegúrate de apuntar el documento raíz al directorio del proyecto y accede a la URL equivalente:

```text
http://localhost:8080/proyectos/plantillas/guia-estudio/
```

## Bloques principales

El contenido está organizado en bloques temáticos para seguir una progresión lógica de estudio, por ejemplo:

- Fundamentos
- Arquitectura y diseño
- Persistencia y repositorios
- Testing y calidad
- Seguridad y configuración
- Despliegue y buenas prácticas

## Estado del proyecto

Este repositorio funciona como una guía de estudio interactiva y de referencia técnica. Está orientado a aprendizaje práctico, con enfoque en comprensión conceptual y ejemplos aplicados.

## Autor

- LinkedIn: [blancadum](https://www.linkedin.com/in/blancadum)

---

Si quieres reutilizar o ampliar este proyecto, puedes continuar añadiendo nuevos bloques, ejemplos y ejercicios sin romper la estructura actual.
