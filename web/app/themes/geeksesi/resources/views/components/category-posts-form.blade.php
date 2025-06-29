<div class="category-posts-widget-form">
  <p>
    <label for="{{ $widget->get_field_id('title') }}">{{ __('Title:', 'sage') }}</label>
    <input class="widefat"
           id="{{ $widget->get_field_id('title') }}"
           name="{{ $widget->get_field_name('title') }}"
           type="text"
           value="{{ esc_attr($title) }}">
  </p>

  <p>
    <label for="{{ $widget->get_field_id('description') }}">{{ __('Description:', 'sage') }}</label>
    <textarea class="widefat"
              id="{{ $widget->get_field_id('description') }}"
              name="{{ $widget->get_field_name('description') }}"
              rows="3">{{ esc_textarea($description) }}</textarea>
  </p>

  <p>
    <label for="{{ $widget->get_field_id('category') }}">{{ __('Category:', 'sage') }}</label>
    <select class="widefat"
            id="{{ $widget->get_field_id('category') }}"
            name="{{ $widget->get_field_name('category') }}">
      <option value="">{{ __('Select Category', 'sage') }}</option>
      @foreach($categories as $cat)
        <option value="{{ esc_attr($cat->term_id) }}"
                @selected($category == $cat->term_id)>
          {{ esc_html($cat->name) }}
        </option>
      @endforeach
    </select>
  </p>

  <p>
    <label for="{{ $widget->get_field_id('posts_per_page') }}">{{ __('Posts per page:', 'sage') }}</label>
    <input class="small-text"
           id="{{ $widget->get_field_id('posts_per_page') }}"
           name="{{ $widget->get_field_name('posts_per_page') }}"
           type="number"
           min="1"
           max="20"
           value="{{ esc_attr($posts_per_page) }}">
  </p>

  <p>
    <label for="{{ $widget->get_field_id('see_all_text') }}">{{ __('See All Button Text:', 'sage') }}</label>
    <input class="widefat"
           id="{{ $widget->get_field_id('see_all_text') }}"
           name="{{ $widget->get_field_name('see_all_text') }}"
           type="text"
           value="{{ esc_attr($see_all_text) }}">
  </p>
</div>
