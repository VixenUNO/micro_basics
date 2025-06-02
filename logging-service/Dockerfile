FROM php:8.1-cli

COPY index.php /var/www/html/index.php
WORKDIR /var/www/html

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "index.php"]
