ARG MAIN_IMAGE
FROM ${MAIN_IMAGE} as base

# make build args available as ENV variables to downstream images
# so that we don't have to pass the same build args again
ARG ENV
ARG APP_CODE_PATH
ARG TARGET_PHP_VERSION
ENV ENV=${ENV}
ENV APP_CODE_PATH=${APP_CODE_PATH}
ENV TARGET_PHP_VERSION=${TARGET_PHP_VERSION}

# install PHP
# Note: we need to use a custom apk repository because the official ones will
#       likely not include the latest PHP version.
RUN apt update -y && apt install -yqq lsb-release ca-certificates apt-transport-https software-properties-common gnupg2

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/sury-php.list

RUN wget -qO - https://packages.sury.org/php/apt.gpg | sudo apt-key add - \
    && apt update -y

RUN apt update && apt install -yqq \
    php${TARGET_PHP_VERSION} \
#    php${TARGET_PHP_VERSION}-bcmath \
    php${TARGET_PHP_VERSION}-cli php${TARGET_PHP_VERSION}-common php${TARGET_PHP_VERSION}-curl \
    php${TARGET_PHP_VERSION}-dom \
#    php${TARGET_PHP_VERSION}-fpm \
#    php${TARGET_PHP_VERSION}-gd \
    php${TARGET_PHP_VERSION}-http \
#    php${TARGET_PHP_VERSION}-intl \
#    php${TARGET_PHP_VERSION}-json \
    php${TARGET_PHP_VERSION}-mbstring php${TARGET_PHP_VERSION}-mysql php${TARGET_PHP_VERSION}-mysqli \
#    php${TARGET_PHP_VERSION}-opcache \
    php${TARGET_PHP_VERSION}-pdo php${TARGET_PHP_VERSION}-phar php${TARGET_PHP_VERSION}-pcov \
    php${TARGET_PHP_VERSION}-raphf php${TARGET_PHP_VERSION}-redis \
    php${TARGET_PHP_VERSION}-xdebug php${TARGET_PHP_VERSION}-xml \
#    && apt clean \
#    && ln -s /usr/bin/php${TARGET_PHP_VERSION} /usr/bin/php
    && apt install -yqq redis

COPY ./images/php/base/conf.d/zz-app.ini /etc/php/${TARGET_PHP_VERSION}/conf.d/
#COPY ./images/php/base/conf.d/zz-app.ini /etc/php/${TARGET_PHP_VERSION}/mods-available/
COPY ./images/php/base/conf.d/zz-app-${ENV}.ini /etc/php/${TARGET_PHP_VERSION}/conf.d/
#COPY ./images/php/base/conf.d/zz-app-${ENV}.ini /etc/php/${TARGET_PHP_VERSION}/mods-available/

RUN sed -i 's/.*zend_extension=opcache.so/;zend_extension=opcache.so/' '/etc/php/8.2/mods-available/opcache.ini'
#RUN sed -i 's/.*zend_extension=xdebug.so/zend_extension=xdebug.so/' '/etc/php/8.2/mods-available/xdebug.ini'

WORKDIR $APP_CODE_PATH

FROM base as local

#RUN /tmp/scripts/cleanup.sh