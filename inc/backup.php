<?php
/**
 * Keeps development-only folders of this theme out of UpdraftPlus backups (and so out of
 * migrations to the test/live server). The site only needs the PHP files, build/ and assets/;
 * node_modules (~600 MB) and .git are rebuilt with `npm install` / cloned from GitHub.
 * For a clean theme upload instead, run `npm run zip` (see bin/make-zip.sh).
 */

const DM_BACKUP_EXCLUDED_DIRS = array('node_modules', '.git', 'dist');

function dm_updraft_exclude_dev_dirs($exclude, $fullpath) {
  $theme = wp_normalize_path(get_stylesheet_directory());
  $path  = wp_normalize_path($fullpath);
  if (strpos($path, $theme . '/') !== 0) {
    return $exclude;
  }
  $relative = substr($path, strlen($theme) + 1);
  return in_array($relative, DM_BACKUP_EXCLUDED_DIRS, true) ? true : $exclude;
}

add_filter('updraftplus_exclude_directory', 'dm_updraft_exclude_dev_dirs', 10, 2);
