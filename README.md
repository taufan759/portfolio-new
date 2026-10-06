# Portfolio — Muhammad Taufan Akbar

Laravel 12 portfolio: projects, certificates, books, blog, tech-news scraper, and a small admin panel.
Designed to stay light on shared hosting (cPanel): no Node build step, WebP images, RSS-only scraper (no AI).

## Features

- Public site: home (hero with liquid cursor reveal, portfolio filter, certificates, journal), `/blog`, `/books`, `/news`
- Admin at `/admin`: manage projects, certificates, books, blog posts (Markdown), read contact messages
- Image uploads are resized and converted to WebP automatically
- Tech news: Indonesian outlets (Dicoding, Liputan6, CNN Indonesia, Antara, JagatReview) filtered by keywords relevant to web dev, AI and UI/UX (`config/news.php`). Refreshes hourly via cron, and also automatically when the site is visited and data is older than `refresh_minutes`, so it works even without cron.

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
# set ADMIN_EMAIL / ADMIN_PASSWORD in .env
php artisan migrate --seed
php artisan serve
```

Fetch headlines manually: `php artisan news:fetch`

## Deploy to cPanel

1. **PHP**: select PHP 8.2+ in *MultiPHP Manager* and enable `gd` (WebP), `mbstring`, `pdo_mysql`, `xml`, `curl`.
2. **Database**: create a MySQL database and user in *MySQL Databases*.
3. **Upload** the project to a folder **outside** `public_html`, e.g. `/home/USER/portfolio-new` (git clone via Terminal, or zip).
4. **Document root**: in *Domains*, point the domain/subdomain document root to `/home/USER/portfolio-new/public`.
   If you cannot change it, copy the contents of `public/` into `public_html/` and edit the two paths in `public_html/index.php` to point to the project folder.
5. **Environment**: create `.env` on the server:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...
   SESSION_DRIVER=database
   ADMIN_EMAIL=you@example.com
   ADMIN_PASSWORD=a-strong-password
   ```
6. **Install and migrate** (Terminal in cPanel):
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --force --seed
   php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
   Remove `ADMIN_PASSWORD` from `.env` after the first seed.
7. **Cron** (*Cron Jobs*, every minute) so the news scraper runs hourly:
   ```
   * * * * * /usr/local/bin/php /home/USER/portfolio-new/artisan schedule:run >> /dev/null 2>&1
   ```
8. Make sure `storage/` and `bootstrap/cache/` are writable.

## Keeping it light

- Images are WebP (hero, projects, certificates). Upload JPG/PNG in admin; they are converted.
- News scraper: 10 items per source, 30-day retention (`config/news.php`). Add or remove feeds there.
- The scheduler makes one HTTP request per feed per hour.

## Security notes

- Admin routes require login and are rate-limited; the contact form is throttled (5/min).
- Blog Markdown is rendered with raw HTML stripped.
- Change the default admin password before going live and never commit `.env`.
