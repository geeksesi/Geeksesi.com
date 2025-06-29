<?php

/**
 * Custom Icon Meta Box for Posts and Pages
 */

// Add meta box
add_action('add_meta_boxes', 'add_custom_icon_meta_box');
function add_custom_icon_meta_box() {
    add_meta_box(
        'custom-icon-meta-box',
        'Post/Page Icon',
        'custom_icon_meta_box_callback',
        ['post', 'page'],
        'side',
        'default'
    );
}

// Meta box callback function
function custom_icon_meta_box_callback($post) {
    wp_nonce_field('custom_icon_meta_box', 'custom_icon_meta_box_nonce');

    $icon_id = get_post_meta($post->ID, '_custom_icon_id', true);
    $icon_url = '';

    if ($icon_id) {
        $icon_url = wp_get_attachment_image_url($icon_id, 'thumbnail');
    }

    ?>
    <div class="custom-icon-field">
        <input type="hidden" id="custom_icon_id" name="custom_icon_id" value="<?php echo esc_attr($icon_id); ?>" />

        <div class="custom-icon-preview" style="margin-bottom: 10px;">
            <?php if ($icon_url): ?>
                <img src="<?php echo esc_url($icon_url); ?>" style="max-width: 100px; height: auto; display: block;" />
            <?php else: ?>
                <div style="width: 100px; height: 100px; background: #f0f0f0; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; color: #666;">
                    No Icon
                </div>
            <?php endif; ?>
        </div>

        <button type="button" class="button custom-icon-upload" id="custom_icon_upload">
            <?php echo $icon_id ? 'Change Icon' : 'Upload Icon'; ?>
        </button>

        <?php if ($icon_id): ?>
            <button type="button" class="button custom-icon-remove" id="custom_icon_remove" style="margin-left: 10px;">
                Remove Icon
            </button>
        <?php endif; ?>

        <p class="description">Upload a square image (recommended: 100x100px or larger)</p>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;

        // Upload icon
        $('#custom_icon_upload').on('click', function(e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: 'Choose Icon',
                button: {
                    text: 'Choose Icon'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#custom_icon_id').val(attachment.id);
                $('.custom-icon-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width: 100px; height: auto; display: block;" />');
                $('#custom_icon_upload').text('Change Icon');
                if ($('#custom_icon_remove').length === 0) {
                    $('#custom_icon_upload').after('<button type="button" class="button custom-icon-remove" id="custom_icon_remove" style="margin-left: 10px;">Remove Icon</button>');
                }
            });

            mediaUploader.open();
        });

        // Remove icon
        $(document).on('click', '#custom_icon_remove', function(e) {
            e.preventDefault();
            $('#custom_icon_id').val('');
            $('.custom-icon-preview').html('<div style="width: 100px; height: 100px; background: #f0f0f0; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; color: #666;">No Icon</div>');
            $('#custom_icon_upload').text('Upload Icon');
            $(this).remove();
        });
    });
    </script>
    <?php
}

// Save meta box data
add_action('save_post', 'save_custom_icon_meta_box_data');
function save_custom_icon_meta_box_data($post_id) {
    if (!isset($_POST['custom_icon_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['custom_icon_meta_box_nonce'], 'custom_icon_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (!isset($_POST['custom_icon_id'])) {
        return;
    }

    $icon_id = sanitize_text_field($_POST['custom_icon_id']);
    update_post_meta($post_id, '_custom_icon_id', $icon_id);
}

// Enqueue media uploader scripts
add_action('admin_enqueue_scripts', 'enqueue_custom_icon_scripts');
function enqueue_custom_icon_scripts($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}

// Helper function to get custom icon
function get_custom_icon($post_id, $size = 'thumbnail') {
    $icon_id = get_post_meta($post_id, '_custom_icon_id', true);
    if ($icon_id) {
        return wp_get_attachment_image_url($icon_id, $size);
    }
    return false;
}