#!/bin/bash

git fetch --all && git rebase origin/master && git push origin master:master
git fetch --all && git oschina origin/master && git push oschina master:master
echo 'push over'
