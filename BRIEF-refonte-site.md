# Brief : refonte du site etiennewalch.fr

## Contexte

Tu travailles sur mon site personnel de freelance (Symfony + Twig + Bootstrap), en ligne sur https://etiennewalch.fr.

Je suis Etienne Walch, développeur PHP/Symfony avec plus de 5 ans d'expérience, spécialisé en API et back-end, basé à Mulhouse (Alsace). Je me lance comme indépendant.

**Mon positionnement :** j'utilise l'IA (Claude Code) pour livrer beaucoup plus vite et moins cher qu'une agence. Mon expérience de développeur garantit que le résultat est fiable, sécurisé et maintenable. Je suis aussi un ancien enseignant reconverti : je sais écouter, comprendre un besoin métier et expliquer simplement. Ce trait est central dans le message.

**Mes cibles, par ordre de priorité :**
1. Les TPE, PME, artisans et indépendants qui ont besoin d'un site ou d'un outil métier sur mesure (back-office, portail client, prise de commande, automatisation, connexion entre logiciels).
2. Les personnes qui ont commencé un site ou une appli avec l'IA (Claude, Lovable, Bolt…) et qui sont bloquées : bugs, sécurité, mise en production, paiement, RGPD.
3. Les sites existants à maintenir ou à faire évoluer.

**Le problème du site actuel :** il parle à des développeurs, pas à des clients. Il est centré sur la technique, ne présente aucune offre, ne mentionne pas l'IA et ne contient aucun témoignage.

## Règles de travail

1. **Explore d'abord le projet** : structure, templates Twig, contrôleurs, assets, formulaires (contact et demande d'accès à la démo), configuration. Ne modifie rien avant.
2. **Propose-moi un plan** (fichiers touchés, nouvelles sections, composants) et attends ma validation.
3. Travaille sur une **branche git dédiée** (`refonte-positionnement`), avec des commits petits et lisibles.
4. **Conserve la stack existante** (Symfony, Twig, Bootstrap). N'ajoute pas de dépendance lourde sans me demander.
5. **Ne casse pas l'existant** : le formulaire de contact, le formulaire d'accès à la démo et l'espace démo doivent continuer de fonctionner.
6. Tout le texte est en **français**, au vouvoiement, avec un ton chaleureux, direct, concret et **sans jargon technique** dans les sections destinées aux clients.
7. Les éléments marqués `[À COMPLÉTER]` ne doivent **pas être inventés**. Mets un placeholder visible dans le code et liste-les dans ton récapitulatif final.

## Nouvelle structure de la page d'accueil

### 1. Hero

- **Titre :** Votre site ou outil métier sur mesure, livré en quelques semaines.
- **Sous-titre :** J'utilise l'IA pour aller vite. Mes 5 ans de développement servent à ce que ça marche, et que ça dure. Développeur freelance à Mulhouse, en Alsace et à distance.
- **Boutons :** « Parlons de votre projet » (vers le contact) et « Voir mes réalisations ».
- Garde la photo.

### 2. Ce que je résous pour vous (3 cartes)

- **Vous avez besoin d'un outil sur mesure.** Site, prise de commande, back-office, portail client, automatisation : un outil pensé pour votre façon de travailler, pas l'inverse.
- **Votre projet fait avec l'IA est bloqué.** Vous avez avancé seul avec ChatGPT, Claude ou Lovable, mais ça bloque ? Je reprends, je corrige, je sécurise et je mets en ligne.
- **Votre site doit évoluer.** Nouvelles fonctionnalités, mises à jour, sécurité, hébergement : je m'occupe de la technique, vous vous occupez de votre activité.

### 3. Pourquoi travailler avec moi (3 ou 4 arguments courts)

- **Rapide et abordable** : l'IA me fait gagner un temps considérable, et vous en profitez sur le délai comme sur le prix.
- **Un vrai développeur derrière** : je comprends et je relis chaque ligne produite par l'IA. Votre site est sécurisé, maintenable, et il vous appartient.
- **Je parle votre langue** : ancien enseignant, je commence par comprendre votre métier, et je vous explique les choses simplement.
- **Un interlocuteur unique**, du premier échange au suivi après la mise en ligne.

### 4. Offres (3 cartes avec prix « à partir de »)

- **Diagnostic** — `[À COMPLÉTER : prix]` — j'analyse votre besoin ou votre projet existant et je vous remets un plan clair, chiffré, sans engagement.
- **Projet sur mesure** — à partir de `[À COMPLÉTER : prix]` — un prix fixe, défini ensemble avant de commencer. Pas de surprise.
- **Suivi mensuel** — à partir de `[À COMPLÉTER : prix]`/mois — hébergement, mises à jour, sécurité, petites évolutions.
- Ajoute une mention : « Chaque projet est différent : le premier échange est gratuit. »

