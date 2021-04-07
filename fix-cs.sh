#!/usr/bin/env sh

vendor/nette/coding-standard/ecs check app --preset php71 --fix
if [ "$1" = "--full" ] ; then
  vendor/bin/code-checker -d app -d tests
fi
