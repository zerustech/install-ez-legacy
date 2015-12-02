#!/bin/bash
SCRIPT_PATH=`dirname "$0"`
SCRIPT_PATH=`( cd "$SCRIPT_PATH" && pwd )`

cd "$SCRIPT_PATH/../.."

cp -rf install-ez-legacy/ezpublish_legacy/settings ezpublish_legacy

cd $SCRIPT_PATH
