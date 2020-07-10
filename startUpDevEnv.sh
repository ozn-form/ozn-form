#!/usr/bin/env bash
php -S 0.0.0.0:8080 -t /Users/saya/Dropbox/WorkProjectSources/ozn-form >/dev/null 2>&1 &
gulp document_watch
