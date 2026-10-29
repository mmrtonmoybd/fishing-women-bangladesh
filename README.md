# Fishing Women Bangladesh

A Bangla-language community reporting platform where fishing women in Bangladesh, and the people who work with them, share stories, photos, videos, and audio from their communities. Organised by [Report71](https://www.report71.com/).

Built with Laravel 12, Filament 3, and Livewire 3.

## Features

### Public website

- Bangla interface with a homepage slider, post listings by category, and single post pages with social sharing
- **Submit a post without an account:** guests add a name, title, category, content, and a photo, video, or audio file, or a YouTube link
- **Member accounts:** register and log in with a mobile number. Bangla digits (০–৯) are converted automatically
- **Member profile:** view, edit, and delete your own posts, and edit your profile
- Markdown content with file uploads
- Static pages, `sitemap.xml`, and SEO / Open Graph tags from the site settings
- Installable as a Progressive Web App (PWA) with an offline page

### Admin panel (`/admin`)

- Manage posts, categories, pages, and homepage slides
- **Pending posts** queue to review and publish submissions from guests and members
- Separate lists for admins and registered members
- **Settings** for brand name, logo, and SEO title and description
- Roles and permissions (Filament Shield), profile management (Filament Breezy), and an activity log
- Switchable admin themes and login backgrounds

## Tech stack

| Layer    | Packages                                                     |
| -------- | ------------------------------------------------------------ |
| Backend  | PHP 8.2+, Laravel 12                                         |
| Admin UI | Filament 3, Filament Shield, Filament Breezy, Filament Settings |
| Frontend | Blade, Livewire 3, Bootstrap, Swiper                         |
| Tooling  | PHPUnit, Larastan, Pint, Debugbar, IDE Helper                |

## Getting started

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- SQLite (default) or MySQL

### Installation

```bash
git clone https://github.com/mmrtonmoybd/fishing-women-bangladesh.git
cd fishing-women-bangladesh

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
```

To use MySQL, set `DB_CONNECTION=mysql` and the `DB_*` values in `.env` before migrating.

The seeder creates an admin account, `test@example.com`, with password `password`. Change it right away. To give it full permissions:

```bash
php artisan shield:super-admin
```

Set the site name and logo under **Settings** in the admin panel. Update `start_url` and `scope` in `public/manifest.json` to your live domain for the PWA.

### Run locally

```bash
composer dev
```

Visit the site at `http://localhost:8000` and the admin panel at `http://localhost:8000/admin`.

## Testing and code style

```bash
php artisan test     # test suite
vendor/bin/pint      # fix PHP code style
vendor/bin/phpstan   # static analysis
```

## Credits

- Organised by [Report71](https://www.report71.com/)
- Built on the [Laravel Filament Starter Kit](https://github.com/ercogx/laravel-filament-starter-kit) by ercogx

## Author

Moshiur Rahman — [rmedha037@gmail.com](mailto:rmedha037@gmail.com)

## License

Released under the [MIT License](LICENSE.md).
