#!/usr/bin/env sh

Help() {
	printf "build"
}

root_dir=$(pwd)
site_dir=$root_dir/site
dist_dir=$root_dir/dist

# shellcheck source=/dev/null
. "$root_dir"/.env

rm -rfv "${dist_dir:?}/*"
# mkdir "$dist_dir"

while getopts "hdb" option; do
	case $option in
		h) # display Help
			Help
			exit;;
		d) # Debug build
			# Need to fix
			cp -R "${site_dir:?}"/* "$dist_dir"

			cp -Rv "$root_dir/site/protected/" "$dist_dir"
			yarn parcel build "${dist_dir}/*.html" --config .parcelrc_dev --no-cache --dist-dir "dist"
			;;

		b)
			# Copy the site over
			cp -R "${site_dir:?}"/* "$dist_dir"

			yarn parcel build "${dist_dir:?}/*.html" --no-source-maps --no-cache

			rsync --delete-excluded -av -e ssh --prune-empty-dirs --include="*/" --include-from="${root_dir:?}/.rsync-filter" --exclude="*" "${dist_dir:?}/" "${static_dest:?}"
			;;
        \?)
            echo "Invalid option: -$OPTARG" >&2
            Help
            ;;
		:)
            echo "Option -$OPTARG requires an argument." >&2
            Help
            ;;
	esac
done

# Check if no options were provided
if [ "$OPTIND" -eq 1 ]; then
    echo "No options were specified."
    Help
fi