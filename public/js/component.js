const container = document.querySelector('.pokemon.container')
let lastCard = container.lastElementChild

const apiCall = async () => {
    const offset = document.querySelectorAll('.pokemon .row .col-lg-2').length

    const json = async () => {
        const req = await fetch('../cache/poke.cache')

        return await req.json()
    }

    const data = await json()

    if(data.pokemon.at(-1) === lastCard.lastElementChild.dataset.id) {
        return false
    }

    let nextSet = data.pokemon.slice(offset, offset + 6)

    const newRow = document.createElement('div')
    newRow.classList.add('row', 'gy-3', 'mt-0')

    nextSet.forEach(pokemon => {
        const { id, experience, name, types, image } = pokemon

        const cardTop = `
            <div class="d-flex justify-content-between">
              <strong>#${id}</strong>
              <span>EXP: ${experience}</span>
            </div>
        `

        const pokeTypes = types.map(type => `<span class="badge text-bg-${type}">${type}</span>`).join('')

        const newPokemon = `
            <div class="col-lg-2 col-sm-4" data-id="${id}">
                <div class="card">
                  <img class="card-bg-${types[0]}" src="${image ?? 'https://m.media-amazon.com/images/I/71WkWKFRSWL.png'}" alt="${name}">
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

        newRow.insertAdjacentHTML('beforeend', newPokemon)
    });

    container.appendChild(newRow)

    lastCard = container.lastElementChild
    observer.observe(lastCard)
};

const observer = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting) {
        observer.unobserve(lastCard)
        apiCall()
    }
}, { threshold: 0.22 })

observer.observe(lastCard)

const render = (pokemons) => {

    if(pokemons.length === 0) {
        container.innerHTML = `<div class="alert alert-danger mt-5">No pokémons found</div>`
        return;
    }

    const rows = chunk(pokemons, 6).map((pokemonRow) => {
        const cols = pokemonRow.map(createPokemonCard).join('')
        const row = document.createElement('div')

        row.classList.add('row', 'gy-3', 'mt-0')
        row.insertAdjacentHTML('beforeend', cols)

        return row
    });

    container.replaceChildren(...rows)
};

async function searchPokemon(event)
{
    const pokemon = event.target.value
    const form = new FormData
    form.append('pokemon', pokemon)

    const res = await fetch('../app/api/find.php', {
        method: 'POST',
        body: form,
    }).then(res => res.json())

    render(Object.values(res.data))
}

const debounce = (func, delay) => {
    let timerId
    return (...args) => {
        if (timerId) {
            clearTimeout(timerId)
        }
        timerId = setTimeout(() => {
            func(...args)
            timerId = null
        }, delay)
    }
}

const search = document.querySelector('input')

search.addEventListener('keyup', debounce(searchPokemon, 300))