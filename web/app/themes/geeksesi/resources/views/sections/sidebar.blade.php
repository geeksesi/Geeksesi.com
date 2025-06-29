<aside class="sidebar hidden lg:block lg:w-64 bg-gray-50 dark:bg-gray-800 p-6 space-y-6 border-r border-gray-200 dark:border-gray-700 transition-colors duration-300">
  
  @if(is_active_sidebar('sidebar-about'))
    <div class="sidebar-section">
      @php(dynamic_sidebar('sidebar-about'))
    </div>
  @endif

  @if(is_active_sidebar('sidebar-connect'))
    <div class="sidebar-section">
      @php(dynamic_sidebar('sidebar-connect'))
    </div>
  @endif

  @if(is_active_sidebar('sidebar-primary'))
    <div class="sidebar-section">
      @php(dynamic_sidebar('sidebar-primary'))
    </div>
  @endif

  @if(!is_active_sidebar('sidebar-primary') && !is_active_sidebar('sidebar-about') && !is_active_sidebar('sidebar-connect'))
    <div class="sidebar-section">
      <h3>No Widgets</h3>
      <p class="text-sm text-gray-600 dark:text-gray-400">
        Please add widgets to the sidebar areas in the WordPress admin.
      </p>
    </div>
  @endif

</aside>
