=== Staging Sync ===

Contributors: baimquraisy
Tags: staging, sync, development, staging environment
Requires at least: 5.0
Tested up to: 5.8
Stable tag: 1.0.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

== Description ==

Staging Sync is a WordPress plugin that allows you to synchronize posts, pages, and custom post types between live and staging environments. It provides an easy way to ensure that changes made in the live environment are replicated in the staging environment automatically.

== Features ==

Syncs posts, pages, and custom post types between live and staging environments.
Supports syncing of post metadata and taxonomies.
Easy-to-use settings page to configure the staging site URL and check the connection status.
Ajax-based connection check to verify the connectivity with the staging site.
Integration with WordPress admin menu and Tools section for convenient access to settings and connection check.
== Installation ==

Upload the staging-sync folder to the /wp-content/plugins/ directory.
Activate the Staging Sync plugin through the 'Plugins' menu in WordPress.
Go to the 'Staging Sync' settings page under the 'Tools' section in the WordPress admin dashboard.
Enter the URL of your staging site and save the settings.
Use the 'Check Connection' button to verify the connectivity with the staging site.
== Frequently Asked Questions ==

= How does Staging Sync work? =

Staging Sync uses the WordPress REST API to sync posts, pages, and custom post types between the live and staging environments. When a post is saved or updated in the live environment, the plugin triggers a synchronization process that sends the necessary data to the staging site, ensuring that the same content is replicated in the staging environment.

= Can I sync post metadata and taxonomies? =

Yes, Staging Sync supports syncing of post metadata and taxonomies along with the basic post content. Any custom fields, metadata, or taxonomies associated with the post will be included in the synchronization process.

= What happens if the staging site URL is not reachable? =

If the staging site URL provided in the settings is not reachable or the connection check fails, an error message will be displayed. Please ensure that the staging site is accessible and the URL is correctly entered.

== Changelog ==

= 1.0.0 =

Initial release
== Upgrade Notice ==

= 1.0.0 =
Initial release of the Staging Sync plugin.
