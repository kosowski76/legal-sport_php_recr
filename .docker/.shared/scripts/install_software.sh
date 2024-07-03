#!/bin/sh

apt update -yqq && apt install -yqq \
    bash \
    curl \
    git \
    iputils-ping \
    lsof \
    ltrace \
    make \
    nano \
    strace \
    sudo \
    wget \
;
