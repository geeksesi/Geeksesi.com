<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'social_navigation' => __('Social Navigation', 'sage'),
        'sidebar_guides' => __('Sidebar Guides', 'sage'),
        'sidebar_fun_stuff' => __('Sidebar Fun Stuff', 'sage'),
        'sidebar_projects' => __('Sidebar Projects', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<div class="widget %1$s %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary Sidebar', 'sage'),
        'id' => 'sidebar-primary',
        'description' => __('Main sidebar that appears on the left side of the page.', 'sage'),
    ] + $config);

    register_sidebar([
        'name' => __('About Section', 'sage'),
        'id' => 'sidebar-about',
        'description' => __('About section for the sidebar.', 'sage'),
    ] + $config);

    register_sidebar([
        'name' => __('Connect Section', 'sage'),
        'id' => 'sidebar-connect',
        'description' => __('Social connections section for the sidebar.', 'sage'),
    ] + $config);

    // New widget areas for category posts
    register_sidebar([
        'name' => __('Notes Section', 'sage'),
        'id' => 'homepage-notes',
        'description' => __('Notes section for the homepage.', 'sage'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ]);

    register_sidebar([
        'name' => __('Articles Section', 'sage'),
        'id' => 'homepage-articles',
        'description' => __('Articles section for the homepage.', 'sage'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ]);

    // Register the custom widget
    register_widget('App\Widgets\CategoryPostsWidget');
});

/**
 * Enqueue FontAwesome
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');
});

/**
 * Add custom CSS classes to menu items for social icons
 */
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    if ($args->theme_location === 'social_navigation') {
        $classes[] = 'social-menu-item';

        // Add icon class based on URL
        $url = $item->url;
        if (strpos($url, 'github.com') !== false) {
            $classes[] = 'github-icon';
        } elseif (strpos($url, 'linkedin.com') !== false) {
            $classes[] = 'linkedin-icon';
        } elseif (strpos($url, 'twitter.com') !== false || strpos($url, 'x.com') !== false) {
            $classes[] = 'twitter-icon';
        } elseif (strpos($url, 'instagram.com') !== false) {
            $classes[] = 'instagram-icon';
        } elseif (strpos($url, 'dribbble.com') !== false) {
            $classes[] = 'dribbble-icon';
        } elseif (strpos($url, 'behance.net') !== false) {
            $classes[] = 'behance-icon';
        } elseif (strpos($url, 'youtube.com') !== false) {
            $classes[] = 'youtube-icon';
        }
    }

    // Add classes for sidebar menus
    if (in_array($args->theme_location, ['sidebar_guides', 'sidebar_fun_stuff', 'sidebar_projects'])) {
        $classes[] = 'sidebar-menu-item';
    }

    return $classes;
}, 10, 3);
