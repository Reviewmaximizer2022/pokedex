const pokeContainer = document.querySelector('.pokemon.container');
const filterTypes = Array.from(document.querySelectorAll('.filter button span'));

const chunk = (arr, size) =>
    Array.from({ length: Math.ceil(arr.length / size) }, (_, i) =>
        arr.slice(i * size, (i + 1) * size)
    );

const createPokemonCard = ({ id, experience, name, types, image }) => {
    const cardTop = `
        <div class="d-flex justify-content-between">
          <strong>#${id}</strong>
          <span>EXP: ${experience}</span>
        </div>
    `;

    const pokeTypes = types
        .map((type) => `<span class="badge text-bg-${type}">${type}</span>`)
        .join('');

    const pokeImage = `
        <img class="card-bg-${types[0]}" src="${image}" alt="${name}">
    `;

    const pokeName = `
        <p class="h5 mt-2">${name}</p>
    `;

    const cardText = `
        <div class="card-text">
          ${cardTop}
          ${pokeName}
          ${pokeTypes}
        </div>
    `;

    const cardBody = `
        <div class="card-body">
          ${cardText}
        </div>
    `;

    const card = `
        <div class="card">
          ${pokeImage}
          ${cardBody}
        </div>
    `;

    return `
        <div class="col-lg-2 col-sm-4">${card}</div>
    `;
};

const fetchPokemon = async (type) => {
    const form = new FormData();
    form.append('type', type);

    const response = await fetch('../app/api/filter.php', {
        method: 'POST',
        body: form,
    });

    const data = await response.json();

    return Object.values(data.pokemon);
};

const renderPokemon = (pokemons) => {
    const rows = chunk(pokemons, 6).map((pokemonRow) => {
        const cols = pokemonRow.map(createPokemonCard).join('');
        const row = document.createElement('div');
        row.classList.add('row', 'mt-4');
        row.insertAdjacentHTML('beforeend', cols);

        return row;
    });

    pokeContainer.replaceChildren(...rows);
};

filterTypes.forEach((type) =>
    type.addEventListener('click', async (event) => {
        const type = event.target.dataset.type;
        const pokemons = await fetchPokemon(type);
        renderPokemon(pokemons);
    })
);