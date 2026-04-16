# Projet Laravel + Vue.js (Groupe)

Bienvenue sur le projet ! Pour que tout le monde travaille avec la même configuration (PHP, PostgreSQL, Node), nous utilisons **Laravel Sail**.  

## 🛠 Prérequis

*   **Docker** installé et lancé sur votre machine.
*   **PHP** et **Composer** installés localement (uniquement pour l'initialisation).

---

## 🚀 Installation (Première fois uniquement)

Suivez ces étapes dans l'ordre pour lancer le projet :

1.  **Cloner le projet**
    ```bash
    git clone [LIEN_DU_REPO]
    cd yowl
    ```

2.  **Installer les dépendances PHP**
    ```bash
    composer install
    ```

3.  **Configurer l'environnement**
    ```bash
    cp .env.example .env
    ```
    > **Note :** Si vous avez déjà un PostgreSQL local sur le port **5432**, ouvrez le fichier `.env` et modifiez la ligne : `FORWARD_DB_PORT=5433`.

4.  **Lancer Docker via Sail**
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Initialiser l'application**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate
    ```

6.  **Installer Vue.js et lancer le serveur de dev**
    ```bash
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run dev
    ```

---

## 📊 Schéma de la Base de Données

### Tables principales
*   **Users** : `id`, `pseudo` (unique), `email` (unique), `password`, `role`, `timestamps`
*   **Posts** : `id`, `url` (unique), `title`, `image_url`, `timestamps`
*   **Comments** : `id`, `user_id` (index), `post_id` (index), `parent_id` (index), `content`, `timestamps`

### Tables de liaisons (Likes)
*   **Post_Likes** : `id`, `user_id`, `post_id` (Unique composite pour 1 seul like par user/post)
*   **Comment_Likes** : `id`, `user_id`, `comment_id`

---

## 💡 Commandes Utiles au Quotidien

*   **Démarrer le projet :** `sail up -d`
*   **Arrêter le projet :** `sail stop`
*   **Exécuter une commande Artisan :** `sail artisan ...`
*   **Installer un package JS :** `sail npm install package-name`
*   **Accéder à la base de données (CLI) :** `sail psql -U sail`

---
*Astuce : Pensez à configurer un alias pour taper simplement `sail` au lieu de `./vendor/bin/sail`.*

---

## 🌿 Workflow Git du Projet

> ⚡ Objectif : garder un code **propre, stable et collaboratif**

---

### 🧭 Stratégie de branches

```

main  ← (stable / production)
↑
dev   ← (intégration des fonctionnalités)
↑
feat/* ← (travail individuel)

````

- ❌ Interdiction de travailler directement sur `main`
- ⚠️ Pas de push direct sur `dev`
- ✅ Chaque tâche = une branche `feat/*`

---

### 🚀 1. Créer sa branche de travail

Avant toute chose, mettez à jour `dev` :

```bash
git checkout dev
git pull origin dev
git checkout -b feat/nom-de-votre-tache
````

💡 Exemple :

```bash
git checkout -b feat/authentification-utilisateur
```

---

### 🧱 2. Convention de commits

> Des commits clairs = un projet maintenable

#### 📌 Format

```
<type>[scope]: <description courte>
```

#### 🔑 Types autorisés

| Type     | Description                                |
| -------- | ------------------------------------------ |
| feat     | Nouvelle fonctionnalité                    |
| fix      | Correction de bug                          |
| docs     | Documentation                              |
| style    | Formatage (sans impact logique)            |
| refactor | Amélioration interne du code               |
| perf     | Optimisation                               |
| test     | Ajout/modification de tests                |
| chore    | Tâches techniques (config, dépendances...) |

#### ✅ Exemple

```bash
git add .
git commit -m "feat(auth): ajout du système de connexion"
```

---

### 📤 3. Push vers GitHub

```bash
git push origin feat/nom-de-votre-tache
```

---

### 🔁 4. Pull Request (PR)

#### Étapes :

1. Aller sur GitHub
2. Cliquer sur **"Compare & pull request"**
3. Vérifier :

```diff
-base: main
+base: dev ✅
```

4. Ajouter une description claire :

   * Ce que tu as fait
   * Pourquoi tu l’as fait
   * Éventuels impacts

#### ❗ Règles

* ❌ Ne jamais merge soi-même
* ✅ Attendre validation d'un membre

---

### 🔒 Règle critique du projet

> 🚨 **Le merge vers `main` est STRICTEMENT contrôlé**

* Se fait uniquement :

  * à la fin du projet par Jaures
  * via une PR globale depuis `dev`
* Objectif : garantir une version **100% stable**

---

### 💡 Bonnes pratiques

* 🔁 Pull régulièrement `dev`
* ✂️ Faire des commits petits et clairs
* 🧠 Nommer ses branches intelligemment
* 🗣️ Communiquer en cas de blocage

---

### 🧩 Philosophie du workflow

> "Un bon code, c’est un code que les autres comprennent vite."

Ce workflow est là pour :

* faciliter la collaboration 🤝
* éviter les conflits ⚔️
* garantir la qualité 🧼

---

🔥 **Respecter ces règles = projet propre + équipe efficace**