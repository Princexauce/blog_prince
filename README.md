# Mon Blog — blog_prince

Blog personnel développé avec **Laravel 13**, **Tailwind CSS** et un espace d’administration.

## Fonctionnalités

- Page d’accueil avec liste des articles
- Page article (commentaires, likes, vues)
- Administration : articles, commentaires, likes
- Éditeur de contenu riche (Quill) avec insertion et redimensionnement d’images
- Image de couverture par article

## Prérequis

- PHP 8.3+
- Composer
- Node.js et npm

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
```

## Lancement

```bash
composer run dev
```

Ou :

```bash
php -d upload_max_filesize=10M -d post_max_size=12M artisan serve
npm run dev
```

Site : http://127.0.0.1:8000  
Admin : http://127.0.0.1:8000/admin/login

### Compte admin (après `migrate --seed`)

- Email : `adminblog@gmail.com`
- Mot de passe : `password`

## Structure utile

| Dossier | Rôle |
|---------|------|
| `app/Http/Controllers/Admin/` | Contrôleurs admin |
| `resources/views/` | Vues Blade |
| `routes/web.php` | Routes publiques |
| `routes/admin.php` | Routes admin |

## Licence

Projet étudiant — usage personnel.
