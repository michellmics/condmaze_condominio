FROM php:8.0-apache

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos do repositório para a pasta do Apache
COPY . /app/

# Define permissões corretas
RUN chown -R www-data:www-data /app && \
    chmod -R 755 /app

# Habilita módulos do Apache
RUN a2enmod rewrite

# Configura o Apache para servir a pasta /app
RUN echo "DocumentRoot /app" > /etc/apache2/sites-available/000-default.conf && \
    echo "<Directory /app>" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf && \
    echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Expõe a porta 80
EXPOSE 80

CMD ["apache2-foreground"]
