#!/bin/sh

rsync -av -e ssh --delete /home/dabanya02/org/website/publish/* dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net:/home/public/nothingsinside.org/
