# 🗣️ YOWL — La couche conversationnelle du web

> *« Chaque page du web mérite d'avoir une communauté qui lui répond. »*

Internet concentre des milliards de contenus — articles, vidéos, produits, publications — mais les réactions des internautes restent dispersées et enfermées dans des silos. **YOWL** brise ces silos en proposant un système de commentaires universel, ancré sur l'URL de n'importe quelle page web, accessible à toute une communauté en temps réel.

---

## ✅ Fonctionnalités réalisées

| Fonctionnalité | Statut |
|---|---|
| Inscription & Connexion | ✅ |
| Recherche par URL, nom de domaine ou mot-clé | ✅ |
| Créer un post + commentaire sur une URL non existante en base | ✅ |
| Page de discussion liée à une URL avec affichage des commentaires | ✅ |
| Ajouter un commentaire sur un post existant | ✅ |
| Répondre à un commentaire (thread imbriqué) | ✅ |
| Modifier / Supprimer son commentaire | ✅ |
| Liker un commentaire | ✅ |
| Modifier son profil (pseudo, email, avatar…) | ✅ |
| Dashboard Admin avec 5 KPI | ✅ |
| Page Tendances (posts les plus commentés / likés) | ✅ |
| Système de notifications (inscription, création de post, réponse, actions utilisateur) | ✅ |

---

## 📸 Aperçu de l'application

