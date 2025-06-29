<div class="flex flex-col lg:flex-row gap-8">
  <!-- Notes Section -->
  <div class="flex-1">

    @if(is_active_sidebar('homepage-notes'))
      @php(dynamic_sidebar('homepage-notes'))
    @endif
  </div>

  <!-- Articles Section -->
  <div class="flex-1">

    @if(is_active_sidebar('homepage-articles'))
      @php(dynamic_sidebar('homepage-articles'))
    @endif
  </div>
</div>
