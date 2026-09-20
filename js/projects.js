/**
 * JavaScript interactive filtering app for Proyectos Hub (proyectos.php)
 */
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('project-search-input');
  const searchClearBtn = document.getElementById('project-search-clear');
  const diffCheckboxes = document.querySelectorAll('input[name="difficulty"]');
  const techCheckboxes = document.querySelectorAll('input[name="tech"]');
  const archSelect = document.getElementById('filter-architecture');
  const durSelect = document.getElementById('filter-duration');
  
  const clearFiltersBtn = document.getElementById('project-clear-filters');
  const visibleCountEl = document.getElementById('visible-count');
  const totalCountEl = document.getElementById('total-count');
  
  const projectCards = document.querySelectorAll('.project-card');
  const projectsGrid = document.getElementById('projects-grid');
  const emptyState = document.getElementById('projects-empty-state');
  const resetEmptyBtn = document.getElementById('btn-reset-empty');

  if (!projectCards.length) return;

  if (totalCountEl) {
    totalCountEl.textContent = projectCards.length;
  }

  function filterProjects() {
    const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
    if (searchClearBtn) {
      searchClearBtn.style.display = query ? 'block' : 'none';
    }

    const selectedDiffs = Array.from(diffCheckboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    const selectedTechs = Array.from(techCheckboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    const selectedArch = archSelect ? archSelect.value : 'todas';
    const selectedDur = durSelect ? durSelect.value : 'todas';

    const hasActiveFilters = Boolean(
      query || 
      selectedDiffs.length > 0 || 
      selectedTechs.length > 0 || 
      selectedArch !== 'todas' || 
      selectedDur !== 'todas'
    );

    if (clearFiltersBtn) {
      clearFiltersBtn.style.display = hasActiveFilters ? 'inline-flex' : 'none';
    }

    let visibleCount = 0;

    projectCards.forEach(card => {
      const cardDiff = card.dataset.difficulty || '';
      const cardTechs = (card.dataset.techs || '').split(',');
      const cardArch = card.dataset.architecture || '';
      const cardDur = card.dataset.duration || '';
      const cardKeywords = (card.dataset.keywords || '').toLowerCase();
      const cardTitle = card.querySelector('.project-title')?.textContent.toLowerCase() || '';
      const cardDesc = card.querySelector('.project-desc')?.textContent.toLowerCase() || '';

      // Match search query
      let matchesQuery = true;
      if (query) {
        matchesQuery = cardTitle.includes(query) || 
                       cardDesc.includes(query) || 
                       cardKeywords.includes(query);
      }

      // Match difficulty
      let matchesDiff = true;
      if (selectedDiffs.length > 0) {
        matchesDiff = selectedDiffs.includes(cardDiff);
      }

      // Match tech stack (Must match ALL selected techs or ANY? We use ANY selected tech)
      let matchesTech = true;
      if (selectedTechs.length > 0) {
        matchesTech = selectedTechs.some(tech => cardTechs.includes(tech));
      }

      // Match architecture
      let matchesArch = true;
      if (selectedArch !== 'todas') {
        matchesArch = cardArch === selectedArch;
      }

      // Match duration
      let matchesDur = true;
      if (selectedDur !== 'todas') {
        matchesDur = cardDur === selectedDur;
      }

      const isVisible = matchesQuery && matchesDiff && matchesTech && matchesArch && matchesDur;

      if (isVisible) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    if (visibleCountEl) {
      visibleCountEl.textContent = visibleCount;
    }

    if (visibleCount === 0) {
      if (projectsGrid) projectsGrid.style.display = 'none';
      if (emptyState) emptyState.style.display = 'flex';
    } else {
      if (projectsGrid) projectsGrid.style.display = 'grid';
      if (emptyState) emptyState.style.display = 'none';
    }
  }

  function resetAllFilters() {
    if (searchInput) searchInput.value = '';
    diffCheckboxes.forEach(cb => cb.checked = false);
    techCheckboxes.forEach(cb => cb.checked = false);
    if (archSelect) archSelect.value = 'todas';
    if (durSelect) durSelect.value = 'todas';
    filterProjects();
  }

  // Event Listeners
  if (searchInput) {
    searchInput.addEventListener('input', filterProjects);
  }

  if (searchClearBtn) {
    searchClearBtn.addEventListener('click', () => {
      if (searchInput) searchInput.value = '';
      filterProjects();
      if (searchInput) searchInput.focus();
    });
  }

  diffCheckboxes.forEach(cb => cb.addEventListener('change', filterProjects));
  techCheckboxes.forEach(cb => cb.addEventListener('change', filterProjects));

  if (archSelect) archSelect.addEventListener('change', filterProjects);
  if (durSelect) durSelect.addEventListener('change', filterProjects);

  if (clearFiltersBtn) clearFiltersBtn.addEventListener('click', resetAllFilters);
  if (resetEmptyBtn) resetEmptyBtn.addEventListener('click', resetAllFilters);

  // Initial Run
  filterProjects();
});

