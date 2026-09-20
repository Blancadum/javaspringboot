document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('glossary-search');
  const glossaryList = document.querySelector('.glossary-list');
  if (!glossaryList) return;

  // Spanish prepositions and articles/conjunctions (stop words to exclude from indexing)
  const SPANISH_STOP_WORDS = new Set([
    'a', 'ante', 'bajo', 'cabe', 'con', 'contra', 'de', 'desde', 'durante',
    'en', 'entre', 'hacia', 'hasta', 'mediante', 'para', 'por', 'segun',
    'sin', 'so', 'sobre', 'tras', 'versus', 'via', 'el', 'la', 'los', 'las',
    'un', 'una', 'unos', 'unas', 'y', 'o', 'u', 'del', 'al'
  ]);

  let DB_ITEMS = [];
  let dropdownMenu = null;

  // Create an empty state element if non-existent
  let emptyMsg = glossaryList.querySelector('.glossary-empty-msg');
  if (!emptyMsg) {
    emptyMsg = document.createElement('div');
    emptyMsg.className = 'glossary-empty-msg';
    emptyMsg.style.display = 'none';
    emptyMsg.style.padding = '16px';
    emptyMsg.style.textAlign = 'center';
    emptyMsg.style.color = 'var(--color-fg-muted)';
    emptyMsg.style.fontSize = '13px';
    emptyMsg.style.background = 'var(--color-canvas-subtle)';
    emptyMsg.style.borderRadius = '8px';
    emptyMsg.style.border = '1px solid var(--color-border-default)';
    emptyMsg.style.margin = '10px 0';
    glossaryList.appendChild(emptyMsg);
  }

  function getBaseUrl() {
    return window.BASE_URL || '/';
  }

  function resolveTargetUrl(target) {
    const bUrl = getBaseUrl();
    const temaHierarchicalSlugs = {
      1: 'fundamentos/arquitectura-web-http',
      2: 'fundamentos/json-jackson',
      3: 'fundamentos/maven-lombok',
      4: 'fundamentos/core-spring-ioc',
      5: 'fundamentos/eventos-aop',
      6: 'core-spring-boot/solid-capas',
      7: 'core-spring-boot/rest-responseentity',
      8: 'core-spring-boot/servicios-di',
      9: 'core-spring-boot/excepciones-problemdetail',
      10: 'core-spring-boot/hibernate-orm',
      11: 'persistencia-dtos/asociaciones-consultas',
      12: 'persistencia-dtos/dtos-repositorios',
      13: 'persistencia-dtos/mapstruct-specifications',
      14: 'calidad-ops/validaciones-errores',
      15: 'calidad-ops/logs-perfiles-swagger',
      16: 'calidad-ops/actuator-observabilidad',
      17: 'testing/junit5-mockito',
      18: 'testing/spring-boot-test',
      19: 'testing/testcontainers-wiremock',
      20: 'seguridad-docker/jwt-docker',
      21: 'seguridad-docker/oauth2-security'
    };

    if (!target) return `${bUrl}index`;

    if (target.startsWith('tema-')) {
      const match = target.match(/tema-(\d+)/);
      if (match) {
        const num = Number.parseInt(match[1], 10);
        const slug = temaHierarchicalSlugs[num] || `tema-${num}`;
        return `${bUrl}${slug}#${target}`;
      }
    } else if (target.startsWith('filo-')) {
      return `${bUrl}filosofia#${target}`;
    } else if (target.startsWith('http-') || target.startsWith('codigos-')) {
      return `${bUrl}ruta#${target}`;
    }

    return `${bUrl}fundamentos#${target}`;
  }

  async function loadDatabase() {
    try {
      const bUrl = getBaseUrl();
      const res = await fetch(`${bUrl}js/search-db.json`);
      if (res.ok) {
        DB_ITEMS = await res.json();
      }
    } catch (e) {
      console.warn('Glossary DB fetch error', e);
    }
  }

  function normalizeStr(str) {
    return (str || '')
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/ñ/g, 'n');
  }

  function extractTokens(str) {
    const clean = normalizeStr(str);
    if (!clean) return [];
    const rawTokens = clean.split(/[\s,/\-\(\)\[\]\{\}\.:;'"?!<>#]+/).filter(Boolean);
    const tokens = new Set();

    rawTokens.forEach((token) => {
      tokens.add(token);
      if (token.startsWith('@')) {
        const stripped = token.replace(/^@+/, '');
        if (stripped) tokens.add(stripped);
      }
    });

    return Array.from(tokens).filter((word) => !SPANISH_STOP_WORDS.has(word));
  }

  function matchesItem(item, rawQuery) {
    const trimmed = (rawQuery || '').trim();
    if (!trimmed) return false;

    const isOnlyAtSymbol = (trimmed === '@');
    if (isOnlyAtSymbol) {
      return (
        (item.term && item.term.startsWith('@')) ||
        item.badge === '@' ||
        (item.badgeClass && item.badgeClass.includes('badge-annotation'))
      );
    }

    const normQuery = normalizeStr(trimmed);
    const cleanQuery = normQuery.replace(/^@+/, '');
    if (!cleanQuery) return false;

    if (SPANISH_STOP_WORDS.has(cleanQuery)) {
      return false;
    }

    const termStr = item.term || '';
    const topicStr = item.topic || '';
    const descStr = item.desc || '';
    const aliasesStr = (item.aliases || []).join(' ');

    const titleAndKeyHaystack = `${termStr} ${aliasesStr} ${topicStr}`;
    const wordsInTitleAndKeys = extractTokens(titleAndKeyHaystack);

    if (trimmed.startsWith('@')) {
      const normTerm = normalizeStr(termStr);
      if (normTerm.startsWith('@' + cleanQuery) || normTerm.replace(/^@+/, '').startsWith(cleanQuery)) {
        return true;
      }
    }

    if (cleanQuery.length <= 2) {
      if (wordsInTitleAndKeys.some((word) => word.startsWith(cleanQuery))) {
        return true;
      }
    } else {
      if (wordsInTitleAndKeys.some((word) => word.startsWith(cleanQuery) || word.includes(cleanQuery))) {
        return true;
      }
    }

    if (cleanQuery.length >= 4) {
      const descWords = extractTokens(descStr);
      return descWords.some((word) => word.startsWith(cleanQuery) || word.includes(cleanQuery));
    }

    return false;
  }

  function escapeHtml(str) {
    return String(str || '')
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;');
  }

  function renderDynamicResults(matchedItems) {
    glossaryList.querySelectorAll('.glossary-item-dynamic').forEach((el) => el.remove());
    glossaryList.querySelectorAll('.glossary-item:not(.glossary-item-dynamic)').forEach((el) => {
      el.style.display = 'none';
    });

    matchedItems.forEach((item) => {
      const targetUrl = resolveTargetUrl(item.target);
      const card = document.createElement('div');
      card.className = 'glossary-item glossary-item-dynamic';
      card.style.display = 'flex';
      card.style.flexDirection = 'column';

      const badgeHtml = item.badge
        ? `<span class="gh-badge ${escapeHtml(item.badgeClass || '')}" style="margin-left: 8px;">${escapeHtml(item.badge)}</span>`
        : '';

      const topicHtml = item.topic
        ? `<span style="font-size: 11px; font-weight: 600; color: var(--color-accent-fg); margin-bottom: 4px; display: inline-block;">${escapeHtml(item.topic)}</span>`
        : '';

      card.innerHTML = `
        <button class="glossary-trigger" type="button" aria-expanded="true" style="padding: 12px 16px;">
          <span style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
            <strong>${escapeHtml(item.term)}</strong>
            ${badgeHtml}
          </span>
          <span class="glossary-toggle-indicator">−</span>
        </button>
        <div class="glossary-content" style="padding: 0 16px 16px; display: flex; flex-direction: column; gap: 8px;">
          ${topicHtml}
          <p style="margin: 0; font-size: 13px; line-height: 1.5; color: var(--color-fg-muted);">${escapeHtml(item.desc)}</p>
          <a href="${targetUrl}" class="glossary-topic-link" style="align-self: flex-start; margin-top: 4px; font-size: 12.5px; font-weight: 600; color: var(--color-accent-fg); text-decoration: none;">Ver tema en el manual →</a>
        </div>
      `;

      glossaryList.insertBefore(card, emptyMsg);
    });
  }

  // ── Desplegable Interactivo para el símbolo @ ─────────────────────────
  function closeAnnotationDropdown() {
    if (dropdownMenu && dropdownMenu.parentNode) {
      dropdownMenu.parentNode.removeChild(dropdownMenu);
      dropdownMenu = null;
    }
  }

  function renderAnnotationDropdown(rawQuery) {
    if (!searchInput) return;

    const atIndex = rawQuery.indexOf('@');
    if (atIndex === -1) {
      closeAnnotationDropdown();
      return;
    }

    const filterText = normalizeStr(rawQuery.substring(atIndex + 1));
    const annotationItems = DB_ITEMS.filter((item) => {
      const isAnnotation = (item.term && item.term.startsWith('@')) || item.badge === '@';
      if (!isAnnotation) return false;
      if (!filterText) return true;
      const cleanTerm = normalizeStr(item.term).replace(/^@+/, '');
      return cleanTerm.startsWith(filterText) || normalizeStr(item.term).includes(filterText);
    });

    if (annotationItems.length === 0) {
      closeAnnotationDropdown();
      return;
    }

    const container = searchInput.parentNode;
    if (!dropdownMenu) {
      dropdownMenu = document.createElement('div');
      dropdownMenu.className = 'annotation-dropdown-menu';
      container.appendChild(dropdownMenu);
    }

    dropdownMenu.innerHTML = '';
    annotationItems.forEach((item) => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'annotation-dropdown-item';
      btn.innerHTML = `
        <span class="annotation-dropdown-badge">@</span>
        <span class="annotation-dropdown-term">${escapeHtml(item.term)}</span>
        <span class="annotation-dropdown-desc">${escapeHtml(item.desc)}</span>
      `;

      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        searchInput.value = item.term;
        closeAnnotationDropdown();
        filterGlossary();
        searchInput.focus();
      });

      dropdownMenu.appendChild(btn);
    });
  }

  const filterGlossary = () => {
    const rawQuery = searchInput ? searchInput.value.trim() : '';

    // Si el input está vacío, no se muestra ningún resultado (0 items mostrados)
    if (!rawQuery) {
      glossaryList.querySelectorAll('.glossary-item-dynamic').forEach((el) => el.remove());
      glossaryList.querySelectorAll('.glossary-item:not(.glossary-item-dynamic)').forEach((el) => {
        el.style.display = 'none';
      });
      if (emptyMsg) emptyMsg.style.display = 'none';
      closeAnnotationDropdown();
      return;
    }

    // Gestionar desplegable de anotaciones si la consulta contiene '@'
    if (rawQuery.includes('@')) {
      renderAnnotationDropdown(rawQuery);
    } else {
      closeAnnotationDropdown();
    }

    if (DB_ITEMS.length > 0) {
      const matches = DB_ITEMS.filter((item) => matchesItem(item, rawQuery));
      renderDynamicResults(matches);

      if (emptyMsg) {
        if (matches.length === 0) {
          emptyMsg.textContent = `No se encontraron términos para "${rawQuery}". Pruebe a escribir pistas como "@RestController", "DTO", "JWT", "Clean Code" o "Mockito".`;
          emptyMsg.style.display = 'block';
        } else {
          emptyMsg.style.display = 'none';
        }
      }
    }
  };

  // Click listener for accordion toggle on dynamic items
  glossaryList.addEventListener('click', (e) => {
    if (e.target.closest('a')) return;

    const trigger = e.target.closest('.glossary-trigger, .glossary-item');
    if (!trigger) return;

    const item = trigger.closest('.glossary-item');
    if (!item) return;

    const content = item.querySelector('.glossary-content');
    if (!content) return;

    const isOpen = content.style.display !== 'none' && !content.hidden;
    if (isOpen) {
      content.style.display = 'none';
      content.hidden = true;
    } else {
      content.style.display = 'flex';
      content.hidden = false;
    }

    const indicator = item.querySelector('.glossary-toggle-indicator');
    if (indicator) {
      indicator.textContent = isOpen ? '+' : '−';
    }
    const btn = item.querySelector('.glossary-trigger');
    if (btn) {
      btn.setAttribute('aria-expanded', String(!isOpen));
    }
  });

  // Cerrar desplegable si se hace clic fuera del buscador o al pulsar Escape
  document.addEventListener('click', (e) => {
    if (searchInput && !searchInput.contains(e.target) && dropdownMenu && !dropdownMenu.contains(e.target)) {
      closeAnnotationDropdown();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeAnnotationDropdown();
    }
  });

  // Load database and wire search listener
  loadDatabase().then(() => {
    filterGlossary();
  });

  if (searchInput) {
    searchInput.addEventListener('input', filterGlossary);
    searchInput.addEventListener('focus', filterGlossary);
  }
});
