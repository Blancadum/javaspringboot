// Web Components Nativos - Arquitectura Limpia, Idempotente y Cero Anidación
(function() {
  'use strict';

  // ── 1. <github-alert> ──────────────────────────────────────────────────────
  class GithubAlert extends HTMLElement {
    connectedCallback() {
      if (this._initialized) return;
      this._initialized = true;

      const type = (this.getAttribute('type') || 'note').toLowerCase();
      const title = this.getAttribute('title') || '';
      
      const icons = {
        note: 'ℹ️',
        tip: '💡',
        important: '🎯',
        warning: '⚠️',
        caution: '🚫'
      };

      const icon = icons[type] || '📌';
      if (title && !this.querySelector('.alert-title')) {
        const titleEl = document.createElement('div');
        titleEl.className = 'alert-title';
        titleEl.innerHTML = `<span>${icon}</span> <span>${title}</span>`;
        this.insertBefore(titleEl, this.firstChild);
      }
    }
  }

  // ── 2. <code-block> ────────────────────────────────────────────────────────
  class CodeBlock extends HTMLElement {
    connectedCallback() {
      if (this._initialized) return;
      this._initialized = true;

      const lang = (this.getAttribute('lang') || 'TEXT').toUpperCase();

      if (!this.querySelector('.code-header')) {
        const header = document.createElement('div');
        header.className = 'code-header';
        header.innerHTML = `
          <span class="lang-tag">${lang}</span>
          <button class="copy-btn" type="button" title="Copiar al portapapeles">Copiar</button>
        `;
        this.insertBefore(header, this.firstChild);

        const copyBtn = header.querySelector('.copy-btn');
        const codeEl = this.querySelector('pre code') || this.querySelector('pre');

        if (copyBtn && codeEl) {
          copyBtn.addEventListener('click', () => {
            const text = codeEl.innerText || codeEl.textContent;
            navigator.clipboard.writeText(text).then(() => {
              const prev = copyBtn.innerHTML;
              copyBtn.innerHTML = '✓ Copiado';
              copyBtn.style.borderColor = 'var(--color-success-emphasis)';
              copyBtn.style.color = 'var(--color-success-fg)';
              setTimeout(() => {
                copyBtn.innerHTML = prev;
                copyBtn.style.borderColor = '';
                copyBtn.style.color = '';
              }, 2000);
            }).catch(e => console.error('Error al copiar:', e));
          });
        }
      }
    }
  }

  // ── 3. <study-check> ───────────────────────────────────────────────────────
  class StudyCheck extends HTMLElement {
    connectedCallback() {
      if (this._initialized) return;
      this._initialized = true;

      const id = this.getAttribute('id') || 'task_' + Math.random().toString(36).substr(2, 9);
      const contentNodes = Array.from(this.childNodes);
      const storageKey = 'springboot_study_checklist_v1';

      let saved = {};
      try {
        saved = JSON.parse(localStorage.getItem(storageKey)) || {};
      } catch (e) {
        saved = {};
      }
      const isChecked = Boolean(saved[id]);

      const label = document.createElement('label');
      label.className = 'task-item' + (isChecked ? ' completed' : '');

      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.dataset.id = id;
      checkbox.checked = isChecked;

      const span = document.createElement('span');
      if (contentNodes.length > 0) {
        contentNodes.forEach(node => span.appendChild(node));
      } else {
        span.textContent = this.textContent || '';
      }

      label.appendChild(checkbox);
      label.appendChild(span);

      this.innerHTML = '';
      this.appendChild(label);

      checkbox.addEventListener('change', () => {
        try {
          const current = JSON.parse(localStorage.getItem(storageKey)) || {};
          if (checkbox.checked) {
            current[id] = true;
            label.classList.add('completed');
          } else {
            delete current[id];
            label.classList.remove('completed');
          }
          localStorage.setItem(storageKey, JSON.stringify(current));
        } catch (e) {
          console.error('Error al guardar progreso:', e);
        }

        window.dispatchEvent(new CustomEvent('study-progress-updated'));
      });
    }
  }

  // ── 4. <quiz-card> y <quiz-opt> ────────────────────────────────────────────
  class QuizOption extends HTMLElement {}

  class QuizCard extends HTMLElement {
    connectedCallback() {
      if (this._initialized) return;
      this._initialized = true;

      const qid = this.getAttribute('qid');
      const tag = this.getAttribute('tag') || 'General';
      const num = this.getAttribute('num') || '';

      const questionEl = this.querySelector('[slot="question"]') || this.querySelector('p');
      const questionHtml = questionEl ? questionEl.innerHTML : '';

      const options = Array.from(this.querySelectorAll('quiz-opt'));
      let optionsHtml = '';
      options.forEach(opt => {
        const val = opt.getAttribute('val');
        const text = opt.innerHTML;
        optionsHtml += `
          <label class="quiz-option">
            <input type="radio" name="${qid}" value="${val}">
            <span>${text}</span>
          </label>
        `;
      });

      this.innerHTML = `
        <div class="quiz-header">
          <span class="quiz-tag">${tag}</span>
          <span style="font-size: 11px; color: var(--color-fg-muted);">${num}</span>
        </div>
        <div class="quiz-question">${questionHtml}</div>
        <div class="quiz-options">${optionsHtml}</div>
        <div class="quiz-actions">
          <button class="btn-check-quiz" type="button">Comprobar respuesta</button>
          <button class="btn-reset-quiz" type="button">Reiniciar</button>
        </div>
        <div class="quiz-feedback"></div>
      `;

      const checkBtn = this.querySelector('.btn-check-quiz');
      const resetBtn = this.querySelector('.btn-reset-quiz');
      const feedback = this.querySelector('.quiz-feedback');
      const radios = this.querySelectorAll('input[type="radio"]');

      checkBtn.addEventListener('click', () => {
        let selected = null;
        radios.forEach(r => { if (r.checked) selected = r.value; });

        if (!selected) {
          alert('Por favor, selecciona una opción antes de comprobar.');
          return;
        }

        const data = window.getQuizAnswer ? window.getQuizAnswer(qid) : null;
        if (!data) return;

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

      resetBtn.addEventListener('click', () => {
        radios.forEach(r => r.checked = false);
        feedback.style.display = 'none';
      });
    }
  }

  // Registro de Custom Elements
  if (!customElements.get('github-alert')) customElements.define('github-alert', GithubAlert);
  if (!customElements.get('code-block')) customElements.define('code-block', CodeBlock);
  if (!customElements.get('study-check')) customElements.define('study-check', StudyCheck);
  if (!customElements.get('quiz-opt')) customElements.define('quiz-opt', QuizOption);
  if (!customElements.get('quiz-card')) customElements.define('quiz-card', QuizCard);

  // Actualizar progreso de tareas marcadas (si existe elemento específico)
  function updateGlobalProgress() {
    const allChecks = document.querySelectorAll('study-check input[type="checkbox"]');
    if (!allChecks.length) return;
    let checked = 0;
    allChecks.forEach(cb => { if (cb.checked) checked++; });
    const percent = Math.round((checked / allChecks.length) * 100);

    const fill = document.getElementById('checklist-progress-fill');
    const text = document.getElementById('checklist-progress-text');
    if (fill) fill.style.width = percent + '%';
    if (text) text.textContent = percent + '%';
  }

  window.addEventListener('study-progress-updated', updateGlobalProgress);
  document.addEventListener('DOMContentLoaded', updateGlobalProgress);
})();
