document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('glossary-search');
  if (!searchInput) return;

  const terms = Array.from(document.querySelectorAll('.glossary-item'));

  terms.forEach((item) => {
    item.style.display = 'none';
    const content = item.querySelector('.glossary-content');
    if (content) content.hidden = true;
    const trigger = item.querySelector('.glossary-trigger');
    if (trigger) {
      trigger.setAttribute('aria-expanded', 'false');
      const indicator = trigger.querySelector('.glossary-toggle-indicator');
      if (indicator) indicator.textContent = '+';
    }
  });

  const filterGlossary = () => {
    const query = searchInput.value.trim().toLowerCase();

    terms.forEach((item) => {
      const haystack = (item.dataset.term || '') + ' ' + item.textContent.toLowerCase();
      const visible = !!query && haystack.includes(query);
      item.style.display = visible ? '' : 'none';

      if (!visible) {
        const content = item.querySelector('.glossary-content');
        if (content) content.hidden = true;
        const trigger = item.querySelector('.glossary-trigger');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
        const indicator = trigger ? trigger.querySelector('.glossary-toggle-indicator') : null;
        if (indicator) indicator.textContent = '+';
      }
    });
  };

  searchInput.addEventListener('input', filterGlossary);

  document.querySelectorAll('.glossary-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const item = trigger.closest('.glossary-item');
      if (!item || item.style.display === 'none') return;

      const content = item.querySelector('.glossary-content');
      const isOpen = !content.hidden;

      content.hidden = isOpen;
      trigger.setAttribute('aria-expanded', String(!isOpen));
      trigger.querySelector('.glossary-toggle-indicator').textContent = isOpen ? '+' : '−';
    });
  });
});
