<?php

namespace App\Widgets;

use WP_Widget;
use WP_Query;

class CategoryPostsWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'category_posts_widget',
            __('Category Posts', 'sage'),
            [
                'description' => __('Display posts from a selected category with configurable options', 'sage'),
                'classname' => 'category-posts-widget',
            ]
        );
    }

    public function widget($args, $instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $category = !empty($instance['category']) ? $instance['category'] : '';
        $posts_per_page = !empty($instance['posts_per_page']) ? (int) $instance['posts_per_page'] : 3;
        $see_all_text = !empty($instance['see_all_text']) ? $instance['see_all_text'] : __('See All', 'sage');

        if (empty($category)) {
            return;
        }

        $query_args = [
            'cat' => $category,
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
        ];

        $posts_query = new WP_Query($query_args);

        if (!$posts_query->have_posts()) {
            return;
        }

        echo $args['before_widget'];

        echo view('components.category-posts-section', [
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'see_all_text' => $see_all_text,
            'posts_query' => $posts_query,
        ])->render();

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $category = !empty($instance['category']) ? $instance['category'] : '';
        $posts_per_page = !empty($instance['posts_per_page']) ? $instance['posts_per_page'] : 3;
        $see_all_text = !empty($instance['see_all_text']) ? $instance['see_all_text'] : __('See All', 'sage');

        $categories = get_categories(['hide_empty' => false]);

        echo view('components.category-posts-form', [
            'widget' => $this,
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'posts_per_page' => $posts_per_page,
            'see_all_text' => $see_all_text,
            'categories' => $categories,
        ])->render();
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_textarea_field($new_instance['description']) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? (int) $new_instance['category'] : '';
        $instance['posts_per_page'] = (!empty($new_instance['posts_per_page'])) ? (int) $new_instance['posts_per_page'] : 3;
        $instance['see_all_text'] = (!empty($new_instance['see_all_text'])) ? sanitize_text_field($new_instance['see_all_text']) : __('See All', 'sage');

        return $instance;
    }
}
