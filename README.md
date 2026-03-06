<a id="readme-top"></a>

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stars][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<br />
<div align="center">
  <a href="https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20">
    <img src="docs/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Connect'IN</h3>

  <p align="center">
    Réseau social interne pour ESN — API REST Laravel + Vue.js
    <br />
    <a href="http://localhost/docs/api"><strong>Documentation API »</strong></a>
    <br />
    <br />
    <a href="https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20/issues/new">Reporter un bug</a>
  </p>
</div>

---

## À propos du projet

<img src="docs/screenshot.png" alt="Screenshot" width="100%">

Connect'IN est une plateforme de réseau social interne destinée aux ESN (Entreprises de Services du Numérique). Elle permet aux collaborateurs de partager des posts, commenter, liker et gérer leur profil.

Le projet est composé d'une API REST Laravel (backend) et d'une interface Vue.js (frontend).

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Stack technique

[![Laravel][Laravel.com]][Laravel-url]
[![Vue][Vue.js]][Vue-url]
[![MySQL][MySQL.com]][MySQL-url]
[![TailwindCSS][TailwindCSS.com]][TailwindCSS-url]
[![Docker][Docker.com]][Docker-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Prise en main

### Prérequis

- [Docker](https://orbstack.dev) (OrbStack ou Docker Desktop)
- PHP 8.2+
- Composer

### Installation

1. Cloner le dépôt
   ```sh
   git clone https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20.git
   cd W-WEB-103-PAR-1-1-connect_in-20
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

---

## Utilisation

### Commandes disponibles

| Commande       | Description                                              |
|----------------|----------------------------------------------------------|
| `make install` | Installation initiale (dépendances + conteneurs + migration) |
| `make up`      | Démarrer les conteneurs                                  |
| `make down`    | Arrêter les conteneurs                                   |
| `make build`   | Reconstruire les images Docker                           |
| `make migrate` | Exécuter les migrations                                  |
| `make fresh`   | Réinitialiser la BDD (migration + seeders)               |
| `make seed`    | Exécuter les seeders                                     |
| `make shell`   | Ouvrir un shell dans le conteneur backend                |
| `make tinker`  | Ouvrir Laravel Tinker                                    |
| `make routes`  | Lister toutes les routes API                             |
| `make test`    | Lancer les tests                                         |

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

---

## Roadmap

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

---

## Contact

**Sofian Belloul** — [@Sofian-bll](https://github.com/Sofian-bll)

**Kyllian Rullier** — [@kyllianR](https://github.com/kyllianR)

Lien du projet : [https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20](https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

<!-- MARKDOWN LINKS & IMAGES -->
[contributors-shield]: https://img.shields.io/github/contributors/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20.svg?style=for-the-badge
[contributors-url]: https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20.svg?style=for-the-badge
[forks-url]: https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20/network/members
[stars-shield]: https://img.shields.io/github/stars/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20.svg?style=for-the-badge
[stars-url]: https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20/stargazers
[issues-shield]: https://img.shields.io/github/issues/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20.svg?style=for-the-badge
[issues-url]: https://github.com/EpitechWebAcademiePromo2027/W-WEB-103-PAR-1-1-connect_in-20/issues

[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org
[MySQL.com]: https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white
[MySQL-url]: https://www.mysql.com
[TailwindCSS.com]: https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white
[TailwindCSS-url]: https://tailwindcss.com
[Docker.com]: https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white
[Docker-url]: https://www.docker.com
