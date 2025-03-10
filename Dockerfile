FROM jenkins/jenkins:lts

USER root

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    lsb-release \
    ca-certificates \
    curl \
    gnupg \
    git \
    unzip \
    default-mysql-client

# Ajouter le dépôt PHP et installer PHP 8.2
RUN curl -sSLo /usr/share/keyrings/deb.sury.org-php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/deb.sury.org-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update \
    && apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-common \
    php8.2-curl \
    php8.2-mbstring \
    php8.2-mysql \
    php8.2-xml \
    php8.2-zip \
    php8.2-gd

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Revenir à l'utilisateur jenkins
USER jenkins
