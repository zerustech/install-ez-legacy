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
$ composer update
$
$ cd ezdemo
$ php bin/console doctrine:database:drop --force
$ php bin/console doctrine:database:create
$ php bin/console ezplatform:install clean
```

### Install ``ezsystems/legacy-bridge``
Edit ``composer.json``:
```diff
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

Create nginx configuration files:
```bash
$ cd <nginx-etc-directory>
$ sudo cp -rf <ez>/doc/nginx/ez_params.d .
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
127.0.0.1 admin.ezdemo.localhost
```

Create ``ezdemo.localhost.conf`` nginx configuration file:
```nginx
#ezdemo.localhost.conf

server {

    listen       8080;

    server_name  ezdemo.localhost *.ezdemo.localhost;

    root <ez>/web;

    #Uncomment this line in prod mode.
    #include ez_params.d/ez_prod_rewrite_params;

    include ez_params.d/ez_legacy_rewrite_params;

    client_max_body_size 512m;

    location / {

        location ~ ^/app\.php(/|$) {

            include ez_params.d/ez_fastcgi_params;

            # Change the php-fpm port number according to your environment.
            fastcgi_pass 127.0.0.1:9002;

            fastcgi_read_timeout 300s;

            fastcgi_param SYMFONY_ENV dev;
        }
    }

    include ez_params.d/ez_server_params;
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
$ rm -rf var/site/cache/* var/default/cache/* var/ezdemo_site/cache/*
$ HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
$ sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var web/var
$ sudo chmod +a "$(whoami) allow delete,write,append,file_inherit,directory_inherit" var web/var
```

::: info-box note :::
Make sure to remove all cache directories before installing eZ Publish
legacy, otherwise the primary language you have selected may get a wrong id if
there is a previous installation.
:::

```php
// Line 656 at <ez>/ezpublish_legacy/kernel/setup/steps/ezstep_create_sites.php:
// Function fetchByLocale(...) will try to load the language object from cache,
// so if there is a previous installation that has assigned, for example, 4 as
// the id to language 'eng-GB', then it will be used as the id, which is
// supposed to be 2, of the primary language (e.g., chi-CN).
            $engLanguageObj = eZContentLanguage::fetchByLocale( 'eng-GB' );
            $engLanguageID = (int)$engLanguageObj->attribute( 'id' );
            $updateSql = "UPDATE ezcontent_language
SET
locale='$primaryLanguageLocaleCode',
name='$primaryLanguageName'
WHERE
id=$engLanguageID";
```

### Install eZ Publish Legacy
Restart nginx, access ``http://ezdemo.localhost:8080/ezsetup`` to install eZ
Publish legacy with the following settings:
* Languages: ``chi-CN`` (main), ``eng-US`` (additional)
* Language Map: map ``eng-GB`` to ``chi-CN``
* Site Package: eZ Publish Demo Site (without demo content)
* Access Method: URL (recommended)
* User Path: ``ezdemo_site``
* Admin Path: ``chi_admin``
* Database: ``ezdemo``
* Database Action: Remove existing data

::: info-box note

It is safe to ignore the "unexpected error" at the last step.

:::

### Config eZ Publish legacy

The eZ Publish Installation wizard should have created site accesses
``ezdemo_site``, ``chi``, ``eng``, and ``chi_admin``.

Edit ``<ez>/ezpublish_legacy/settings/override/site.ini.append.php``:
```diff
 [SiteSettings]
 DefaultAccess=chi
 SiteList[]
-SiteList[]=ezdemo_site
 SiteList[]=chi
 SiteList[]=eng
 SiteList[]=chi_admin
 ...
 [SiteAccessSettings]
 CheckValidity=false
 AvailableSiteAccessList[]
-AvailableSiteAccessList[]=ezdemo_site
 AvailableSiteAccessList[]=chi
 AvailableSiteAccessList[]=eng
 AvailableSiteAccessList[]=chi_admin
 ...
 TranslationSA[eng]=Eng

 [FileSettings]
-VarDir=var/ezdemo_site
+VarDir=var/default

 [MailSettings]
 Transport=sendmail
@@ -63,4 +61,4 @@ AvailableViewModes[]=embed
 AvailableViewModes[]=embed-inline
 InlineViewModes[]
 InlineViewModes[]=embed-inline

```

