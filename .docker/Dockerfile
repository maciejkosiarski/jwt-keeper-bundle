FROM php:7.4.0-fpm

ARG DEV_USER_UID=1000

RUN apt-get update && apt-get install -y zsh vim figlet git nano && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar && \
    cp phpcs.phar /usr/local/bin/phpcs && \
    chmod +x /usr/local/bin/phpcs && \
    curl -OL https://cs.symfony.com/download/php-cs-fixer-v2.phar && \
    cp php-cs-fixer-v2.phar /usr/local/bin/phpcsfixer && \
    chmod +x /usr/local/bin/phpcsfixer && \
    curl -OL https://github.com/phpmd/phpmd/releases/download/2.7.0/phpmd.phar && \
    cp phpmd.phar /usr/local/bin/phpmd && \
    chmod +x /usr/local/bin/phpmd && \
    curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar && \
    cp phpcbf.phar /usr/local/bin/phpcbf && \
    chmod +x /usr/local/bin/phpcbf && \
    phpcs --config-set default_standard PSR2 && \
    phpcs --config-set report_format summary && \
    phpcs --config-set show_progress 1 && \
    phpcs --config-set colors 1 && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    rm -rf /var/lib/apt/lists/* && \
    pecl clear-cache && \
    pecl config-set php_ini /usr/local/etc/php/conf.d/over.ini

RUN useradd -m -s /bin/bash developer

RUN echo "su - developer" > /root/.bashrc
#USER developer
#RUN bash -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)" "" --unattended
#RUN curl -o ~/.zshrc https://raw.githubusercontent.com/adrianmalec/my-elementary-os/master/universal-zshrc

WORKDIR "/application"
