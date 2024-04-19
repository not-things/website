#!/bin/sh

while getopts ":h" option; do
   case $option in
      h) # display Help
         Help
         exit;;
      *)
        exit;;
   esac
done

root_dir=$(pwd)
build_dir=$root_dir/build
site_dir=$root_dir/site
dist_dir=$root_dir/dist

. "$root_dir"/.env

rm -rf "${build_dir:?}"
mkdir "$build_dir"
rm -rf "${dist_dir:?}"
mkdir "$dist_dir"

cp -R "${site_dir:?}"/* "$build_dir"

yarn parcel build "$build_dir/*.html" --no-source-maps --no-cache

# Static content
rsync -av -e ssh --delete "$root_dir"/dist/ "${static_dest:?}"

# Scripts
rsync -av -e ssh --delete "$root_dir"/site/scripts/ "${scripts_dest:?}"

# Protected directory, for non user-facing data
rsync -av -e ssh "$root_dir"/site/protected/

