
##### Demo Credentials

**Admin:** admin@admin.com  
**Password:** secret

**User:** user@user.com  
**Password:** secret


## Installation

Requirement : PHP 7.3 > , composer v2

link : https://getcomposer.org/download/

1 . Download all dependencies

```bash
php composer install
```

2 . Copy .env.example to .env and change the DB credential.

3 . Migrating DB

```
php artisan migrate
```

4 . Seeding DB

```
php artisan db:seed
```

5 . Link storage folder to public

```
php artisan storage:link
```

6 . To regenerate DB (All data will deleted)

```
php artisan migrate:fresh --seed
```

7 . Generate APP key

```
php artisan key:generate
```
Error : 
Invalid folder cache : https://tecadmin.net/laravel-please-provide-a-valid-cache-path-fixed/

## Excel export performance (cPanel)

Master list exports use fixed column widths and load only required fields in
1,000-row chunks. WhatsApp Bot exports use the same approach, precompute billing
totals and parcel counts in the pickup query, and wrap messages in column J.
Excel cell caching retains the dedicated file store to limit
memory use on shared hosting. Avoid switching to `batch` with the currently
installed dependencies: spilling buffered cells to disk can fail with
`Spreadsheet objects cannot be serialized`.

After deploying, run `php artisan config:clear` with the domain's PHP version.
Keep `storage/framework/cache/excel-cells` writable. If `.env` overrides the Excel
cache driver, use `EXCEL_CACHE_DRIVER=illuminate` and clear the config cache again.
