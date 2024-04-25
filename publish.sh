#!/bin/sh

Help() {
	printf "build"
}

root_dir=$(pwd)
build_dir=$root_dir/build
site_dir=$root_dir/site
dist_dir=$root_dir/dist

# shellcheck source=/dev/null
. "$root_dir"/.env

rm -rf "${build_dir:?}"
mkdir "$build_dir"
rm -rf "${dist_dir:?}"
mkdir "$dist_dir"

while getopts ":hdb" option; do
	case $option in
		h) # display Help
			Help
			exit;;
		d)
			cp -Rv "${site_dir:?}"/* "$dist_dir"
			cp -Rv "$root_dir/site/protected/" "$dist_dir"
			yarn parcel build "${dist_dir}/*.html" --config .parcelrc_dev --no-cache --dist-dir "dist"
		;;

		b)
			cp -R "${site_dir:?}"/* "$build_dir"
			yarn parcel build "${build_dir}/*.html" --no-source-maps --no-cache

			# Static content
			rsync -av -e ssh --delete "$root_dir"/dist/ "${static_dest:?}"

			# Scripts
			rsync -av -e ssh "$root_dir"/site/scripts/ "${scripts_dest:?}"

			# Protected directory, for non user-facing data
			rsync -av -e ssh "$site_dir"/protected/* "${protected_dest:?}"
	esac
done
