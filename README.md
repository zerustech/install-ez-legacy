# How to Install eZ Publish Legacy Admin Interface
The eZ Publish Platform is great except that its new admin UI is under heavy
development and not ready for a production environment, so the legacy admin
interface is still the only solution for back end.

This document is a guildeline for installing eZ Publish legacy admin interface
on top of the eZ Publish Platform.

## Background
At the time of documentation, the latest eZ Publish community release is [eZ
Platform 2.1][1] and this guideline is based on that version. If, however, the
issues still exist in future releases, we will create separate branches for each
of them.

The maintenance of this repository will be terminated if the issues are fixed in
the future or if the new admin UI has become good enough to replace the legacy
admin interface.

## Prerequisite
* PHP
* MySQL
* Nginx - configuration for apache is not covered in this document.
* Composer - composer has been installed globally and can be accessed as
  `composer`

## Terms for Future References
* `<ez>` - refers to the root directory (the directory that holds the `web`
  directory) of eZ Publish Platform

## Installation
Follow the instructions below to complete the installation.

::: info-box note

In this document, eZ Publish will be configured to run in __dev__ mode. This
guideline is based on actual installation process on Mac OS X, but it should
also work for Linux.

:::

### Install ``ezsystems/ezplatform``
```bash
$ export SYMFONY_ENV="dev"
$ composer create-project ezsystems/ezplatform ezdemo ^2
$ 
$ # Provide inputs as follows:
$ Some parameters are missing. Please provide them.
$ env(SYMFONY_SECRET) (ThisEzPlatformTokenIsNotSoSecretChangeIt): <your-token>
$ env(DATABASE_DRIVER) (pdo_mysql):
$ env(DATABASE_HOST) (localhost): 127.0.0.1
$ env(DATABASE_PORT) (null):
$ env(DATABASE_NAME) (ezplatform): ezdemo
$ env(DATABASE_USER) (root): 
$ env(DATABASE_PASSWORD) (null): 
$
$ cd ezdemo
$ php bin/console doctrine:database:drop --force
$ php bin/console doctrine:database:create
$ php bin/console ezplatform:install clean
```

### Install ``ezsystems/legacy-bridge``
Edit ``composer.json``:
```diff
@@ -64,6 +64,12 @@
         "symfony/phpunit-bridge": "~3.2"
     },
     "scripts": {
+        "legacy-scripts": [
+            "eZ\\Bundle\\EzPublishLegacyBundle\\Composer\\ScriptHandler::installAssets",
+            "eZ\\Bundle\\EzPublishLegacyBundle\\Composer\\ScriptHandler::installLegacyBundlesExtensions",
+            "eZ\\Bundle\\EzPublishLegacyBundle\\Composer\\ScriptHandler::generateAutoloads",
+            "eZ\\Bundle\\EzPublishLegacyBundle\\Composer\\ScriptHandler::symlinkLegacyFiles"
+        ],
         "symfony-scripts": [
             "Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
             "eZ\\Bundle\\EzPublishCoreBundle\\Composer\\ScriptHandler::clearCache",
```

Edit ``app/AppKernel.php``:
```diff
@@ -42,8 +42,10 @@ class AppKernel extends Kernel
             new EzSystems\EzPlatformAdminUiBundle\EzPlatformAdminUiBundle(),
             new EzSystems\EzPlatformAdminUiModulesBundle\EzPlatformAdminUiModulesBundle(),
             new EzSystems\EzPlatformAdminUiAssetsBundle\EzPlatformAdminUiAssetsBundle(),
+            new EzSystems\EzPlatformXmlTextFieldTypeBundle\EzSystemsEzPlatformXmlTextFieldTypeBundle(),
             // Application
             new AppBundle\AppBundle(),
+            new eZ\Bundle\EzPublishLegacyBundle\EzPublishLegacyBundle($this),
         ];
 
         switch ($this->getEnvironment()) {
```

