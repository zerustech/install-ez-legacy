#!/bin/bash
WEB_USER=<web-user>
WEB_USER_GROUP=<web-group>

SCRIPT_PATH=`dirname "$0"`
SCRIPT_PATH=`( cd "$SCRIPT_PATH" && pwd )`

cd "$SCRIPT_PATH/../.."

sudo chown -R $WEB_USER:$WEB_USER_GROUP ezpublish/{cache,logs,config,sessions} web

for f in `find {ezpublish/{cache,logs,config,sessions},web} -type d`
do
    sudo chmod -R 755 $f
done

for f in `find ezpublish_legacy/{design,extension,settings,var} -type d`
do
    sudo chmod -R 755 $f
done

for f in `find {ezpublish/{cache,logs,config,sessions},web} -type f`
do
    sudo chmod -R 664 $f
done

for f in `find ezpublish_legacy/{design,extension,settings,var} -type f`
do
    sudo chmod -R 664 $f
done

cd $SCRIPT_PATH
