ARG BASE_IMAGE
FROM ${BASE_IMAGE} as base

RUN echo ${TARGET_PHP_VERSION}

RUN apt update && apt install -yqq \
    php${TARGET_PHP_VERSION}-fpm \
    && ln -s /usr/sbin/php-fpm${TARGET_PHP_VERSION} /usr/bin/php-fpm

COPY ./images/php/fpm/php-fpm.d/www.conf /etc/php/${TARGET_PHP_VERSION}/fpm/pool.d/
COPY ./images/php/fpm/conf.d/${ENV}/* /etc/php/${TARGET_PHP_VERSION}/fpm/conf.d/
COPY ./images/php/fpm/conf.d/zz-app-fpm.ini /etc/php/${TARGET_PHP_VERSION}/fpm/conf.d/

RUN sed -i "s/__APP_USER_NAME/$APP_USER_NAME/" /etc/php/${TARGET_PHP_VERSION}/fpm/pool.d/* \
    && sed -i "s/__APP_GROUP_NAME/$APP_GROUP_NAME/" /etc/php/${TARGET_PHP_VERSION}/fpm/pool.d/*

RUN sed -i 's/.*zend_extension=xdebug.so/zend_extension=xdebug.so/' '/etc/php/8.2/mods-available/xdebug.ini'

RUN apt clean && apt autoclean && apt autoremove \
    && apt purge -y --autoremove \
;

RUN /etc/init.d/php${TARGET_PHP_VERSION}-fpm start -F

#USER $APP_USER_NAME

EXPOSE 9000 9003

CMD ["/usr/bin/php-fpm", "-F"]

FROM base as local
