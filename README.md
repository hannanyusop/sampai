
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
