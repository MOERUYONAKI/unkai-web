import * as bootstrap from 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.esm.min.js';
// import * as popperjs from 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/esm/popper.min.js';

const actMode = document.getElementById('actMode');
const theme_links = document.getElementsByClassName("theme");
const theme_search = document.getElementsByClassName("search-theme");
const modeTriggers = document.querySelectorAll('#modeTrigger, #modeTrigger2');

const connectToast = document.getElementById('connectToast');
const connectToastTrigger = document.getElementById('connectToastTrigger');

modeTriggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
        const isLight = actMode.getAttribute('data-bs-theme') === 'light';
        const theme = isLight ? 'dark' : 'light';

        actMode.setAttribute('data-bs-theme', theme);

        for (const link of theme_links) {
            link.setAttribute('href', link.getAttribute('href').replace(/(light|dark)$/, theme));
        }

        for (const search of theme_search) {
            search.setAttribute('value', theme);
        }

        console.log(`Theme switched`);
    });
});

if (connectToastTrigger) {
    const connectToastBootstrap = bootstrap.Toast.getOrCreateInstance(connectToast);

    connectToastTrigger.addEventListener('click', () => {
        connectToastBootstrap.show();
        console.log(1);
    })
}