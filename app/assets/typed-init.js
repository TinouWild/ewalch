import Typed from 'typed.js';

const el = document.getElementById('dev-typed');
if (el) {
    new Typed(el, {
        strings: [
            'Développeur PHP/Symfony',
            'Développeur freelance',
            'Expert API Platform',
            'Développeur web sur mesure'
        ],
        typeSpeed: 50,
        backSpeed: 25,
        backDelay: 2000,
        loop: true,
    });
}