Edit ``<ez>/ezpublish_legacy/settings/siteaccess/chi/site.ini.append.php``:
```diff
 [SiteAccessSettings]
 RequireUserLogin=false
 RelatedSiteAccessList[]
-RelatedSiteAccessList[]=ezdemo_site
 RelatedSiteAccessList[]=chi
 RelatedSiteAccessList[]=eng
 RelatedSiteAccessList[]=chi_admin
 ...
 TextTranslation=enabled

 [FileSettings]
-VarDir=var/ezdemo_site_clean
+VarDir=var/default
```

Edit ``<ez>/ezpublish_legacy/settings/siteaccess/eng/site.ini.append.php``:
```diff
 [SiteAccessSettings]
 RequireUserLogin=false
 RelatedSiteAccessList[]
-RelatedSiteAccessList[]=ezdemo_site
 RelatedSiteAccessList[]=chi
 RelatedSiteAccessList[]=eng
 RelatedSiteAccessList[]=chi_admin
 ...
 ShowUntranslatedObjects=disabled
 SiteLanguageList[]
 SiteLanguageList[]=eng-US
-SiteLanguageList[]=chi-CN
 TextTranslation=enabled

 [FileSettings]
-VarDir=var/ezdemo_site_clean
+VarDir=var/default
```
Edit ``<ez>/ezpublish_legacy/settings/siteaccess/chi_admin/site.ini.append.php``:
```diff
 [SiteAccessSettings]
 RequireUserLogin=true
-RelatedSiteAccessList[]=ezdemo_site
 RelatedSiteAccessList[]=chi
 RelatedSiteAccessList[]=eng
 RelatedSiteAccessList[]=chi_admin
 ...
 TextTranslation=enabled

 [FileSettings]
-VarDir=var/ezdemo_site_clean
+VarDir=var/default
```

Edit ``<ez>/app/config/ezpublish.yml``:
```diff
 doctrine:
     dbal:
         connections:
-            chi_repository_connection:
+            default_repository_connection:
             ...
             legacy_mode: true
 ezpublish:
     imagemagick:
-        enabled: false
+        enabled: true
+        path: /opt/local/bin/convert
     repositories:
-        chi_repository:
+        default_repository:
             engine: legacy
-            connection: chi_repository_connection
+            connection: default_repository_connection
     siteaccess:
         default_siteaccess: chi
         list:
-            - ezdemo_site
             - chi
             - eng
             - chi_admin
         groups:
-            ezdemo_site_clean_group:
-                - ezdemo_site
+            default_group:
                 - chi
                 - eng
                 - chi_admin
         match:
             URIElement: '1'
     system:
-        ezdemo_site_clean_group:
-            repository: chi_repository
-            var_dir: var/ezdemo_site
+        default_group:
+            repository: default_repository
+            var_dir: var/default
         chi:
             languages:
                 - chi-CN
             ...
             languages:
                 - chi-CN
                 - eng-US
-        ezdemo_site:
-            languages:
-                - chi-CN
-                - eng-US
-            session:
-                name: eZSESSID
         eng:
             languages:
                 - eng-US
-                - chi-CN
             session:
                 name: eZSESSID
```

Map all classes in ``eng-GB`` to ``chi-CN`` with the following SQL:
```sql
update ezcontentclass set initial_language_id = 2;
update ezcontentclass set language_mask = 3;
update ezcontentclass set serialized_description_list = 'a:2:{i:0;s:0:"";s:16:"always-available";b:0;}';

update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:6:"Folder";}' where identifier = 'folder';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:10:"User Group";}' where identifier = 'user_group';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:4:"User";}' where identifier = 'user';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:7:"Comment";}' where identifier = 'comment';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:20:"Comment INI Settings";}' where identifier = 'common_ini_settings';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:13:"Template Look";}' where identifier = 'template_look';

update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:7:"Article";}' where identifier = 'article';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:4:"Blog";}' where identifier = 'blog';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:9:"Blog Post";}' where identifier = 'blog_post';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:14:"Call to Action";}' where identifier = 'call_to_action';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:23:"Call to Action Feedback";}' where identifier = 'call_to_action_feedback';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:7:"Product";}' where identifier = 'product';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:13:"Feedback Form";}' where identifier = 'feedback_form';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:12:"Landing Page";}' where identifier = 'landing_page';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:9:"Wiki Page";}' where identifier = 'wiki_page';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:4:"Poll";}' where identifier = 'poll';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:4:"File";}' where identifier = 'file';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:5:"Image";}' where identifier = 'image';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:4:"Link";}' where identifier = 'link';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:7:"Gallery";}' where identifier = 'gallery';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:5:"Forum";}' where identifier = 'forum';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:11:"Forum Topic";}' where identifier = 'forum_topic';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:11:"Forum Reply";}' where identifier = 'forum_reply';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:5:"Event";}' where identifier = 'event';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:14:"Event Calendar";}' where identifier = 'event_calendar';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:6:"Banner";}' where identifier = 'banner';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:6:"Forums";}' where identifier = 'forums';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:5:"Video";}' where identifier = 'video';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:5:"Place";}' where identifier = 'place';
update ezcontentclass set serialized_name_list = 'a:2:{s:16:"always-available";s:6:"chi-CN";s:6:"chi-CN";s:10:"Place List";}' where identifier = 'place_list';
```

