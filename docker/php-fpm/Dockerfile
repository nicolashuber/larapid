FROM php:8.0.7-fpm

RUN set -ex; \
        \
        # Image build dependencies
        apt update; \
        # Install Xdebug and Redis extension
        pecl install xdebug; \
        pecl install redis; \
        docker-php-ext-enable xdebug redis; \
        # Install PDO extension
        docker-php-ext-install pdo pdo_mysql

# Install, enable and configure Xdebug
RUN { \
	echo 'xdebug.mode=develop,coverage,debug'; \
	echo 'xdebug.discover_client_host=true'; \
	echo 'xdebug.start_with_request=yes'; \
	echo 'xdebug.client_port=${PHP_XDEBUG_CLIENT_PORT}'; \
    echo 'xdebug.client_host=${PHP_XDEBUG_CLIENT_HOST}'; \
} > /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /app
