# Larapid

A Docker environment for developing Laravel applications.

## Create a new project
```
docker-compose run --rm composer create-project --prefer-dist laravel/laravel .
```

After download the sources, edit the `.env` file:

```
DB_HOST=db
DB_DATABASE=project
DB_USERNAME=project
DB_PASSWORD=project
```

## Setup

```
sudo ./bin/install -b
```

## Server
```
docker-compose up server
```

## Artisan
```
docker-compose run --rm php artisan
```

## PHP Code Sniffer
```
docker-compose run --rm phpcs
```

## Assets

#### Install
```
docker-compose run --rm yarn
```

#### Development build
```
docker-compose run --rm yarn watch
```