### 5. Comment ça se passe (4 étapes en frise)

1. **On échange** sur votre activité et votre besoin (premier échange gratuit).
2. **Je vous montre un premier prototype** très rapidement, grâce à l'IA.
3. **On ajuste ensemble** jusqu'à ce que ça corresponde exactement à votre usage.
4. **Je mets en ligne et je reste disponible** pour la suite.

### 6. Réalisations

Garde les 3 projets (Les fit cookies de la petite Marie, Titine Créations, Scoringames) et leurs modales, mais **réécris les textes en termes de résultats pour le client** plutôt que de fonctionnalités techniques :

- **Les fit cookies** : une créatrice qui vend désormais en ligne, en toute autonomie (commandes, paiement sécurisé, factures automatiques, suivi client).
- **Titine Créations** : une artiste qui expose et gère elle-même ses œuvres en ligne. Garde la dimension humaine de l'histoire.
- **Scoringames** : une plateforme communautaire complète (comptes, système de points, ludothèque, publication d'articles).

Les badges techniques peuvent rester, mais en discret. Prévois un emplacement de témoignage par projet : `[À COMPLÉTER : témoignage client]`.

### 7. Démo

Garde l'espace démo et son formulaire d'accès, mais reformule les fonctionnalités en cas d'usage :
- Authentification & rôles → Chacun accède à ce qui le concerne
- CRUD avec formulaires → Gérer vos clients, produits ou dossiers
- Filtres & pagination → Retrouver une information en quelques secondes
- Emails automatisés → Relances et confirmations envoyées automatiquement
- Export CSV / Excel → Vos données exportées pour votre comptable
- Tableau de bord → Votre activité d'un coup d'œil

### 8. À propos

Réécris la section en mettant en avant :
- la reconversion depuis l'Éducation Nationale comme une **force** (pédagogie, écoute, clarté) ;
- les 5+ ans d'expérience en entreprise, sur des API et des applications métier ;
- l'ancrage local (Mulhouse, Alsace), avec des projets possibles partout en France à distance.

Supprime le compteur « 3 projets livrés ». Garde « +5 ans d'expérience ».

### 9. Parcours et technologies

- Déplace ces sections **en bas de page** et rends-les plus compactes.
- **Parcours** : `[À COMPLÉTER : décider si je garde la mention « En poste » chez Nartex]`. En attendant, n'affiche pas le badge « En poste ».
- **Technologies** : présentation compacte (logos ou badges). Ajoute « Claude Code / IA » à la liste.

### 10. Contact

- Titre : « Parlons de votre projet ».
- Promesse : « Réponse sous 24 h. Le premier échange est gratuit et sans engagement. »
- Ajoute au formulaire un champ facultatif (liste déroulante) : « Votre besoin : Nouveau site ou outil / Projet IA bloqué / Évolution ou maintenance / Autre ». Mets à jour le traitement du formulaire et l'email reçu en conséquence.
- Garde LinkedIn. Pour Instagram : `[À COMPLÉTER : garder ou retirer]`.

### Navigation

Mets à jour le menu : Accueil, Services, Offres, Réalisations, À propos, Contact. Ajoute un bouton « Parlons de votre projet » bien visible dans le header.

## SEO et technique

- Corrige `canonical`, `og:url` et `og:image` pour qu'ils utilisent **https**.
- `<title>` : « Etienne Walch — Développeur web freelance à Mulhouse | Sites et outils sur mesure ».
- Meta description : sites et outils métier sur mesure, livrés rapidement grâce à l'IA, par un développeur expérimenté basé à Mulhouse.
- Ajoute des données structurées **JSON-LD** (`ProfessionalService` ou `LocalBusiness` + `Person`) avec le nom, le lieu (Mulhouse, Alsace), l'URL, les services et les profils sociaux.
- Un seul `<h1>` par page, une hiérarchie de titres propre et des `alt` descriptifs sur les images.
- Optimise les images : formats WebP/AVIF, dimensions adaptées, `loading="lazy"` sauf pour le hero.
- Vérifie le responsive (mobile d'abord), l'accessibilité (contrastes, focus visibles, labels de formulaire) et les performances.

## Vérification avant de me rendre la main

1. Lance le projet en local et vérifie que toutes les pages et sections s'affichent sans erreur.
2. Teste l'envoi du formulaire de contact et du formulaire de demande d'accès à la démo.
3. Vérifie le rendu sur mobile, tablette et desktop.
4. Lance les tests existants s'il y en a, plus un `lint:twig` et un `lint:container`.
5. Fais-moi un **récapitulatif** : ce qui a changé, la liste des `[À COMPLÉTER]` restants, et tes suggestions pour la suite (pages dédiées par offre, page « Projet IA bloqué » optimisée pour le référencement, blog…).
