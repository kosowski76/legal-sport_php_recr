#!/bin/sh

APP_USER_NAME=$1
APP_GROUP_NAME=$2
APP_USER_ID=$3
APP_GROUP_ID=$4

addgroup --gid $APP_GROUP_ID $APP_GROUP_NAME
adduser --shell /bin/bash --uid ${APP_USER_ID} --ingroup ${APP_GROUP_NAME} ${APP_USER_NAME}
