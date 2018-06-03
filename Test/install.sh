#!/usr/bin/env bash

BUILD_DIR="/tmp/magento2"
MODULE_DIR="${BUILD_DIR}/app/code/Davay/CarrierTemplates"

echo "Install Magento ${MAGENTO_VERSION}"
composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition:$MAGENTO_VERSION $BUILD_DIR

# move module into magento installation
mkdir -p $MODULE_DIR
mv ./* $MODULE_DIR

# travis has empty password
mv $BUILD_DIR/dev/tests/integration/etc/install-config-mysql.travis.php.dist \
   $BUILD_DIR/dev/tests/integration/etc/install-config-mysql.php

composer --working-dir=${BUILD_DIR} install --ignore-platform-reqs --prefer-dist
mysql -uroot -e 'CREATE DATABASE magento_integration_tests;'
