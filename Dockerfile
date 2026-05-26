FROM yiisoftware/yii2-php:8.1-apache

RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app

USER www-data