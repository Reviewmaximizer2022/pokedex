const container = document.querySelector('.pokemon.container');
let lastCard = container.lastElementChild;

const apiCall = async () => {
    const offset = document.querySelectorAll('.pokemon .row .col-lg-2').length;
    const form = new FormData();
    form.append('offset', offset);

    const res = await fetch('../app/api/load.php', {
        method: 'POST',
        body: form,
    }).then(res => res.json());

    const newRow = document.createElement('div');
    newRow.classList.add('row');

    res.data.forEach(pokemon => {
        const { id, experience, name, types, image } = pokemon;

        const cardTop = `
            <div class="d-flex justify-content-between">
              <strong>#${id}</strong>
              <span>EXP: ${experience}</span>
            </div>
        `;

        const pokeTypes = types.map(type => `<span class="badge text-bg-${type}">${type}</span>`).join('');
        const newPokemon = `
            <div class="col-lg-2 col-sm-4 mt-4">
                <div class="card">
                  <img class="card-bg-${types[0]}" src="${image}" alt="${name}">
                  <div class="card-body">
                    <div class="card-text">
                      ${cardTop}
                      <p class="h5 mt-2">${name}</p>
                      ${pokeTypes}
                    </div>
                  </div>
                </div>
            </div>
        `;

        newRow.insertAdjacentHTML('beforeend', newPokemon);
    });

    container.appendChild(newRow);

    lastCard = container.lastElementChild;
    observer.observe(lastCard)
};

const observer = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting) {
        observer.unobserve(lastCard);
        apiCall();
    }
}, { threshold: 0.9, rootMargin: '1px' });

observer.observe(lastCard);