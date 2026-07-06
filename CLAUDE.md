# ewalch — Site personnel de Tinou (développeur PHP/Symfony)

## Objectif du projet

Site vitrine + démonstration pour vendre des prestations de développement PHP/Symfony à des particuliers et petites structures. Le site est divisé en deux espaces :

- **Vitrine publique** (`/`) : présentation, parcours, technologies, portfolio de projets en ligne, formulaire de contact, et bouton de demande d'accès à la démo.
- **Espace démo** (`/demo`) : accès sur demande (ROLE_USER), showcase interactif de fonctionnalités typiques d'une application Symfony (authentification, CRUD, filtres, export, etc.) + grille tarifaire permettant aux visiteurs de budgétiser leur projet.
- **Backoffice admin** (`/admin`) : accès ROLE_ADMIN uniquement, gestion du contenu et des utilisateurs.

La cible commerciale est principalement des porteurs de projets individuels cherchant un développeur sur-mesure, sans exclure des projets plus importants.

---

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 8.x, Symfony (dernière version) |
| ORM | Doctrine ORM + Migrations |
| Base de données | PostgreSQL 16 |
| Emails | Brevo (ex-Sendinblue) via `getbrevo/brevo-php` |
| Frontend | Asset Mapper (pas de Webpack/Encore), Bootstrap Icons |
| Auth | Symfony Security, form_login, rôles ROLE_USER / ROLE_ADMIN |
| IDs | UUID v4 personnalisé (`UuidGenerator`, `UuidTrait`) |
| Timestamps | `TimestampTrait` (createdAt / updatedAt via lifecycle callbacks) |
| Infra (dev) | Docker : nginx (8080), PHP-FPM (9000), PostgreSQL (5432), Adminer (8081) |

---

## Structure du projet

```
ewalch/
├── Dockerfile
├── Makefile                  # commandes Docker (start, stop, console, build…)
├── docker/
│   ├── docker-compose.yml
│   ├── nginx/default.conf
│   └── environment/          # api.env, db.env
└── app/                      # application Symfony
    ├── assets/               # JS et CSS (Asset Mapper)
    ├── config/
    │   ├── packages/security.yaml
    │   └── routes/security.yaml
    ├── migrations/
    ├── src/
    │   ├── Command/CreateAdminCommand.php   # php bin/console db:admin:create <email> <password>
    │   ├── Controller/
    │   │   ├── HomeController.php           # vitrine publique + formulaires
    │   │   ├── DemoController.php           # espace démo (protégé)
    │   │   ├── AdminController.php          # backoffice admin
    │   │   └── SecurityController.php       # login / logout
    │   ├── Entity/
    │   │   ├── User.php                     # auth, UUID, rôles JSON
    │   │   └── Project.php                  # projets portfolio
    │   ├── Service/
    │   │   ├── BrevoMailer.php              # envoi d'emails via API Brevo
    │   │   ├── SitemapGenerator.php
    │   │   ├── Manager/UserManager.php      # création / gestion utilisateurs
    │   │   └── Factory/
    │   ├── Helper/UuidGenerator.php
    │   └── Trait/
    │       ├── TimestampTrait.php
    │       └── UuidTrait.php
    └── templates/
        ├── home/
        │   ├── base.html.twig
        │   ├── index/
        │   │   ├── index.html.twig
        │   │   ├── _apropos.html.twig
        │   │   ├── _experiences.html.twig
        │   │   ├── _portfolio.html.twig
        │   │   ├── _contact.html.twig
        │   │   └── _demo.html.twig          # section demande d'accès démo
        │   └── portfolio/                   # modales projets (fitcookies, titine, scoringames…)
        ├── demo/
        │   ├── base.html.twig
        │   └── index/index.html.twig
        ├── admin/
        │   ├── base.html.twig
        │   └── index/index.html.twig
        └── partials/
            ├── _navbar.html.twig
            ├── _navbar_demo.html.twig
            └── security/login.html.twig
```

---

## Sécurité et accès

- `/admin/*` → ROLE_ADMIN uniquement (configuré dans `security.yaml` → `access_control`)
- `/demo/*` → ROLE_USER (à confirmer / appliquer dans `access_control`)
- Authentification : form_login, check sur `emailAddress` (pas `email`)
- Créer un admin : `php bin/console db:admin:create <email> <password>`
- Les utilisateurs demo sont créés manuellement ou via un flow d'inscription contrôlé

---

## Commandes de développement

```bash
make start      # pull + up Docker (nginx, php, postgres, adminer)
make stop       # down Docker
make console    # shell dans le conteneur PHP
make build      # rebuild image PHP sans cache
make sniff      # PHPStan (analyse statique)
```

Accès local :
- Site : http://localhost:8080
- Adminer : http://localhost:8081

---

## Ce qui est en cours de développement

### Priorité 1 — Espace démo (`/demo`)

L'objectif est de construire un espace interactif illustrant les fonctionnalités typiques d'une application Symfony sur mesure. Chaque fonctionnalité est présentée comme un "module" démontrable :

- Authentification (login, logout, gestion de session)
- CRUD complet avec formulaires Symfony
- Filtres / recherche (QueryBuilder Doctrine)
- Upload de fichiers
- Envoi d'emails (Brevo)
- Export (CSV, PDF)
- Pagination
- Gestion de rôles et permissions
- API REST simple
- Tableau de bord avec indicateurs (graphiques JS légers)

### Priorité 2 — Grille tarifaire

Page ou section dans `/demo` ou sur la vitrine présentant une grille de prix modulaire :
- Permettre aux visiteurs de composer leur projet (checkboxes / sélecteurs de modules)
- Afficher une estimation de prix et de délai
- Objectif : autonomiser le prospect avant le premier contact

### Priorité 3 — Gestion des demandes d'accès démo

Le formulaire `_demo.html.twig` collecte un email. Le flow complet à implémenter :
1. Enregistrer la demande en base (nouvelle entité `DemoRequest` ?)
2. Notifier l'admin par email (Brevo)
3. L'admin crée un compte ROLE_USER depuis le backoffice
4. Envoyer les identifiants au demandeur par email

---

## Conventions de code

- **UUIDs** sur toutes les entités via `UuidTrait` + `UuidGenerator`
- **Timestamps** sur toutes les entités via `TimestampTrait`
- Entités dans `App\Entity`, repositories dans `App\Repository`
- Services métier dans `App\Service\Manager\` (logique) et `App\Service\Factory\` (construction d'objets)
- Templates organisés par contrôleur (`home/`, `demo/`, `admin/`, `partials/`)
- Partials préfixés par `_` (ex: `_navbar.html.twig`, `_contact.html.twig`)