### Re-configure Siteaccesses
Edit ``<ez>/app/config/ezplatform.yml``:
```diff
+ez_publish_legacy:
+    system:
+        chi_admin:
+            legacy_mode: true
 ezpublish:
     # HttpCache settings, By default 'local' (Symfony HttpCache Proxy), by setting it to 'http' you can point it to Varnish
     http_cache:
     ...
     # Siteaccess configuration, with one siteaccess per default
     siteaccess:
-        list: [site, admin]
+        list: [chi, eng, chi_admin, admin]
         groups:
-            site_group: [site]
+            chi_group: [chi]
+            eng_group: [eng]

             # WARNING: Do not remove or rename this group.
             # It's used to distinguish common siteaccesses from admin ones.
             # In case of multisite with multiple admin panels, remember to add any additional admin siteaccess to this group.
             admin_group: [admin]
-        default_siteaccess: site
+        default_siteaccess: chi
         match:
-            URIElement: 1
+            Map\URI:
+                chi: chi
+                eng: eng
+                admin: admin
+            Map\Host:
+                admin.ezdemo.localhost: chi_admin

     # System settings, grouped by siteaccess and/or siteaccess group
     system:
-        site_group:
+        chi_group:
             # Cache pool service, needs to be different per repository (database) on multi repository install.
             cache_service_name: '%cache_pool%'
             # These reflect the current installers, complete installation before you change them. For changing var_dir
             # it is recommended to install clean, then change setting before you start adding binary content, otherwise you'll
             # need to manually modify your database data to reflect this to avoid exceptions.
-            var_dir: var/site
+            var_dir: var/default
             # System languages. Note that by default, content, content types, and other data are in eng-GB locale,
             # so removing eng-GB from this list may lead to errors or content not being shown, unless you change
             # all eng-GB data to other locales first.
-            languages: [eng-GB]
+            languages: [chi-CN]
             content:
                 # As we by default enable EzSystemsPlatformHttpCacheBundle which is designed to expire all affected cache
                 # on changes, and as error / redirects now have separate ttl, we easier allow ttl to be greatly increased
@@ -46,11 +56,20 @@ ezpublish:
             http_cache:
                 purge_servers: ['%purge_server%']

+        eng_group:
+            cache_service_name: '%cache_pool%'
+            var_dir: var/default
+            languages: [eng-US]
+            content:
+                default_ttl: '%httpcache_default_ttl%'
+            http_cache:
+                purge_servers: ['%purge_server%']
+
         # WARNING: Do not remove or rename this group.
         admin_group:
             cache_service_name: '%cache_pool%'
-            var_dir: var/site
-            languages: [eng-GB]
+            var_dir: var/default
+            languages: [chi-CN, eng-GB]
             content:
                 default_ttl: '%httpcache_default_ttl%'
             http_cache:
```

### Change CSRF Form Token Name
Edit ``<ez>/app/config/config.yml``:
```diff
@@ -51,7 +51,15 @@ framework:
         resource: '%kernel.project_dir%/app/config/routing.yml'
         strict_requirements: ~
     csrf_protection: ~
-    form: ~
+    form:
+        csrf_protection:
+            field_name: ezxform_token
+            # This is required by the ezmultiupload extension in the legacy
+            # admin console.
+            # NOTE: changing the default token name '_token' will break some functions in
+            # the new admin console, because '_token' has been hard-coded in
+            # the new admin console, which I believe will be fixed in the future.
     validation: { enable_annotations: true }
     #serializer: { enable_annotations: true }
     # Place "eztpl" engine first intentionally if you setup use with legacy bridge.
```

### Test

Restart nginx and test the website at the following URLs:
* http://ezdemo.localhost:8080/chi - the Chinese front end
* http://ezdemo.localhost:8080/eng - the English front end
* http://ezdemo.localhost:8080/admin - the new admin UI
* http://admin.ezdemo.localhost:8080 - the legacy admin interface

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
