// Checklist and Study Progress Management
(function() {
  const STORAGE_KEY = 'springboot_study_checklist_v1';

  function initChecklist() {
    const checkboxes = document.querySelectorAll('.task-item input[type="checkbox"]');
    if (!checkboxes.length) return;

    let savedState = {};
    try {
      savedState = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
    } catch (e) {
      savedState = {};
    }

    checkboxes.forEach((cb, index) => {
      const id = cb.dataset.id || 'task_' + index;
      cb.dataset.id = id;
      if (savedState[id]) {
        cb.checked = true;
        const parent = cb.closest('.task-item');
        if (parent) parent.classList.add('completed');
      }

      cb.addEventListener('change', () => {
        const parent = cb.closest('.task-item');
        if (cb.checked) {
          if (parent) parent.classList.add('completed');
          savedState[id] = true;
        } else {
          if (parent) parent.classList.remove('completed');
          delete savedState[id];
        }
        localStorage.setItem(STORAGE_KEY, JSON.stringify(savedState));
        updateProgressBar();
      });
    });

    updateProgressBar();
  }

  function updateProgressBar() {
    const checkboxes = document.querySelectorAll('.task-item input[type="checkbox"]');
    if (!checkboxes.length) return;

    let checkedCount = 0;
    checkboxes.forEach(cb => {
      if (cb.checked) checkedCount++;
    });

    const percent = Math.round((checkedCount / checkboxes.length) * 100);
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');

    if (progressFill) {
      progressFill.style.width = percent + '%';
    }
    if (progressText) {
      progressText.textContent = percent + '%';
    }
  }

  document.addEventListener('DOMContentLoaded', initChecklist);
})();

