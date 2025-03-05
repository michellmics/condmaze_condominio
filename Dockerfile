# Usando a imagem oficial do PHP com Apache
FROM php:8.0-apache

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Instala pacotes necessários (vim, cron, curl)
RUN apt-get update && apt-get install -y vim cron curl

# Copia os arquivos do repositório para a pasta do Apache
COPY . /var/www/html/

# Define permissões corretas para o Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Copia e ativa a crontab
COPY crontab.txt /var/spool/cron/crontabs/root
RUN chmod 600 /var/spool/cron/crontabs/root && crontab /var/spool/cron/crontabs/root

# Instala sockets para o email funcionar
RUN docker-php-ext-install sockets

# Habilita o módulo de reescrita do Apache
RUN a2enmod rewrite

# Adicionando configurações diretamente no php.ini
RUN echo "upload_max_filesize = 10M" >> /usr/local/etc/php/php.ini && \
    echo "post_max_size = 10M" >> /usr/local/etc/php/php.ini

# Configura o Apache para servir a pasta /var/www/html
RUN echo "DocumentRoot /var/www/html" > /etc/apache2/sites-available/000-default.conf && \
    echo "<Directory /var/www/html>" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf && \
    echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Expõe a porta 80
EXPOSE 80

# Inicia o cron e o Apache no foreground
CMD cron && apache2-foreground
