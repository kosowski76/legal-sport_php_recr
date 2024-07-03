ARG BASE_IMAGE
FROM ${BASE_IMAGE} as base

FROM base as local

RUN sed -i 's/.*zend_extension=xdebug.so/zend_extension=xdebug.so/' '/etc/php/8.2/mods-available/xdebug.ini'

#RUN apk add --no-cache --update \
#        openssh
# set up ssh
RUN apt-get update -yqq && apt-get install -yqq openssh-server \
    && mkdir /var/run/sshd \
;

ARG APP_SSH_PASSWORD
RUN echo "$APP_USER_NAME:$APP_SSH_PASSWORD" | chpasswd 2>&1

# Required to start sshd, otherwise the container will error out on startup with the message
# "sshd: no hostkeys available -- exiting."
# @see https://stackoverflow.com/a/65348102/413531
#RUN ssh-keygen -A

RUN apt clean && apt autoclean && apt autoremove \
    && apt purge -y --autoremove \
;

# we use SSH deployment configuration in PhpStorm for local development
EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]