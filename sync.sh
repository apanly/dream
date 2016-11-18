#!/bin/bash

git fetch origin && git rebase origin/master && git push origin master:master
git fetch oschina && git rebase oschina/master && git push oschina master:master
echo 'push over'
