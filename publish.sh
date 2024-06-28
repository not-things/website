#!/bin/sh

Help() {
	echo "this is a placeholder help"
}

root_dir=$(pwd)
site_dir=$root_dir/site
dist_dir=$root_dir/dist
extensions_to_copy="*.php"


# shellcheck source=/dev/null
. "$root_dir"/.env

echo "Removing ${dist_dir:?}"
rm -rv "${dist_dir}"/*

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
			yarn parcel build "${site_dir:?}/*.html" --no-source-maps --no-cache
			
			find "${site_dir:?}" -name "*.php" | while read -r file_path
			do
				
				# Get the relative path (to site dir) of the file
				relative_path="${file_path#"$site_dir"/}"

				# Create the directory structure in the target directory
				target_path="$dist_dir/$(dirname "$relative_path")"
				mkdir -p "$target_path"

				# Copy the file to the target directory, preserving the directory structure
				cp "$file_path" "$target_path/"
			done

			rsync -av -e ssh --prune-empty-dirs --delete "${dist_dir:?}/" "${static_dir:?}"
			rsync -av -e ssh "${root_dir:?}/protected/" "${protected_dir}"
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
