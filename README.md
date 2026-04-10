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
