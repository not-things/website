#!/bin/sh

root_dir="$HOME/org/website"
build_dir=$root_dir/build
site_dir=$root_dir/site
dist_dir=$root_dir/dist

rm -rf "$build_dir"
mkdir "$build_dir"
rm -rf "$dist_dir"
mkdir "$dist_dir"

cp -R "$site_dir"/* "$build_dir"

yarn parcel build "$build_dir/*.html" --no-source-maps --no-cache

# Static content
rsync -av -e ssh --delete ~/org/website/dist/* dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net:/home/public/nothingsinside.org/

# Scripts
rsync -av -e ssh --delete ~/org/website/site/scripts/*.php dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net:/home/public/nothingsinside.org/scripts/

# Protected
rsync -av -e ssh ~/org/website/site/protected/* dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net:/home/protected/

#ssh dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net "chmod 666 /home/public/nothingsinside.org/scripts/visitor_count.txt"