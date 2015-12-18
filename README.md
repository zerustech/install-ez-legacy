How to Install eZ Publish Legacy Admin Interface
================================================
The eZ Publish Platform is great except that its new admin UI is under heavy development and not ready for a production environment, so the legacy admin interface is still the only solution for back end.

This document is a guildeline for installing eZ Publish legacy admin interface on top of the eZ Publish Platform.

Background
----------
At the time of documentation, the latest eZ Publish community release is [eZ Platform 2015.11][2] and this guideline is based on that version. If, however, the issues still exist in future releases, we will create separate branches for each of them.

The maintenance of this repository will be terminated if the issues are fixed in the future or if the new admin UI has become good enough to replace the legacy admin interface.

This repository contains the following files:
* `README.md` - the step by step guildeline for installing the admin interface.
* `patches/*` - the patch files that fixed the issues in the code base.
* `scripts/*` - installation scripts.

Prerequisite
------------
* PHP
* MySQL
* Nginx - configuration for apache is not covered in this document.
* Composer - composer has been installed globally and can be accessed as `composer`

Terms for Future References
---------------------------
* `<ez>` - refers to the root directory (the directory that holds the `web` directory) of eZ Publish Platform
* `<download>` - refers to the directory where eZ Publish Platform tarball is downloaded
* `<owner>` - refers to your username.
* `<web-user>` - refers to `php-fpm` or `apache` user.
* `<web-group>` - refers to the `php-fpm` or `apache` user group.

Installation
------------
Follow the instructions below to complete the installation.

::: info-box note

In this document, eZ Publish will be configured to run in __dev__ mode. This guideline is based on actual installation process on Mac OS X, but it should also work for Linux.

:::

### Download eZ Publish Platform

The first step is to download the eZ Publish platform tarball from [share.ez.no][3] and assume the file name of the downloaded tarball is `ezplatform-dist-yyyy.mm.n.tar.bz2`

::: info-box tip

You can also download the eZ Publish Platform via composer, which has the same effect as downloading the tarball, so this guideline should also work for you.

:::

### Extract the Tarball

```bash
$ cd <ez>
$ tar jxf <download>/ezplatform-dist-yyyy.mm.n.tar.bz2 --strip-components=1
```

### Clone this Repository
```bash
$ cd <ez>
$ git clone https://github.com/zerustech/install-ez-legacy.git install-ez-legacy
$ cd install-ez-legacy
# Checkout the branch corresponding to the version of the eZ Publish platform you
# downloaded
# For example:
# git checkout -b 2015.11 origin/2015.11
```

### Create Database
```bash
$ mysql -uroot -e 'drop database if exists ezdemo'
$ mysql -uroot -e 'create database ezdemo character set utf8mb4 collate utf8mb4_general_ci'
```
::: info-box note

If you want to change the database name, replace `ezdemo` with the new name in the commands above.

You might also need change the database name in the following files, which are not created yet:

* `<ez>/ezpublish/config/parameters.yml`
* `<ez>/ezpublish_legacy/settings/override/site.ini.append.php`

:::

### Download `doctrine/orm`

::: info-box note

For unknown reason, the eZ Publish Platform does not include `doctrine/orm` by default, so it has to be manually installed.

This is optional, so skip this chapter if you don't need it.

:::
```bash
$ cd <ez>
$ composer require doctrine/orm:~2.3 --no-update
$ composer update doctrine/orm --no-dev --no-scripts
```

### Initialize Configurations
```bash
$ cd <ez>
$ composer run-script post-install-cmd
# When being prompted for database name, type the correct database name.
# When being prompted to dump assets, type 'none' to skip.
```
::: info-box note

Make sure to type the correct database name when being prompted.

You can also change the database name in `<ez>/ezpublish/config/parameters.yml`

:::

### Download Demo Bundle
```bash
$ cd <ez>
$ composer require --no-update ezsystems/demobundle:~6.0@beta
$ composer require --no-update ezsystems/comments-bundle:~6.0@beta
$ composer require --no-update ezsystems/demobundle-data:~1.0@beta
$ composer require --no-update ezsystems/privacy-cookie-bundle:~1.0@beta
$ composer update ezsystems/demobundle --no-dev --no-scripts
```

### Configure Demo Bundle
```bash
$ cd <ez>
$ ./install-ez-legacy/scripts/apply-ezdemo-patches.sh
```

### Install Demo Bundle Data
```bash
$ cd <ez>
$ php ezpublish/console ezplatform:install --env dev demo
```

### Download eZ Publish Legacy
```bash
cd <ez>
$ composer require ezsystems/legacy-bridge --no-update
$ composer update ezsystems/legacy-bridge --no-dev --no-scripts

# Note: Because there are some issues in the legacy code base that will break the
# post-install-cmd scripts, we use --no-scripts option to skip
# the post-install-cmd scripts.
# We will fix these issues first, then manually run the post-install-cmd scripts.
```