Edit ``app/config/routing.yml``:
```diff
@@ -38,3 +38,8 @@ platform1_admin_route:
     defaults:
         path: /admin
         permanent: true
+
+# NOTE: Always keep at the end of the file so native symfony routes always have precendence, to avoid legacy
+# REST pattern overriding possible eZ Platform REST routes.
+_ezpublishLegacyRoutes:
+    resource: '@EzPublishLegacyBundle/Resources/config/routing.yml'
```

Edit ``app/config/security.yml``:
```diff
@@ -35,3 +35,7 @@ security:
 
             # https://symfony.com/doc/current/security/form_login_setup.html
             #form_login: ~
+
+        ezpublish_setup:
+            pattern: ^/ezsetup
+            security: false
```

Install ``ezsystems/legacy-bridge``:
```bash
$ composer require "ezsystems/legacy-bridge:^2.0"
```

Create ``ez_params.d/ez_legacy_rewrite_params`` nginx configuration file:
```nginx
# If using cluster, uncomment the following two lines:
#rewrite "^/var/([^/]+/)?storage/images(-versioned)?/(.*)" "/app.php" break;
#rewrite "^/var/([^/]+/)?cache/(texttoimage|public)/(.*)" "/index_cluster.php" break;

rewrite "^/var/([^/]+/)?storage/images(-versioned)?/(.*)" "/var/$1storage/images$2/$3" break;
rewrite "^/var/([^/]+/)?cache/(texttoimage|public)/(.*)" "/var/$1cache/$2/$3" break;
rewrite "^/design/([^/]+)/(stylesheets|images|javascript|fonts)/(.*)" "/design/$1/$2/$3" break;
rewrite "^/share/icons/(.*)" "/share/icons/$1" break;
rewrite "^/extension/([^/]+)/design/([^/]+)/(stylesheets|flash|images|lib|javascripts?)/(.*)" "/extension/$1/design/$2/$3/$4" break;
rewrite "^/packages/styles/(.+)/(stylesheets|images|javascript)/([^/]+)/(.*)" "/packages/styles/$1/$2/$3/$4" break;
rewrite "^/packages/styles/(.+)/thumbnail/(.*)" "/packages/styles/$1/thumbnail/$2" break;
rewrite "^/var/storage/packages/(.*)" "/var/storage/packages/$1" break;
```

Edit ``/etc/hosts``:
```hosts
127.0.0.1 ezdemo.localhost
```

Create ``ezdemo.localhost.conf`` nginx configuration file:
```nginx
#ezdemo.localhost.conf

server {

    listen       8080;

    server_name  ezdemo.localhost;

    root <ez>/web;

    #Uncomment this line in prod mode. 
    #include ez_params.d/ez_prod_rewrite_params;

    include ez_params.d/ez_legacy_rewrite_params;

    include ez_params.new.d/ez_rewrite_params;

    client_max_body_size 48m;

    location / {

        location ~ ^/app\.php(/|$) {

            include ez_params.d/ez_fastcgi_params;

            fastcgi_pass 127.0.0.1:9002;

            fastcgi_read_timeout 90s;

            fastcgi_param SYMFONY_ENV dev;
        }
    }

    include ez_params.new.d/ez_server_params;
}
```

Create asset symblic links for eZ Publish legacy:
```bash
$ php bin/console ezpublish:legacy:assets_install --symlink --relative --force
```

Generate autoloads for eZ Publish legacy:
```bash
$ cd ezpublish_legacy
$ php bin/php/ezpgenerateautoloads.php -e
```
Set up directory permissions:
```bash
$ rm -rf var/cache/* var/logs/* var/sessions/*
$ HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
$ sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var web/var
$ sudo chmod +a "$(whoami) allow delete,write,append,file_inherit,directory_inherit" var web/var
```

