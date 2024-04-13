#!/bin/sh

build_dir=build
site_dir=site
dist_dir=dist

rm -rf $build_dir
mkdir $build_dir
rm -rf $dist_dir
mkdir $dist_dir

cp -R $site_dir/* $build_dir

yarn parcel build $build_dir/index.html --no-source-maps --no-cache --public-url './'

rsync -av -e ssh --delete ~/org/website/dist/* dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net:/home/public/nothingsinside.org/
rsync -av -e ssh --delete ~/org/website/site/scripts/*.php dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net:/home/public/nothingsinside.org/scripts/

#ssh dingerdonger02_nothingsinside@ssh.nyc1.nearlyfreespeech.net "chmod 666 /home/public/nothingsinside.org/scripts/visitor_count.txt"