### Apply Legacy Patches
```bash
$ cd <ez>
$ ./install-ez-legacy/scripts/apply-legacy-patches.sh
```

### Apply eZ Patches
```bash
$ cd <ez>
$ ./install-ez-legacy/scripts/apply-ez-patches.sh
```

### Preserve the Storage
```bash
$ cd <ez>
$ mv web/var/ezdemo_site ezpublish_legacy/var

# This preserves storage of the demo bundle, otherwise, when running the
# post-install-cmd scripts of the eZ Publish legacy package, the web/var
# directory will be purged and the storage will be removed as well.
```

### Create Legacy Setting Files
```bash
$ cd <ez>
$ ./install-ez-legacy/scripts/create-legacy-settings.sh
```
::: info-box note

Make sure to change the database name in:
* `<ez>/ezpublish_legacy/settings/override/site.ini.append.php`

:::

### Change Permissions

Set `WEB_USER` and `WEB_GROUP` in `install-ez-legacy/scripts/set-permission.sh`

::: info-box note

* `OWNER` is your username.
* `WEB_USER` is the username of `apache`, `nginx` and `php-fpm` processes.
* `WEB_USER_GROUP` is the group name of `apache`, `nginx` and `php-fpm` processes.

:::

```bash
#!/bin/bash
OWNER=<owner>
WEB_USER=<web-user>
WEB_USER_GROUP=<web-group>
...
```

```bash
$ cd <ez>
$ sudo ./install-ez-legacy/scripts/set-permissions.sh
```

### Generate Autuloads for Extensions
```bash
$ cd <ez>/ezpublish_legacy
$ sudo -u <web-user> php bin/php/ezpgenerateautoloads.php -e
```

### Post Installation Scripts
```bash
$ cd <ez>
$ sudo -u <web-user> composer run-script post-install-cmd
```

### Enable `symfony/var-dumper`

By default, `Resources/functions/dump.php` in `symfony/var-dumper` component is not included
in `vendor/composer/autoload_files.php`, so when calling `dump()` function the following error occurs:

> Call to undefined function dump() in ...

This file should be included in `composer.json` of `symfony/symfony`, so that when installing `symfony/symfony`,
it will be included in `autoload_files.php`. However, since `symfony/symfony` has been installed, adding it to `composer.json`
won't work.

A workaround for this issue is to include this file in `vendor/composer/installed.json` and run `dump-autoload` 
to regenerate `autoload_files.php`

The `autoload_files.php` has been patched, so use the following commands to enable `symfony/var-dumper`:

```bash
$ cd <ez>
$ composer dump-autoload  
```

### Remove the Installation Scripts

```bash
$ cd <ez>
$ rm -rf install-ez-legacy
```

::: info-box note

Now the eZ Publish legacy admin interface has been installed successfully and the `install-ez-legacy` directory can be removed.

:::

### Hosts Configuration
Add the mapping of domain name and ip address in `/etc/hosts`
```bash
# /etc/hosts
127.0.0.1    ezdemo.localhost
```

### Nginx Configuration
Configure nginx according to `<ez>/doc/nginx/nginx.rst` and use the following virtual host configuration for the website.

```nginx
#ezdemo.localhost.conf

server {

    listen       80;

    server_name  ezdemo.localhost;

    root <ez>/web;

    # Make sure to comment out this line in "dev" mode
    # include ez_params.d/ez_prod_rewrite_params;

    include ez_params.d/ez_rewrite_params;

    client_max_body_size 2m;

    location / {

        location ~ ^/index\.php(/|$) {

            include ez_params.d/ez_fastcgi_params;

            fastcgi_pass 127.0.0.1:9000;

            # Enable "dev" mode
            fastcgi_param ENVIRONMENT dev;

        }

    }

    include ez_params.d/ez_server_params;

}
```

### Test

Restart nginx and test the website at the following URLs:
* http://ezdemo.localhost - the front end
* http://ezdemo.localhost/ez - the new admin UI
* http://ezdemo.localhost/demo_site_admin - the legacy admin interface

::: info-box note

Password for the generated admin user is 'publish', this username and password is needed when you would like to login to back end.

:::

### Patch Files

#### Demo Bundle Patches

* `config-config.yml.1.patch`

::: info-box note

Add `eZDemoBundle` to assetic bundles.

:::

* `config-routing.yml.1.patch`

::: info-box note

Import routing rules for eZDemoBundle.

:::

* `ez-EzPublishKernel.php.1.patch`

::: info-box note

Register related bundles in kernel.

:::

#### Legacy Patches

* `composer-composer.json.1.patch`

  ::: info-box note 

  Add post-install-cmd scripts of the legacy package to `composer.json`

  :::

* `config-config.yml.2.patch`

  ::: info-box note

  Configure the default doctrine entity manager.

  :::

* `config-config_dev.yml.1.patch`

::: info-box note

