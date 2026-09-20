// Main Application Controller - Developer Handbook
(function() {
  'use strict';

  // ── 1. Theme Management (Dark / Light) ──────────────────────────────────
  const initTheme = () => {
    // Forzamos 'dark' como predeterminado si no hay preferencia guardada explícitamente
    const savedTheme = localStorage.getItem('gh_study_theme') || 'dark';
    
    // Aplicamos inmediatamente para evitar el "flash" de modo claro
    document.documentElement.dataset.theme = savedTheme;
    updateThemeButtons(savedTheme);

    document.addEventListener('click', (e) => {
      const target = e.target.closest('.theme-toggle-trigger, #theme-toggle-btn, #floating-theme-btn');
      if (target) {
        const current = document.documentElement.dataset.theme || 'dark';
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.dataset.theme = next;
        localStorage.setItem('gh_study_theme', next);
        updateThemeButtons(next);
      }
    });
  }

  const updateThemeButtons = (theme) => {
    const isLight = (theme === 'light');
    const label = isLight ? '🌙 Modo Oscuro' : '☀️ Modo Diurno';

    const buttons = document.querySelectorAll('.theme-toggle-trigger, #theme-toggle-btn, #floating-theme-btn');
    buttons.forEach(btn => {
      btn.innerHTML = label;
      btn.setAttribute('title', isLight ? 'Cambiar a modo oscuro' : 'Cambiar a modo diurno (claro)');
    });
  }


  // ── 2. Dynamic Topic TOC (Right Drawer Flyout - Per Topic) ───────────────
  const initDynamicTOC = () => {
    let tocContainer = document.getElementById('dynamic-toc');
    let tocList = document.getElementById('toc-list');

    if (!tocContainer) {
      tocContainer = document.createElement('aside');
      tocContainer.id = 'dynamic-toc';
      tocContainer.className = 'topic-toc';
      tocContainer.innerHTML = `
        <div class="toc-header-row">
          <h5 id="toc-header-title">Apartados del Tema</h5>
          <button class="toc-close-btn" id="toc-close-btn" title="Cerrar panel">✕</button>
        </div>
        <ul id="toc-list"></ul>
      `;
      document.body.appendChild(tocContainer);
    }

    if (!tocList) {
      tocList = tocContainer.querySelector('#toc-list') || document.createElement('ul');
      tocList.id = 'toc-list';
      tocContainer.appendChild(tocList);
    }

    // Crear o recuperar el botón cuadrado flotante en el lateral derecho (right: 0)
    let drawerToggleBtn = document.getElementById('toc-drawer-toggle');
    if (!drawerToggleBtn) {
      drawerToggleBtn = document.createElement('button');
      drawerToggleBtn.id = 'toc-drawer-toggle';
      drawerToggleBtn.className = 'floating-toc-btn';
      drawerToggleBtn.title = 'Apartados';
      drawerToggleBtn.innerHTML = '☰';
      document.body.appendChild(drawerToggleBtn);
    }

    // Crear o recuperar el backdrop transparente
    let backdrop = document.querySelector('.toc-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'toc-backdrop';
      document.body.appendChild(backdrop);
    }

    // Insertar cabecera con título dinámico y botón de cierre (✕) si no existe
    if (!tocContainer.querySelector('.toc-header-row')) {
      const headerRow = document.createElement('div');
      headerRow.className = 'toc-header-row';
      headerRow.innerHTML = `
        <h5 id="toc-header-title">Apartados del Tema</h5>
        <button class="toc-close-btn" id="toc-close-btn" title="Cerrar panel">✕</button>
      `;
      tocContainer.insertBefore(headerRow, tocContainer.firstChild);
    }

    const closeBtn = tocContainer.querySelector('#toc-close-btn');
    const headerTitleEl = tocContainer.querySelector('#toc-header-title');

    const openTOC = () => {
      tocContainer.classList.add('open');
      backdrop.classList.add('active');
    };

    const closeTOC = () => {
      tocContainer.classList.remove('open');
      backdrop.classList.remove('active');
    }

    if (drawerToggleBtn) {
      drawerToggleBtn.onclick = (e) => {
        e.stopPropagation();
        if (tocContainer.classList.contains('open')) {
          closeTOC();
        } else {
          openTOC();
        }
      };
    }

    if (closeBtn) closeBtn.onclick = closeTOC;
    if (backdrop) backdrop.onclick = closeTOC;

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && tocContainer.classList.contains('open')) {
        closeTOC();
      }
    });

    const findCurrentArticle = (articles) => {
      const visibleArticle = articles.find(article => {
        const rect = article.getBoundingClientRect();
        return rect.top <= 160 && rect.bottom >= 160;
      });

      return visibleArticle || articles.find(article => (
        article.getBoundingClientRect().bottom >= 100
      )) || null;
    };

    const getTOCData = (currentArticle, mainContent) => {
      if (!currentArticle) {
        return {
          headers: Array.from(mainContent.querySelectorAll('h3[id], h4[id], h5[id]')),
          topicName: 'Apartados de la Página'
        };
      }

      const headers = Array.from(
        currentArticle.querySelectorAll('h3[id], h4[id], h5[id]')
      );
      const heading = currentArticle.querySelector('h2, h3');
      const number = currentArticle.id.match(/\d+/);

      return {
        headers,
        topicName: heading?.textContent.trim()
          || (number ? `Tema ${number[0]}` : 'Apartados del Tema')
      };
    };

    const renderTOCLinks = (headers) => {
      tocList.innerHTML = '';

      headers.forEach(header => {
        const link = document.createElement('a');
        link.href = `#${header.id}`;
        link.textContent = header.textContent.trim();
        link.classList.add('toc-link');

        link.onclick = (e) => {
          e.preventDefault();
          header.scrollIntoView({ behavior: 'smooth', block: 'start' });
          history.pushState(null, '', `#${header.id}`);
          closeTOC();
        };

        const item = document.createElement('li');
        item.appendChild(link);
        tocList.appendChild(item);
      });
    };

    const updateActiveTOCLink = (headers) => {
      const scrollPos = window.scrollY + 120;
      let currentHeader = null;

      for (const header of headers) {
        const top = header.getBoundingClientRect().top + window.scrollY;
        if (scrollPos < top) break;
        currentHeader = header;
      }

      tocList.querySelectorAll('a').forEach(link => {
        const isActive = currentHeader
          && link.getAttribute('href') === `#${currentHeader.id}`;
        link.classList.toggle('active', Boolean(isActive));
      });
    };

    const updateTOC = () => {
      const articles = Array.from(document.querySelectorAll('article[id]'));
      const mainContent = document.querySelector('.content-main') || document.querySelector('main');
      if (!mainContent) return;

      const currentArticle = findCurrentArticle(articles);
      const { headers, topicName } = getTOCData(currentArticle, mainContent);

      if (!headers.length) {
        if (drawerToggleBtn) drawerToggleBtn.style.display = 'none';
        return;
      }

      if (drawerToggleBtn) drawerToggleBtn.style.display = 'inline-flex';
      if (headerTitleEl) headerTitleEl.textContent = topicName;

      const activeArticleId = currentArticle?.id || 'page-global';
      if (tocContainer.dataset.currentArticle !== activeArticleId) {
        tocContainer.dataset.currentArticle = activeArticleId;
        renderTOCLinks(headers);
      }

      updateActiveTOCLink(headers);
    };

    //hasta aqui

    window.addEventListener('scroll', updateTOC, { passive: true });
    window.addEventListener('resize', updateTOC, { passive: true });
    updateTOC();
  }


  // ── 3. Reading Scroll Progress Bar ──────────────────────────────────────
  const initReadingProgress = () => {
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    const topProgressLine = document.getElementById('scroll-progress-line');

    const updateProgress = () => {
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const scrollPos = window.scrollY;
      const percent = docHeight > 0 ? Math.min(100, Math.max(0, Math.round((scrollPos / docHeight) * 100))) : 0;

      if (progressFill) {
        progressFill.style.width = percent + '%';
      }
      if (progressText) {
        progressText.textContent = percent + '%';
      }
      if (topProgressLine) {
        topProgressLine.style.width = percent + '%';
      }
    }

    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress, { passive: true });
    updateProgress();
  }


  // ── 4. Sidebar Active Section Tracking (ScrollSpy) ──────────────────────
  const initScrollSpy = () => {
    const targets = Array.from(document.querySelectorAll('section[id], article[id]'));
    const navLinks = Array.from(document.querySelectorAll('.sidebar-link, .sidebar-subnav a'));
    const sidebar = document.querySelector('.sidebar');

    if (!targets.length || !navLinks.length) return;

    // Mapa de targetId -> link del sidebar
    const linkMap = new Map();
    navLinks.forEach(link => {
      const href = link.getAttribute('href');
      if (href?.includes('#')) {
        const hash = href.split('#')[1];
        if (hash) linkMap.set(hash, link);
      }
    });

    let ticking = false;

// sourcery skip: avoid-function-declarations-in-blocks
    function setActive(targetId) {
      const activeLink = linkMap.get(targetId);
      if (!activeLink) return;

      // Limpiar clases activas previas
      navLinks.forEach(l => {
        l.classList.remove('active', 'parent-active');
      });

      // Activar el enlace correspondiente
      activeLink.classList.add('active');

      // Si es un tema hijo dentro de .sidebar-subnav, marcar también el bloque contenedor padre
      const parentSubnav = activeLink.closest('.sidebar-subnav');
      if (parentSubnav) {
        const parentLi = parentSubnav.closest('li');
        if (parentLi) {
          const parentLink = parentLi.querySelector('.sidebar-link');
          if (parentLink) {
            parentLink.classList.add('parent-active');
          }
        }
      }

      // Auto-scroll del aside para mantener el elemento sombreado siempre visible
      if (sidebar) {
        const linkRect = activeLink.getBoundingClientRect();
        const sidebarRect = sidebar.getBoundingClientRect();
        if (linkRect.top < sidebarRect.top + 30 || linkRect.bottom > sidebarRect.bottom - 30) {
          activeLink.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
      }
    }

    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(() => {
          ticking = false;

          // Si estamos al fondo de la página, activar el último elemento
          const atBottom = (window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 50);
          if (atBottom) {
            const lastTarget = targets.at(-1);
            if (lastTarget) setActive(lastTarget.getAttribute('id'));
            return;
          }

          // Línea de lectura (justo debajo de la barra superior fija)
          const readingLine = 100;
          let currentTarget = null;

          for (const element of targets) {
            const rect = element.getBoundingClientRect();
            if (rect.top <= readingLine) {
              currentTarget = element;
            } else {
              break;
            }
          }

          if (currentTarget) {
            setActive(currentTarget.getAttribute('id'));
          }
        });
        ticking = true;
      }
    }

    // Activación instantánea al hacer clic en cualquier enlace del aside
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        const href = link.getAttribute('href');
        if (href?.includes('#')) {
          const hash = href.split('#')[1];
          if (hash) setActive(hash);
        }
      });
    });

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });

    // Ejecutar al inicio
    onScroll();
  }


  // ── 4. Code Block Copy to Clipboard ─────────────────────────────────────
  const initCodeCopy = () => {
    const legacyBlocks = document.querySelectorAll('.code-container:not(code-block .code-container)');
    legacyBlocks.forEach(container => {
      const copyBtn = container.querySelector('.copy-btn');
      const code = container.querySelector('pre code');
      if (!copyBtn || !code || copyBtn._hasCopyHandler) return;
      copyBtn._hasCopyHandler = true;

      copyBtn.addEventListener('click', () => {
        const text = code.innerText || code.textContent;
        navigator.clipboard.writeText(text).then(() => {
          const originalText = copyBtn.innerHTML;
          copyBtn.innerHTML = '✓ Copiado';
          restoreCopyButton(copyBtn, originalText);
        }).catch(err => console.error('Error al copiar:', err));
      });
    });
  }


  // ── 5. Live Search & Autocomplete ───────────────────────────────────────
    let SEARCH_DATABASE = [];

    const getBaseUrl = () => {
      if (typeof window.BASE_URL !== 'undefined') {
        return window.BASE_URL;
      }
      return '';
    };


    const loadSearchDatabase = async () => {
      try {
        const response = await fetch(getBaseUrl() + 'js/search-db.json');
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        SEARCH_DATABASE = await response.json();
        console.log('Search database loaded successfully');
      } catch (e) {
        console.error('Could not load search database:', e);
      }
    }

