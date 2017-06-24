#!/bin/bash
git fetch oschina && git rebase oschina/master && git push oschina master:master
git fetch origin && git rebase origin/master && git push origin master:master

echo 'push over'
