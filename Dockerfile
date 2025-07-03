FROM debian:stretch-slim

# Evita prompts interativos
ENV DEBIAN_FRONTEND=noninteractive

# Instala Apache e dependências básicas
RUN apt-get update && \
    apt-get install -y \
        apache2 \
        wget \
        unzip \
        ca-certificates \
        libapache2-mod-php5 \
        php5 \
        php5-mysql && \
    apt-get clean

# Ativa o mod_rewrite
RUN a2enmod rewrite

# Define diretório de trabalho
WORKDIR /var/www/html

# Permite .htaccess e reescrita
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Inicia Apache em foreground
CMD ["apachectl", "-D", "FOREGROUND"]
