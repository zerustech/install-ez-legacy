#!/bin/bash 

prefix=install-ez-legacy
SCRIPT_PATH=`dirname "$0"`
SCRIPT_PATH=`( cd "$SCRIPT_PATH" && pwd )`

cd "$SCRIPT_PATH/../.."

echo `pwd`

patch -p1 < $prefix/patches/composer-composer.json.1.patch
patch -p1 < $prefix/patches/config-config.yml.2.patch
patch -p1 < $prefix/patches/config-routing.yml.2.patch
patch -p1 < $prefix/patches/config-security.yml.1.patch
patch -p1 < $prefix/patches/config-ezpublish.yml.1.patch
patch -p1 < $prefix/patches/ez-EzPublishKernel.php.2.patch
patch -p1 < $prefix/patches/ez-legacy-global_functions.php.1.patch
patch -p1 < $prefix/patches/legacy-bridge-kernel-loader.php.1.patch
patch -p1 < $prefix/patches/legacy-bridge-previewcontroller.php.1.patch
patch -p1 < $prefix/patches/legacy-bridge-twigcontentviewlayoutdecorator.php.1.patch
patch -p1 < $prefix/patches/demo-menuhelper.php.1.patch
patch -p1 < $prefix/patches/composer-installed.json.1.patch
patch -p1 < $prefix/patches/nginx-ez-rewrite-params.1.patch

cd $SCRIPT_PATH