### Install eZ Publish Legacy
Restart nginx, access ``http://ezdemo.localhost:8080/ezsetup`` to install eZ
Publish legacy with the following settings:
* Language: eng-US
* Site Package: eZ Publish Demo Site (without demo content)
* Access Method: URL (recommended)
* User Path: ``ezdemo_site``
* Admin Path: ``ezdemo_site_admin``
* Database: ``ezdemo``
* Database Action: Remove existing data

::: info-box note

It is safe to ignore the "unexpected error" at the last step.

:::

### Re-configure Siteaccesses
Edit ``app/config/ezplatform.yml``:
```diff
@@ -1,3 +1,7 @@
+ez_publish_legacy:
+    system:
+        ezdemo_site_admin:
+            legacy_mode: true
 ezpublish:
     # HttpCache settings, By default 'local' (Symfony HttpCache Proxy), by setting it to 'http' you can point it to Varnish
     http_cache:
@@ -13,15 +17,15 @@ ezpublish:
 
     # Siteaccess configuration, with one siteaccess per default
     siteaccess:
-        list: [site, admin]
+        list: [ezdemo_site, ezdemo_site_admin, admin]
         groups:
-            site_group: [site]
+            site_group: [ezdemo_site]
 
             # WARNING: Do not remove or rename this group.
             # It's used to distinguish common siteaccesses from admin ones.
             # In case of multisite with multiple admin panels, remember to add any additional admin siteaccess to this group.
             admin_group: [admin]
-        default_siteaccess: site
+        default_siteaccess: ezdemo_site
         match:
             URIElement: 1
 
@@ -33,11 +37,11 @@ ezpublish:
             # These reflect the current installers, complete installation before you change them. For changing var_dir
             # it is recommended to install clean, then change setting before you start adding binary content, otherwise you'll
             # need to manually modify your database data to reflect this to avoid exceptions.
-            var_dir: var/site
+            var_dir: var/ezdemo_site
             # System languages. Note that by default, content, content types, and other data are in eng-GB locale,
             # so removing eng-GB from this list may lead to errors or content not being shown, unless you change
             # all eng-GB data to other locales first.
-            languages: [eng-GB]
+            languages: [eng-US]
             content:
                 # As we by default enable EzSystemsPlatformHttpCacheBundle which is designed to expire all affected cache
                 # on changes, and as error / redirects now have separate ttl, we easier allow ttl to be greatly increased
@@ -49,8 +53,8 @@ ezpublish:
         # WARNING: Do not remove or rename this group.
         admin_group:
             cache_service_name: '%cache_pool%'
-            var_dir: var/site
-            languages: [eng-GB]
+            var_dir: var/ezdemo_site
+            languages: [eng-US]
             content:
                 default_ttl: '%httpcache_default_ttl%'
             http_cache:
```

### Test

Restart nginx and test the website at the following URLs:
* http://ezdemo.localhost:8080 - the front end
* http://ezdemo.localhost:8080/admin - the new admin UI
* http://ezdemo.localhost:8080/ezdemo_site_admin - the legacy admin interface

### References

* [Download eZ Platform 2.1][1]
* [Set up directory permissions][2]
* [Github of ezsystems/ezplatform][3]
* [Github of ezsystems/ezplatform-demo][4]
* [eZ Platform][5]
* [Installing ezsystems/legacy-bridge][6]


[1]: https://ezplatform.com/#download-option "Download eZ Platform 2.1"
[2]: https://doc.ezplatform.com/en/latest/getting_started/set_up_directory_permissions/ "Set up directory permissions"
[3]: https://github.com/ezsystems/ezplatform "ezsystems/ezplatform github"
[4]: https://github.com/ezsystems/ezplatform-demo "ezsystems/ezplatform-demo github"
[5]: http://ezplatform.com "eZ Platform"
[6]: https://github.com/ezsystems/LegacyBridge/blob/master/INSTALL.md "Installing the eZ Platform legacy bridge"
