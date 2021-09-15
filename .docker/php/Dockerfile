# Desired target PHP version, See https://hub.docker.com/_/php for more
ARG PHP_VERSION=7.4

# The application name like f.i. "MySample"
ARG APPLICATION_NAME=""

# Install opcache or not
ARG INSTALL_OPCACHE=false
ARG OPCACHE_MEMORY_CONSUMPTION=256

# Optional, name and ID of the user used inside this container
# 1000 is the userid in the host when coding under linux (Ubuntu/Debian)
# (you can retrieve it by running `echo $UID` in a prompt)
# ==> reusing the same ID will allow to avoid error "You don't have access to this file"
# since the owner in the host will be the owner in the container (even if the name is different)
ARG OS_USERNAME=christophe
ARG OS_USERID=1000

# We'll use the FPM version; i.e. without Apache
# We'll create a separate Docker service for Apache or nginx
FROM php:${PHP_VERSION}-fpm

# Install opcache = start ==============================
ARG INSTALL_OPCACHE
ARG OPCACHE_MEMORY_CONSUMPTION

# Use arguments to create environment variables that will then
# be used in the opcache.ini file
ENV OPCACHE_MEMORY_CONSUMPTION="${OPCACHE_MEMORY_CONSUMPTION}"

RUN echo 'Install OP cache? ${INSTALL_OPCACHE}'; \
    if [ "$INSTALL_OPCACHE" = "true" ]; then \
    docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache; \
    fi

# Copy opcache configuration (even if the module isn't installed)
COPY ./.docker/php/conf.d/opcache.ini $PHP_INI_DIR/conf.d/
# Install opcache = end ==============================

# Create a new user on Linux
ARG OS_USERNAME
ARG OS_USERID
RUN useradd -G www-data,root -u ${OS_USERID} -d /home/${OS_USERNAME} ${OS_USERNAME}
RUN mkdir -p /home/${OS_USERNAME}/.composer; \
    chown -R ${OS_USERNAME}:${OS_USERNAME} /home/${OS_USERNAME}; \
    chown -R ${OS_USERNAME}:${OS_USERNAME} /var/www

# Switch from root to our Linux user. Note that from now, permissions are more restrictive.
# We can put this line in comment and run everything as root but it's a bad idea since the idea
# under Docker is to be as close as possible to the test / production server
# USER ${OS_USERNAME}

# --------------------------------------------------------
#! As from here, the Linux user is ours, no more root:root
# --------------------------------------------------------

# Set the bash prompt; display the name of the container and the current username in the prompt
ARG APPLICATION_NAME
RUN /bin/bash -c "echo \"PS1='\e[0;33mDOCKER - ${APPLICATION_NAME}\e[0m - \e[0;36m$(whoami)\e[0m \w #  '\" >> ~/.bashrc "

WORKDIR /var/www/html

# Copy files from the host to Docker - start #########################
COPY --chown=${OS_USERNAME}:${OS_USERNAME} src /var/www/html
# Copy files from the host to Docker - end ###########################
