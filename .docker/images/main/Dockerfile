ARG COMPOSER_VERSION
ARG SYSTEM_VERSION
FROM composer:${COMPOSER_VERSION} as composer
FROM ${SYSTEM_VERSION} as base

# make build args available as ENV variables to downstream images
# so that we don't have to pass the same build args again
ARG ENV
ARG APP_USER_ID
ARG APP_GROUP_ID
ARG APP_USER_NAME
ARG APP_GROUP_NAME
ARG APP_CODE_PATH
ENV ENV=${ENV}
ENV APP_USER_ID=${APP_USER_ID}
ENV APP_GROUP_ID=${APP_GROUP_ID}
ENV APP_USER_NAME=${APP_USER_NAME}
ENV APP_GROUP_NAME=${APP_GROUP_NAME}
ENV APP_CODE_PATH=${APP_CODE_PATH}

COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# set timezone
ARG TZ=UTC
RUN /tmp/scripts/set_timezone.sh ${TZ}

# add users
RUN /tmp/scripts/create_user.sh ${APP_USER_NAME} ${APP_GROUP_NAME} ${APP_USER_ID} ${APP_GROUP_ID} \
    # make bash default shell
    && sed -e 's;/bin/ash$;/bin/bash;g' -i /etc/passwd
COPY ./images/main/.bashrc /home/${APP_USER_NAME}/.bashrc
COPY ./images/main/.bashrc /root/.bashrc

RUN /tmp/scripts/install_software.sh

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR $APP_CODE_PATH

FROM base as local

# add app user to sudoers
RUN echo "root ALL=(ALL) NOPASSWD: ALL " | tee -a "/etc/sudoers.d/users" && \
    echo "${APP_USER_NAME} ALL=(ALL) NOPASSWD: ALL " | tee -a "/etc/sudoers.d/users"

RUN apt update && apt install -yqq \
    default-mysql-client \
    redis \
;
RUN apt clean && apt autoclean && apt autoremove \
    && apt purge -y --autoremove \
;

RUN /tmp/scripts/cleanup.sh
