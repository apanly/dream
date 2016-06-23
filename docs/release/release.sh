#!/bin/sh
#/data/www/release.sh
cd /data/www/dream && git fetch --all && git rebase origin/master
DATE=`date +%Y%m%d%H%M%S`
echo $DATE > /data/www/release_version/version_blog