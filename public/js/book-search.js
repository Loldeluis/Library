  const container     = document.getElementById('search-results');
  const btn           = document.getElementById('search-btn');
  const input         = document.getElementById('search-input');
  const modal         = document.getElementById('book-modal');
  const closeBtn      = modal.querySelector('.modal-close');

  // Mapa de códigos ISO a nombres completos
  const languageNames = {
    es: 'Español',
    en: 'Inglés',
    fr: 'Francés',
    de: 'Alemán',
    it: 'Italiano',
    pt: 'Portugués',
    zh: 'Chino',
    ja: 'Japonés',
    ru: 'Ruso',
    ar: 'Árabe',
    ko: 'Coreano',
    nl: 'Neerlandés',
    sv: 'Sueco',
    no: 'Noruego'
  };

  btn.addEventListener('click', () => doSearch());
  input.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      doSearch();
    }
  });

  async function doSearch() {
    const q = input.value.trim();
    if (!q) return;

    container.innerHTML = '';
    try {
      const res = await fetch(`/books/query?q=${encodeURIComponent(q)}`, {
        headers: { 'Accept': 'application/json' }
      });
      if (!res.ok) {
        const text = await res.text();
        console.error(`Error ${res.status}:`, text);
        return container.innerHTML = `<p>Error ${res.status} al buscar.</p>`;
      }

      const { count, results } = await res.json();
      if (!count) {
        return container.innerHTML = `<p>No se encontraron resultados para “${q}”.</p>`;
      }

      results.forEach(book => {
        const card = document.createElement('div');
        card.className = 'book-card';
        card.innerHTML = `
          <img
            src="${book.portada_medium || '/images/placeholder.png'}"
            alt="Portada ${book.titulo}"
            loading="lazy"
          >
          <h3>${book.titulo}</h3>
          <p>${Array.isArray(book.autores) ? book.autores.join(', ') : ''}</p>
        `;
        card.addEventListener('click', () => openModal(book));
        container.appendChild(card);
      });
    } catch (err) {
      console.error(err);
      container.innerHTML = '<p>Error de conexión o respuesta inválida.</p>';
    }
  }

  function openModal(book) {
    modal.querySelector('#modal-cover').src           = book.portada_medium || '/images/placeholder.png';
    modal.querySelector('#modal-title').textContent   = book.titulo;
    modal.querySelector('#modal-authors').textContent = Array.isArray(book.autores)
      ? book.autores.join(', ')
      : '';
    modal.querySelector('#modal-publisher').textContent = book.editorial || 'N/A';
    modal.querySelector('#modal-year').textContent      = book.anio_publicacion || 'N/A';
    modal.querySelector('#modal-pages').textContent     = book.paginas || 'N/A';

    // Mostrar el nombre completo del idioma
    const code = book.idioma || '';
    modal.querySelector('#modal-language').textContent = languageNames[code] || code || 'N/A';

    modal.querySelector('#modal-description').textContent = book.sinopsis || 'Sin descripción.';
    modal.classList.add('show');
  }

  closeBtn.addEventListener('click', () => modal.classList.remove('show'));
  modal.addEventListener('click', e => {
    if (e.target === modal) modal.classList.remove('show');
  });