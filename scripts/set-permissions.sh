#!/bin/bash
OWNER=<owner>
WEB_USER=<web-user>
WEB_USER_GROUP=<web-group>

SCRIPT_PATH=`dirname "$0"`
SCRIPT_PATH=`( cd "$SCRIPT_PATH" && pwd )`

cd "$SCRIPT_PATH/../.."

chown -R $WEB_USER:$WEB_USER_GROUP ezpublish web

chown -R $OWNER:$WEB_USER_GROUP ezpublish/config

chown -R $WEB_USER:$WEB_USER_GROUP ezpublish_legacy/var

chmod -R 777 ~/.composer/cache

for f in `find {ezpublish/{cache,logs,config,sessions},web} -type d`
do
    chmod -R 755 $f
done

for f in `find ezpublish_legacy/{design,extension,settings,var} -type d`
do
    chmod -R 755 $f
done

for f in `find {ezpublish/{cache,logs,config,sessions},web} -type f`
do
    chmod -R 664 $f
done

for f in `find ezpublish_legacy/{design,extension,settings,var} -type f`
do
    chmod -R 664 $f
done

cd $SCRIPT_PATH
