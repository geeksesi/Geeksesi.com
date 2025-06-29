<section class="category-posts-section py-12 bg-gray-50 dark:bg-gray-800">
  <div class="max-w-4xl mx-auto px-6">
    <div class="flex justify-between items-start mb-6">
      <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
          {{ $title }}
        </h2>
        @if($description)
          <p class="text-gray-600 dark:text-gray-400 text-sm">
            {{ $description }}
          </p>
        @endif
      </div>

      <a href="{{ get_category_link($category) }}"
         class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm transition-colors duration-200 flex-shrink-0 ml-4">
        {{ $see_all_text }}
      </a>
    </div>

    <div class="space-y-4">
      @while($posts_query->have_posts())
        @php($posts_query->the_post())
        @include('components.post-item')
      @endwhile
      @php(wp_reset_postdata())
    </div>
  </div>
</section>