### Page d'accueil — Fil des posts
![Accueil YOWL]([![image-(1).jpg](https://i.postimg.cc/sDpFFB6Y/image-(1).jpg)](https://postimg.cc/cr4kwJNC))
> Découverte des posts de la communauté avec aperçu de l'image, du titre, du nombre de likes et de commentaires.

---

### Connexion
![Page de connexion]([![yowl-login.jpg](https://i.postimg.cc/6pYmwCdG/yowl-login.jpg)](https://postimg.cc/3k0BF4fK))
> Interface d'authentification épurée avec redirection vers l'inscription.

---

### Créer un post
![Faire un post]([![yowl-post.jpg](https://i.postimg.cc/fTs298Ct/yowl-post.jpg)](https://postimg.cc/Lhy3dBr2))
> Formulaire minimaliste — coller une URL + rédiger un commentaire, c'est tout.

---

### Page de discussion liée à une URL
![Page post & commentaires]([![yowl-post-page.jpg](https://i.postimg.cc/50vgHzFn/yowl-post-page.jpg)](https://postimg.cc/r0Vx3Kjr))
> Affichage de l'aperçu de la page web commentée (image, titre, URL), suivi du fil de commentaires avec likes, réponses et actions.

---

### Dashboard Admin — KPI
![Dashboard Admin KPI]([![yowl-admin-kpi.jpg](https://i.postimg.cc/YC9x6ZmT/yowl-admin-kpi.jpg)](https://postimg.cc/ppw8x0CB))
> Vue analytique avec 4 compteurs temps réel (utilisateurs, posts, commentaires, likes), graphique d'activité hebdomadaire et répartition des top domaines.

---

### Dashboard Admin — Gestion du contenu
![Dashboard Admin CRUD]([![yowl-admin-crud.jpg](https://i.postimg.cc/rFyGT3gD/yowl-admin-crud.jpg)](https://postimg.cc/py75Y0wv))
> Interface de modération : liste des posts avec auteur, date et action de suppression. Recherche intégrée par contenu ou URL.

---

## 📐 Architecture du projet

```
┌──────────────────────────────────────────────────────────────────┐
│                        YOWL — ARCHITECTURE                       │
│                                                                  │
│   [Navigateur / Vue.js SPA]                                      │
│          │  Requêtes HTTP (JSON)                                 │
│          ▼                                                       │
│   [API REST — Laravel]                                           │
│    • Authentification (JWT / Session)                            │
│    • Gestion des posts, commentaires, likes, notifs              │
│    • Middleware & validation serveur                             │
│    • Protection CSRF / CORS                                      │
│          │                                                       │
│          ▼                                                       │
│   [PostgreSQL]                                                   │
│    • Users, Posts, Comments, Likes, Notifications                │
└──────────────────────────────────────────────────────────────────┘
```

---

## 🛠️ Stack technique

| Couche | Technologie | Rôle |
|---|---|---|
| Backend | PHP / Laravel | API REST, ORM Eloquent, routing, middleware, sécurité |
| Frontend | JavaScript / Vue.js | SPA réactive, composants modulaires |
| Base de données | PostgreSQL | Persistance et intégrité des données |
| Environnement | Laravel Sail (Docker) | Configuration unifiée pour toute l'équipe |
| Versioning | GitHub | Collaboration, branches, revue de code |
| Design | Figma | Maquettes UI et prototype interactif |

---

## 📊 Schéma de la Base de Données

### Tables principales

- **Users** : `id`, `pseudo` (unique), `email` (unique), `password`, `avatar`, `role`, `timestamps`
- **Posts** : `id`, `url` (unique), `title`, `image_url`, `timestamps`
- **Comments** : `id`, `user_id` (index), `post_id` (index), `parent_id` (index, nullable — threads imbriqués), `content`, `timestamps`
- **Notifications** : `id`, `user_id`, `type`, `data`, `read_at`, `timestamps`

### Tables de liaison (Likes)

- **Post_Likes** : `id`, `user_id`, `post_id` — contrainte unique composite (1 seul like par user/post)
- **Comment_Likes** : `id`, `user_id`, `comment_id`

---

## 🚀 Installation (Première fois uniquement)

### Prérequis

- **Docker** installé et lancé sur votre machine
- **PHP** et **Composer** installés localement (uniquement pour l'initialisation)

### Étapes

**1. Cloner le projet**
```bash
git clone [LIEN_DU_REPO]
cd yowl
```

**2. Installer les dépendances PHP**
```bash
composer install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
```
> ⚠️ Si vous avez déjà un PostgreSQL local sur le port **5432**, ouvrez `.env` et modifiez : `FORWARD_DB_PORT=5433`

**4. Lancer Docker via Sail**
```bash
./vendor/bin/sail up -d
```

**5. Initialiser l'application**
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
```

**6. Installer Vue.js et lancer le serveur de développement**
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

L'application est accessible sur **http://localhost**.

> 💡 Astuce : configurez un alias `alias sail='./vendor/bin/sail'` pour taper simplement `sail` au lieu de `./vendor/bin/sail`.

---

## 💡 Commandes utiles au quotidien

| Action | Commande |
|---|---|
| Démarrer le projet | `sail up -d` |
| Arrêter le projet | `sail stop` |
| Exécuter une commande Artisan | `sail artisan <commande>` |
| Lancer les migrations | `sail artisan migrate` |
| Installer un package JS | `sail npm install <package>` |
| Accéder à la base de données (CLI) | `sail psql -U sail` |

---

## 🌿 Workflow Git du projet

> ⚡ Objectif : garder un code **propre, stable et collaboratif**

### Stratégie de branches

```
main    ← stable / production
  ↑
dev     ← intégration des fonctionnalités
  ↑
feat/*  ← travail individuel par tâche
```

- ❌ Interdiction de travailler directement sur `main`
- ⚠️ Pas de push direct sur `dev`
- ✅ Chaque tâche = une branche `feat/*`

### 1. Créer sa branche de travail

Toujours partir d'un `dev` à jour :

```bash
git checkout dev
git pull origin dev
git checkout -b feat/nom-de-votre-tache
```

Exemple :
```bash
git checkout -b feat/authentification-utilisateur
```

### 2. Convention de commits

Format :
```
<type>[scope]: <description courte>
```

| Type | Description |
|---|---|
| `feat` | Nouvelle fonctionnalité |
| `fix` | Correction de bug |
| `docs` | Documentation |
| `style` | Formatage (sans impact logique) |
| `refactor` | Amélioration interne du code |
| `perf` | Optimisation |
| `test` | Ajout/modification de tests |
| `chore` | Tâches techniques (config, dépendances…) |

Exemple :
```bash
git add .
git commit -m "feat(auth): ajout du système de connexion"
```

### 3. Push vers GitHub

```bash
git push origin feat/nom-de-votre-tache
```

### 4. Pull Request (PR)

1. Aller sur GitHub → **"Compare & pull request"**
2. Vérifier que la base cible est bien `dev` (pas `main`)
3. Décrire clairement : ce qui a été fait, pourquoi, et les impacts éventuels
4. ❌ Ne jamais merger soi-même — attendre la validation d'un membre de l'équipe

### Règle critique

> 🚨 Le merge vers `main` est **strictement contrôlé** — il se fait uniquement en fin de projet par Jaures, via une PR globale depuis `dev`, pour garantir une version 100% stable.

---

## 📈 Dashboard Admin — KPI suivis

Le dashboard administrateur expose 5 indicateurs clés de performance pour piloter la plateforme :

| KPI | Description |
|---|---|
| Commentaires postés | Volume total de commentaires publiés sur la plateforme |
| Contenus les plus commentés | Pages web avec le plus grand nombre de réactions |
| Total utilisateurs | Volume total de commentaires, posts et utilisateurs inscrits sur la plateforme parjour |

---

## 🔔 Système de notifications

Les notifications toasts sont déclenchées automatiquement pour toutes les actions utilisateur significatives :

- À l'**inscription** — message de bienvenue
- À la **création d'un post** — confirmation et récapitulatif
- À la **réponse** à un commentaire — alerte au commentaire parent
- Pour toute **action communautaire** (like reçu, mention, etc.)

---

## 👥 Équipe projet

Projet développé en équipe de 4 personnes dont moi le chef de projet — Avril 2026.
