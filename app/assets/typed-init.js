/*
 * Animation « machine à écrire » du hero (Typed.js) — désactivée pour l'instant.
 *
 * Pour la réactiver :
 *   1. décommenter `import './typed-init.js'` dans assets/app.js ;
 *   2. ajouter un élément <span id="dev-typed"></span> dans le hero
 *      (templates/home/index/index.html.twig) ;
 *   3. adapter les phrases ci-dessous au nouveau positionnement.
 * La dépendance typed.js est toujours déclarée dans importmap.php et le style #dev-typed reste dans app.css.
 */
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
