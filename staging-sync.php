<?php
/**
 * Plugin Name: Staging Sync
 * Plugin URI: https://baimquraisy.xyz
 * Description: Syncs posts, pages, and custom post types between live and staging environments.
 * Version: 1.0.0
 * Author: Baim Quraisy
 * Author URI: https://baimquraisy.xyz
 * Text Domain: staging-sync
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Plugin code starts here...

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'staging_sync_enqueue_scripts');

function staging_sync_enqueue_scripts() {
    // Enqueue plugin's JavaScript file
    wp_enqueue_script('staging-sync-script', plugin_dir_url(__FILE__) . 'assets/js/staging-sync.js', array('jquery'), '1.0.0', true);

    // Enqueue plugin's CSS file
    wp_enqueue_style('staging-sync-style', plugin_dir_url(__FILE__) . 'assets/css/staging-sync.css', array(), '1.0.0');
}


// Add an admin menu page.
add_action('admin_menu', 'staging_sync_menu');

function staging_sync_menu() {
    add_submenu_page(
        'tools.php',
        'Staging Sync Settings',
        'Staging Sync',
        'manage_options',
        'staging-sync-settings',
        'staging_sync_settings_page'
    );
}

// Create the settings page HTML.
function staging_sync_settings_page() {
    ?>
    <div class="wrap">
        <h1>Staging Sync Settings</h1>
        <p>Configure the Staging Sync settings and check the connection status.</p>
        <form id="staging-sync-settings-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="staging_sync_save_settings">
            <?php wp_nonce_field('staging_sync_save_settings'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="staging-site-url">Staging Site URL</label></th>
                    <td>
                        <input type="text" id="staging-site-url" name="staging_site_url" value="<?php echo esc_attr(get_option('staging_site_url')); ?>" class="regular-text" />
                        <p class="description">Enter the URL of your staging site.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <button type="submit" class="button button-primary">Save Settings</button>
                        <button type="button" class="button button-secondary" id="staging-sync-check-connection">Check Connection</button>
                        <span id="staging-sync-connection-status"></span>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}

// Save the staging site URL.
add_action('admin_post_staging_sync_save_settings', 'staging_sync_save_settings');

function staging_sync_save_settings() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permission to access this page.');
    }

    check_admin_referer('staging_sync_save_settings');

    if (isset($_POST['staging_site_url'])) {
        $stagingSiteUrl = sanitize_text_field($_POST['staging_site_url']);
        update_option('staging_site_url', $stagingSiteUrl);
    }

    wp_safe_redirect(menu_page_url('staging-sync-settings', false));
    exit;
}

// Handle the AJAX check connection request.
add_action('wp_ajax_staging_sync_check_connection', 'staging_sync_check_connection');

function staging_sync_check_connection() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permission to access this page.');
    }

    if (isset($_POST['staging_site_url'])) {
        $stagingSiteUrl = sanitize_text_field($_POST['staging_site_url']);

        // Perform a test connection using the staging site URL.
        $response = wp_remote_get($stagingSiteUrl);
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    wp_die();
}

// Hook into the 'save_post' action to trigger the syncing.
add_action('save_post', 'trigger_staging_sync', 10, 3);

function trigger_staging_sync($post_id, $post, $update) {
    // Exclude auto-draft and revisions.
    if ($post->post_status === 'auto-draft' || wp_is_post_revision($post_id)) {
        return;
    }

    $stagingSiteUrl = get_option('staging_site_url');

    if (!empty($stagingSiteUrl)) {
        // Prepare the post data to be synced.
        $post_data = array(
            'title'   => $post->post_title,
            'content' => $post->post_content,
            'status'  => $post->post_status,
            'type'    => $post->post_type,
            'meta'    => get_post_meta($post_id),
            // Add any additional fields or taxonomies you want to sync.
        );

        // Send a request to the staging environment to sync the post.
        $response = wp_remote_post($stagingSiteUrl . '/wp-json/staging-sync/v1/sync', array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'headers'     => array(
                'Content-Type' => 'application/json',
            ),
            'body'        => json_encode($post_data),
        ));
    }
}

