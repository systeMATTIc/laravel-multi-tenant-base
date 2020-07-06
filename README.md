# Multitenant Base

This is basically an opinionated and preconfigured application development template for multi-tenant application. It is based on the Laravel Framework and its a single database multi-tenant bootstrapper.

## Basic Features

This bootstrapper for multi-tenant applications already contains are some necessary features, such as:

-   Tenant Management
-   Administrator Management
-   User Management
-   Roles Management
-   Near Realtime Notifications

These features are accompanied with a fully responsive user interface to help get started.

## Tailwindcss, AlpineJS, Laravel and Livewire (TALL)

With respect to being opinionated. This bootstrapper tries to imbibe the opinions of each technology in the **TALL** Stack as these opinions make developing production grade applications a breeze.
Any developer utilizing this bootstrapper is encouraged to do the same.

## Setup

1.  Requirements

```
PHP 7.4, MYSQL 5.7
```

2.  Clone the repository:

```
git clone https://github.com/systeMATTIc/laravel-multi-tenant-base.git your-app-name

cd your-app-name
```

2.  Install Dependencies

```
composer install

touch .env.example .env

php artisan key:generate
```

3. Setup your database and mail connection in the `.env`

4. Install and Compile UI Assets for development

```
npm install

npm run dev
```

5. Install the application

```
php artisan install
```

This will run migrations and populate base records. You'll be prompted with some questions with regards to creating your administrator account.

6. Access the application

> Visit `http://{your-app-route}/admin/login` to access the application.

7. Start building your application

## Environment Variables

When creating a new tenant, the following `env` variables are required

> `BASE_URL`: This is the base url of your domain

> `TENANT_SUBDOMAIN_SUFFIX`: if any value is provided here, the subdomain is suffixed with it.

> `TENANT_SUBDOMAIN`: _Boolean_ - indicates if a tenant is assigned a subdomain or created on a new domain.

## Credits

-   Laravel
-   AlpineJS
-   Livewire
-   Tailwindcss
-   Spatie/laravel-multitenancy
-   Silber/Bouncer
