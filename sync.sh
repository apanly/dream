#!/bin/bash
git fetch origin  && git push origin master:master
git fetch oschina  && git push oschina master:master
git fetch github &&  git push oschina master:master


echo 'push over'