// sourcery skip: avoid-function-declarations-in-blocks
    async function initSearch() {
      await loadSearchDatabase();
      const searchInput = document.getElementById('search-input');
      const dropdown = document.getElementById('search-autocomplete-dropdown');
      const searchWrapper = searchInput ? searchInput.closest('.search-wrapper') : null;

      if (!searchInput || !dropdown || !searchWrapper) return;

      let selectedIndex = -1;
      let currentResults = [];

    function normalizeQuery(q) {
      return q.replace(/\.{2,}/g, ' ').replace(/\s+/g, ' ').trim();
    }

    function escapeRegExp(value) {
      return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&\\');
    }

    function highlightMatch(text, query) {
      const clean = normalizeQuery(query);
      if (!clean) return text;

      const regex = new RegExp(`(${escapeRegExp(clean)})`, 'gi');
      return text.replace(regex, '<mark>$1</mark>');
    }

    function search(query) {
      const clean = normalizeQuery(query).toLowerCase();
      if (!clean) return [];

      const words = clean.split(' ').filter(Boolean);

      const scored = [];
      for (const item of SEARCH_DATABASE) {
        const termLower = item.term.toLowerCase();
        const descLower = item.desc.toLowerCase();
        const topicLower = item.topic.toLowerCase();
        const aliasesLower = (item.aliases || []).join(' ').toLowerCase();
        const fullText = `${termLower} ${aliasesLower} ${topicLower} ${descLower}`;

        // Todas las palabras escritas deben estar presentes
        const allWordsMatch = words.every(w => fullText.includes(w));
        if (!allWordsMatch) continue;

        let score = 0;
        if (termLower === clean) score += 200;
        else if (termLower.startsWith(clean)) score += 120;
        else if (termLower.includes(clean)) score += 80;
        else if (aliasesLower.includes(clean)) score += 60;
        else if (topicLower.includes(clean)) score += 40;
        else score += 20;

        if (termLower.startsWith(words[0])) score += 30;

        scored.push({ item, score });
      }

      scored.sort((a, b) => b.score - a.score);
      return scored.slice(0, 8).map(s => s.item);
    }

    function renderDropdown(results, query) {
      currentResults = results;
      selectedIndex = -1;

      if (!results.length) {
        dropdown.innerHTML = `<div class="search-empty-message">No se encontraron apartados para "<strong>${escapeHtml(query)}</strong>"</div>`;
        dropdown.style.display = 'block';
        searchInput.setAttribute('aria-expanded', 'true');
        return;
      }

      let html = `<div class="search-autocomplete-header">
        <span>Sugerencias (${results.length})</span>
        <span class="hint">↑↓ Navegar · Enter Seleccionar · Esc Cerrar</span>
      </div>`;

      results.forEach((r, idx) => {
        const titleHtml = highlightMatch(escapeHtml(r.term), query);
        html += `
          <div class="search-suggestion-item" data-index="${idx}" data-target="${r.target}" role="option">
            <div class="search-suggestion-left">
              <span class="search-suggestion-badge ${r.badgeClass || ''}">${escapeHtml(r.badge)}</span>
              <div class="search-suggestion-info">
                <div class="search-suggestion-title">${titleHtml}</div>
                <div class="search-suggestion-desc">${escapeHtml(r.desc)}</div>
              </div>
            </div>
            <div class="search-suggestion-right">
              <span class="search-suggestion-topic">${escapeHtml(r.topic)}</span>
              <span class="search-suggestion-arrow">→</span>
            </div>
          </div>
        `;
      });

      dropdown.innerHTML = html;
      dropdown.style.display = 'block';
      searchInput.setAttribute('aria-expanded', 'true');

      // Click listener en los items
      const items = dropdown.querySelectorAll('.search-suggestion-item');
      items.forEach(el => {
        el.addEventListener('click', () => {
          const idx = Number.parseInt(el.dataset.index, 10);
          if (currentResults[idx]) {
            navigateTo(currentResults[idx]);
          }
        });
      });
    }

    function updateSelection() {
      const items = dropdown.querySelectorAll('.search-suggestion-item');
      items.forEach((item, idx) => {
        if (idx === selectedIndex) {
          item.classList.add('selected');
          item.scrollIntoView({ block: 'nearest' });
        } else {
          item.classList.remove('selected');
        }
      });
    }

    function closeDropdown() {
      dropdown.style.display = 'none';
      searchInput.setAttribute('aria-expanded', 'false');
      selectedIndex = -1;
    }

    function navigateTo(item) {
      closeDropdown();
      searchInput.value = item.term;

      const compatibleTargets = {
        'tema-1-request': 'tema-1-http-verbos',
        'tema-1-response': 'tema-1-http-estados',
        'tema-1-verbos': 'tema-1-http-verbos',
        'tema-1-https': 'tema-1-http-verbos',
        'tema-2-servlets': 'tema-1-mvc-clasico',
        'tema-2-jsp': 'tema-1-mvc-clasico',
        'tema-2-jsp-seguridad': 'tema-1-mvc-clasico',
        'tema-2-mvc': 'tema-1-mvc-clasico',
        'tema-2-ejb': 'tema-4-ioc',
        'http-203': 'tema-1-http-estados',
        'codigos-http-completos': 'tema-1-http-estados'
      };

      const resolvedTarget = compatibleTargets[item.target] || item.target;
      const targetEl = document.getElementById(resolvedTarget) || document.getElementById(item.target);
      if (targetEl) {
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Animación suave de destello en el apartado destino
        targetEl.classList.remove('section-target-highlight');
        targetEl.getBoundingClientRect(); // Reflow para reiniciar la animación
        targetEl.classList.add('section-target-highlight');

        setTimeout(() => {
          targetEl.classList.remove('section-target-highlight');
        }, 2300);

        try {
          history.pushState(null, '', '#' + resolvedTarget);
        } catch (e) {}
      } else {
        // Si el elemento no está en la página actual, redirigir a la página correspondiente
        let url = '#';
        const bUrl = getBaseUrl();

        const temaHierarchicalSlugs = {
          1: 'fundamentos/arquitectura-web-http',
          2: 'fundamentos/json-jackson',
          3: 'fundamentos/maven-lombok',
          4: 'fundamentos/core-spring-ioc',
          5: 'core-spring-boot/solid-capas',
          6: 'core-spring-boot/rest-responseentity',
          7: 'core-spring-boot/servicios-di',
          8: 'core-spring-boot/hibernate-orm',
          9: 'persistencia-dtos/asociaciones-consultas',
          10: 'persistencia-dtos/dtos-repositorios',
          11: 'calidad-ops/validaciones-errores',
          12: 'calidad-ops/logs-perfiles-swagger',
          13: 'testing/junit5-mockito',
          14: 'testing/spring-boot-test',
          15: 'seguridad-docker/jwt-docker'
        };

        if (item.target.startsWith('tema-')) {
          const match = item.target.match(/tema-(\d+)/);
          if (match) {
            const num = Number.parseInt(match[1], 10);
            const slug = temaHierarchicalSlugs[num] || `tema-${num}`;
            url = `${bUrl}${slug}#${item.target}`;
          }
        } else if (item.target.startsWith('filo-')) {
          url = `${bUrl}filosofia#${item.target}`;
        } else if (item.target.startsWith('http-') || item.target.startsWith('codigos-')) {
          url = `${bUrl}ruta#${item.target}`;
        }

        window.location.href = url;
      }
    }

    function escapeHtml(str) {
      return String(str)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;');
    }

    // Input events
    searchInput.addEventListener('input', (e) => {
      const val = e.target?.value;
      if (!val?.trim()) {
        closeDropdown();
        return;
      }
      const results = search(val);
      renderDropdown(results, val);
    });

    searchInput.addEventListener('focus', () => {
      const val = searchInput.value;
      if (!val?.trim())  {
        const results = search(val);
        renderDropdown(results, val);
      }
    });

    // Teclado: flechas arriba/abajo, Enter, Esc
    const handleSearchKey = (e) => {
      if (dropdown.style.display === 'none') {
        return;
      }

      if (e.key === 'Escape') {
        e.preventDefault();
        closeDropdown();
        return;
      }

      if (!currentResults.length) {
        return;
      }

      if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        e.preventDefault();
        const increment = e.key === 'ArrowDown' ? 1 : -1;
        selectedIndex = (selectedIndex + increment + currentResults.length) % currentResults.length;
        updateSelection();
        return;
      }

      if (e.key === 'Enter') {
        e.preventDefault();
        const targetIndex = Math.max(selectedIndex, 0);
        const selectedResult = currentResults[targetIndex];
        if (selectedResult) {
          navigateTo(selectedResult);
        }
      }
    };

    searchInput.addEventListener('keydown', handleSearchKey);

    // Cierre al hacer clic fuera
    document.addEventListener('click', (e) => {
      if (!searchWrapper.contains(e.target)) {
        closeDropdown();
      }
    });

    // Atajo de teclado global Ctrl+K / Cmd+K
    window.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
        if (searchInput.value.trim()) {
          const results = search(searchInput.value);
          renderDropdown(results, searchInput.value);
        }
      }
    });
  }


  // ── 6. Back to Top Button ───────────────────────────────────────────────
  function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        btn.style.display = 'flex';
      } else {
        btn.style.display = 'none';
      }
    }, { passive: true });

    btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }


  // ── 7. Mobile Sidebar Toggle ────────────────────────────────────────────
  function initMobileMenu() {
    const toggleBtn = document.getElementById('mobile-toggle');
    const sidebar = document.querySelector('.sidebar');
    if (!toggleBtn || !sidebar) return;

    let backdrop = document.querySelector('.sidebar-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'sidebar-backdrop';
      document.body.appendChild(backdrop);
    }

    const setSidebarState = (open) => {
      sidebar.classList.toggle('open', open);
      backdrop.classList.toggle('active', open);
    };

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const willOpen = !sidebar.classList.contains('open');
      setSidebarState(willOpen);
    });

    backdrop.addEventListener('click', () => {
      setSidebarState(false);
    });

    const links = sidebar.querySelectorAll('a');
    links.forEach(l => {
      l.addEventListener('click', () => {
        if (window.innerWidth <= 1100) {
          setSidebarState(false);
        }
      });
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && sidebar.classList.contains('open')) {
        setSidebarState(false);
      }
    });
  }


  // ── 8. Topic Dropdowns (Apartados por tema) ─────────────────────────────
  function initTopicDropdowns() {
    // Cerrar el dropdown al hacer clic en un enlace de apartado
    document.addEventListener('click', (e) => {
      const item = e.target.closest('.topic-dropdown-item');
      if (item) {
        const details = item.closest('details.topic-dropdown');
        if (details) {
          details.removeAttribute('open');
        }
      }

      // Cerrar cualquier dropdown abierto si se hace clic fuera de él
      const openDropdowns = document.querySelectorAll('details.topic-dropdown[open]');
      openDropdowns.forEach(details => {
        if (!details.contains(e.target)) {
          details.removeAttribute('open');
        }
      });
    });

    // Cerrar al pulsar Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const openDropdowns = document.querySelectorAll('details.topic-dropdown[open]');
        openDropdowns.forEach(details => details.removeAttribute('open'));
      }
    });
  }


  // ── 9. Image Lightbox for larger previews ──────────────────────────────
  function initImageLightbox() {
    let lightbox = document.getElementById('image-lightbox');

    if (!lightbox) {
      lightbox = document.createElement('div');
      lightbox.id = 'image-lightbox';
      lightbox.className = 'image-lightbox';
      lightbox.innerHTML = `
        <div class="image-lightbox-backdrop"></div>
        <div class="image-lightbox-panel" role="dialog" aria-modal="true" aria-label="Vista ampliada de la imagen">
          <button class="image-lightbox-close" type="button" aria-label="Cerrar vista ampliada">✕</button>
          <img alt="Vista ampliada" />
          <div class="image-lightbox-caption"></div>
        </div>
      `;
      document.body.appendChild(lightbox);
    }

    const image = lightbox.querySelector('img');
    const caption = lightbox.querySelector('.image-lightbox-caption');
    const closeBtn = lightbox.querySelector('.image-lightbox-close');
    const backdrop = lightbox.querySelector('.image-lightbox-backdrop');

    const closeLightbox = () => {
      lightbox.classList.remove('active');
      image.removeAttribute('src');
      image.setAttribute('alt', 'Vista ampliada');
      caption.textContent = '';
    };

    closeBtn.addEventListener('click', closeLightbox);
    backdrop.addEventListener('click', closeLightbox);

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && lightbox.classList.contains('active')) {
        closeLightbox();
      }
    });

    document.addEventListener('click', (e) => {
      const trigger = e.target.closest('.block-intro-figure img, .markdown-body img');
      if (!trigger) return;

      e.preventDefault();
      image.src = trigger.src;
      image.alt = trigger.alt || 'Imagen ampliada';

      const fig = trigger.closest('figure');
      const figCaption = fig ? fig.querySelector('figcaption') : null;
      caption.textContent = figCaption ? figCaption.textContent.trim() : trigger.alt || 'Vista ampliada';

      lightbox.classList.add('active');
    });
  }


  // ── Inicialización General ──────────────────────────────────────────────
  function initApp() {
    initTheme();
    initDynamicTOC();
    initReadingProgress();
    initScrollSpy();
    initCodeCopy();
    initSearch();
    initBackToTop();
    initMobileMenu();
    initTopicDropdowns();
    initImageLightbox();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initApp);
  } else {
    initApp();
  }
})();
