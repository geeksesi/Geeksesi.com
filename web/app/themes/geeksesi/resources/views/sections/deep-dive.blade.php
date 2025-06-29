@php
$tutorials = get_posts([
    'category_name' => 'Tutorials',
    'posts_per_page' => 9,
    'post_status' => 'publish'
]);

@endphp
@if($tutorials)
<section class="deep-dive-section py-16 my-5" >
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="deep-dive-title text-3xl font-bold mb-2">Deep Dives</h2>
        <p class="deep-dive-subtitle">Long-form tutorials on a variety of development topics.</p>
      </div>
      <a href="{{ get_category_link(get_cat_ID('tutorials')) }}" class="deep-dive-link font-medium transition-colors duration-200">
        All Topics
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @if($tutorials)
        @foreach($tutorials as $index => $tutorial)
          @php
            $custom_icon = get_custom_icon($tutorial->ID, 'thumbnail');
          @endphp

          <article class="deep-dive-card h-32 w-full">
            <div class="flex items-center space-x-4 h-full">
              <div class="flex-shrink-0">
                <div class="deep-dive-icon deep-dive-icon-custom">
                  <img src="{{ $custom_icon }}" alt="{{ get_the_title($tutorial->ID) }}" class="w-full h-full object-cover rounded-lg">
                </div>
              </div>
              <div class="flex-1 min-h-0 flex flex-col justify-center">
                <h3 class="deep-dive-card-title line-clamp-3">
                  <a href="{{ get_permalink($tutorial->ID) }}" class="deep-dive-card-link">
                    {{ get_the_title($tutorial->ID) }}
                  </a>
                </h3>
              </div>
            </div>
          </article>
        @endforeach
      @else
        <!-- Fallback content if no tutorials found -->
        <article class="deep-dive-card h-32">
          <div class="flex items-start space-x-4 h-full">
            <div class="flex-shrink-0">
              <div class="deep-dive-icon deep-dive-icon-pink">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z"/>
                </svg>
              </div>
            </div>
            <div class="flex-1 min-h-0 flex flex-col justify-center">
              <h3 class="deep-dive-card-title line-clamp-3">
                <a href="#" class="deep-dive-card-link">
                  No tutorials found. Please add some posts to the 'tutorials' category.
                </a>
              </h3>
            </div>
          </div>
        </article>
      @endif
    </div>
  </div>
</section>
@else
<div></div>
@endif