Import `ezpublish_dev.yml`

:::

* `config-routing.yml.2.patch`

  ::: info-box note 

  Import routing rules of the legacy package.

  :::

* `config-security.yml.1.patch`

  ::: info-box note

  Allow the run of legacy installation wizard. (optional)

  :::

* `config-ezpublish.yml.1.patch`

  ::: info-box note

  Enable legacy admin interface at `/demo_site_admin`. 
  
  After the patch is applied, manually change the path to `convert` in ezpublish/config/ezpublish.yml

  :::

* `config-ezpublish.yml.2.patch`

  ::: info-box note

  Fix the following issue when previewing contents at the back office:

  > Catchable Fatal Error: Argument 1 passed to eZ\Publish\Core\MVC\Legacy\View\Provider\Content::getView() must be an instance of eZ\Publish\API\Repository\Values\Content\ContentInfo, instance of eZ\Publish\Core\MVC\Symfony\View\ContentView given ...

  :::

* `ez-EzPublishKernel.php.2.patch`

  ::: info-box note

  Enable `EzPublishLegacyBundle` and also fixed issue [#EZP-24109][5], which terminates script `Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache` with an exception: 
  > "You cannot create a service ("request") of an inactive scope ("request")."

  :::

* `ez-legacy-global_functions.php.1.patch`

  ::: info-box note

  Fixed the issue that terminates script `Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache` with an exception:
  > Cannot redeclare eZUpdateDebugSettings()

  :::

* `legacy-bridge-kernel-loader.php.1.patch`

  ::: info-box note

  Fixed the issue that terminates script `Sensio\Bundle\DistributionBundle\Composer\ScriptHandler::installAssets` with an exception:
  > The target directory "web" does not exist.

  :::

* `legacy-bridge-previewcontroller.php.1.patch`

  ::: info-box note

  Fixed the following issue when previewing content in legacy admin interface:
  > Runtime Notice: Declaration of eZ\Bundle\EzPublishLegacyBundle\Controller\PreviewController::getForwardRequest() should be compatible with eZ\Publish\Core\MVC\Symfony\Controller\Content\PreviewController::getForwardRequest(eZ\Publish\API\Repository\Values\Content\Location $location, eZ\Publish\API\Repository\Values\Content\Content $content, eZ\Publish\Core\MVC\Symfony\SiteAccess $previewSiteAccess, Symfony\Component\HttpFoundation\Request $request, $language) 

  :::

* `legacy-bridge-twigcontentviewlayoutdecorator.php.1.patch`

  ::: info-box note

  Fixed the following issue when no pagelayout is available: 

  > Unable to find template "{% extends "EzPublishLegacyBundle::legacy_view_default_pagelayout.html.twig" %}

  :::

* `legacy-bridge-twigcontentviewlayoutdecorator.php.2.patch`

  ::: info-box note

  Fixed the following issue when running post-install-cmd scripts: 

  > Interface 'eZ\Publish\Core\MVC\Symfony\View\ContentViewInterface' not found

  :::

* `demo-menuhelper.php.1.patch`

  ::: info-box note

  Fixed the following issue when the default language is not available: 
  > An exception has been thrown during the rendering of a template ("Some mandatory parameters are missing ("language") to generate a URL for route "_ez_content_view".") in eZDemoBundle:footer:latest_content.html.twig at line 5.

  :::

* `composer-installed.json.1.patch`

  ::: info-box note

  Add `src/Symfony/Component/VarDumper/Resources/functions/dump.php` to `vendor/composer/installed.json`, so that when running `dump-autoload`, `dump.php` will be added to `vendor/composer/autoload_files.php`

  :::

* `nginx-ez-rewrite-params.1.patch`

  ::: info-box note

  The rewrite rules for eZ Publish legacy admin interface has been removed from `eZ Publish Platform 2015.09.1`, the admin interface won't work correctly witout these rules.  This patch restores the missing rewrite rules.

  :::

* `ez-siteaccessmatchlistener.php.1.patch`

  ::: info-box note

  Fixed the following issue when calling `path()` inside an ESI block in twig template:

  >  Notice: Trying to get property of non-object in
     vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/MVC/Symfony/SiteAccess/Router.php on line 223

     Refer to [PR#1547][6] for details.

  :::

[1]: https://doc.ez.no/display/EZP/Installing+eZ+Publish+Legacy+on+top+of+eZ+Platform "Install eZ Publish Legacy on Top of eZ Platform"

[2]: http://share.ez.no/downloads/downloads/ez-platform-15.11 "eZ Platform 15.11"

[3]: http://share.ez.no/downloads "Download eZ Publish Platform"

[4]: http://ezdemo.localhost "Front End of the Demo Site"

[5]: https://jira.ez.no/browse/EZP-24109 "Inactive Scope Issue"

[6]: https://github.com/ezsystems/ezpublish-kernel/pull/1547 "PR #1547"
