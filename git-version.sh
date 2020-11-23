#!/usr/bin/env sh

version=`git describe --tags`
timestamp=`git log -1 --pretty='%cd' --date=format:'%Y/%m/%d %H:%M:%S'`

echo "${version} | ${timestamp}" > version