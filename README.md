# Social Media Website

## Project Overview

A full-stack social media platform built with Laravel (PHP) and Vue 3.  
Features include user authentication, group-based interaction, posting, commenting, and more.

## Technologies Used

Backend: PHP (Laravel), Docker, Ubuntu

Frontend: Vue 3, Tailwind CSS

Database: MySQL

Auth: Laravel Breeze


## Installation with docker

#### 1. Clone the project
```bash
git clone https://github.com/domysu/socialmedia.git
```

#### 2. Run `composer install`
Navigate into project folder using terminal and run

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

#### 3. Copy `.env.example` into `.env`

```bash
cp .env.example .env
```

#### 4. Start the project in detached mode

```bash
./vendor/bin/sail up -d
```
From now on whenever you want to run artisan command you should do this from the container. <br>
Access to the docker container
```bash
./vendor/bin/sail bash
```

#### 5. Set encryption key

```bash
php artisan key:generate --ansi
```

#### 6. Run migrations

```bash
php artisan migrate
```
