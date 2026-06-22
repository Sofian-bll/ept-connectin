<p align="center">
  <a href="https://github.com/Sofian-bll/ept-connectin">
    <img src="assets/logo.svg" alt="Logo" width="160"/>
  </a>
</p>

<p align="center">
  <a href="https://github.com/Sofian-bll/ept-connectin/blob/main/LICENSE"><img src="https://img.shields.io/github/license/Sofian-bll/ept-connectin?style=flat" alt="License"/></a>
  <a href="https://github.com/Sofian-bll/ept-connectin/releases"><img src="https://img.shields.io/github/v/release/Sofian-bll/ept-connectin?style=flat" alt="Version"/></a>
  <a href="https://github.com/Sofian-bll/ept-connectin/stargazers"><img src="https://img.shields.io/github/stars/Sofian-bll/ept-connectin?style=flat" alt="Stars"/></a>
</p>

<h1 align="center" id="readme-top">Connect'IN</h1>

<p align="center">
  Réseau social interne pour ESN — API REST Laravel + Vue.js
  <br/>
  <br/>
  🇫🇷 <a href="README.md"><b>Français</b></a> · 🇬🇧 <a href="README.en.md">English</a>
</p>

---

<details open>
  <summary>Table des matières</summary>
  <ol>
    <li><a href="#about">À propos</a></li>
    <li><a href="#built-with">Stack technique</a></li>
    <li><a href="#getting-started">Prise en main</a></li>
    <li><a href="#usage">Utilisation</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#license">Licence</a></li>
  </ol>
</details>

---

## À propos <a id="about"></a>

<img src="erb.30.50.png" alt="Diagramme ERB" width="100%">

Connect'IN est une plateforme de réseau social interne destinée aux ESN (Entreprises de Services du Numérique). Elle permet aux collaborateurs de partager des posts, commenter, liker et gérer leur profil.

Le projet est composé d'une API REST Laravel (backend) et d'une interface Vue.js (frontend).

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Stack technique <a id="built-with"></a>

- [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com) — API REST backend
- [![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=flat&logo=vuedotjs&logoColor=4FC08D)](https://vuejs.org) — Frontend SPA
- [![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com) — Base de données
- [![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com) — Design system
- [![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white)](https://www.docker.com) — Conteneurisation
- [![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net) — Runtime backend
- [![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat&logo=vite&logoColor=white)](https://vitejs.dev) — Bundler frontend

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Prise en main <a id="getting-started"></a>

### Prérequis

- [Docker](https://orbstack.dev) (OrbStack ou Docker Desktop)
- PHP 8.2+
- Composer

### Installation

1. Cloner le dépôt
   ```sh
   git clone https://github.com/Sofian-bll/ept-connectin.git
   cd ept-connectin
   ```

2. Installer les dépendances et démarrer les conteneurs
   ```sh
   make install
   ```

3. Initialiser la base de données (migrations + seeders)
   ```sh
   make fresh
   ```

Le backend est accessible sur `http://localhost`.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Utilisation <a id="usage"></a>

### Commandes disponibles

| Commande | Description |
|----------|-------------|
| `make install` | Installation initiale (dépendances + conteneurs + migration) |
| `make up` | Démarrer les conteneurs |
| `make down` | Arrêter les conteneurs |
| `make build` | Reconstruire les images Docker |
| `make migrate` | Exécuter les migrations |
| `make fresh` | Réinitialiser la BDD (migration + seeders) |
| `make seed` | Exécuter les seeders |
| `make shell` | Ouvrir un shell dans le conteneur backend |
| `make tinker` | Ouvrir Laravel Tinker |
| `make routes` | Lister toutes les routes API |
| `make test` | Lancer les tests |

### Documentation API interactive

Une documentation OpenAPI générée automatiquement par [Scramble](https://scramble.dedoc.co) est disponible à l'adresse :

```
http://localhost/docs/api
```

Un Bearer token (obtenu via `/api/v1/login`) est requis pour tester les routes protégées.

### Collection Bruno

Une collection [Bruno](https://usebruno.com) est disponible dans le dossier `bruno/` pour tester l'API localement.

1. Ouvrir Bruno et importer le dossier `bruno/`
2. Sélectionner l'environnement `local`
3. Renseigner le token Bearer après login

### Diagramme BDD

Le diagramme entité-relation est disponible sur [DrawSQL](https://drawsql.app).

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Roadmap <a id="roadmap"></a>

- [x] Auth (register, login, logout)
- [x] CRUD Posts + pagination + upload média
- [x] CRUD Commentaires
- [x] Likes toggle
- [x] Gestion du profil + avatar
- [x] Suppression de compte (delete / anonymize)
- [x] Seeders & Factories
- [x] Documentation API (Scramble / OpenAPI)
- [ ] Filtrage et recherche sur les posts
- [ ] Notifications (like, commentaire)
- [ ] Groupes / équipes

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Contact <a id="contact"></a>

**Sofian Belloul** — [@Sofian-bll](https://github.com/Sofian-bll)

**Kyllian Rullier** — [@kyllianR](https://github.com/kyllianR)

Lien du projet : [https://github.com/Sofian-bll/ept-connectin](https://github.com/Sofian-bll/ept-connectin)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Licence <a id="license"></a>

Distribué sous licence MIT. Voir [LICENSE](LICENSE) pour plus d'informations.

<p align="right">(<a href="#readme-top">back to top</a>)</p>
