#!/bin/sh
# Builds a clean, uploadable copy of the theme: dist/dany_maid_cleaning_services.zip
# (Appearance → Themes → Add New → Upload, or unzip over wp-content/themes/ by FTP).
# Leaves out everything only needed for development: node_modules, .git, src, npm files.
set -e
cd "$(dirname "$0")/.."
THEME="$(basename "$PWD")"
mkdir -p dist
rm -f "dist/$THEME.zip"
cd ..
zip -rq "$THEME/dist/$THEME.zip" "$THEME" \
  -x "$THEME/node_modules/*" "$THEME/.git/*" "$THEME/src/*" "$THEME/dist/*" "$THEME/bin/*" \
     "$THEME/package.json" "$THEME/package-lock.json" "$THEME/.gitignore" "*.DS_Store"
cd "$THEME"
echo "Created dist/$THEME.zip ($(du -h "dist/$THEME.zip" | cut -f1))"
