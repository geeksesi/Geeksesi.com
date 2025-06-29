<header class="header sticky top-0 z-50">
  <div class="px-10">
    <div class="header-content">
      <!-- Logo -->
      <div class="flex items-center">

      </div>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center space-x-8">
        <!-- Primary Navigation -->
        @if (has_nav_menu('primary_navigation'))
          <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu([
              'theme_location' => 'primary_navigation',
              'menu_class' => 'menu',
              'container' => false,
              'echo' => false
            ]) !!}
          </nav>
        @endif

        <!-- Dark Mode Toggle -->
        <div class="flex items-center">
          <button id="dark-mode-toggle" class="theme-toggle" title="Toggle dark mode">
            <svg class="sun-and-moon" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24">
              <mask class="moon" id="moon-mask">
                <rect x="0" y="0" width="100%" height="100%" fill="white" />
                <circle cx="24" cy="10" r="6" fill="black" />
              </mask>
              <circle class="sun" cx="12" cy="12" r="6" mask="url(#moon-mask)" fill="currentColor" />
              <g class="sun-beams" stroke="currentColor">
                <line x1="12" y1="1" x2="12" y2="3" />
                <line x1="12" y1="21" x2="12" y2="23" />
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                <line x1="1" y1="12" x2="3" y2="12" />
                <line x1="21" y1="12" x2="23" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
              </g>
            </svg>
          </button>
        </div>

        <!-- Social Navigation -->
        @if (has_nav_menu('social_navigation'))
          <nav class="social-nav" aria-label="{{ wp_get_nav_menu_name('social_navigation') }}">
            {!! wp_nav_menu([
              'theme_location' => 'social_navigation',
              'menu_class' => 'menu',
              'container' => false,
              'echo' => false
            ]) !!}
          </nav>
        @endif

      </div>


      <!-- Mobile Menu Button -->
      <div class="md:hidden flex items-center space-x-4">
        <!-- Mobile Dark Mode Toggle -->
        <button id="mobile-dark-mode-toggle" class="theme-toggle" title="Toggle dark mode">
          <svg class="sun-and-moon" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24">
            <mask class="moon" id="mobile-moon-mask">
              <rect x="0" y="0" width="100%" height="100%" fill="white" />
              <circle cx="24" cy="10" r="6" fill="black" />
            </mask>
            <circle class="sun" cx="12" cy="12" r="6" mask="url(#mobile-moon-mask)" fill="currentColor" />
            <g class="sun-beams" stroke="currentColor">
              <line x1="12" y1="1" x2="12" y2="3" />
              <line x1="12" y1="21" x2="12" y2="23" />
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
              <line x1="1" y1="12" x2="3" y2="12" />
              <line x1="21" y1="12" x2="23" y2="12" />
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </g>
          </svg>
        </button>

        <!-- Mobile Menu Toggle -->
        <button type="button" class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle mobile menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden" id="mobile-menu">
      @if (has_nav_menu('primary_navigation'))
        <nav aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
          {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'menu',
            'container' => false,
            'echo' => false
          ]) !!}
        </nav>
      @endif

      @if (has_nav_menu('social_navigation'))
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
          <div class="flex justify-center space-x-6">
            {!! wp_nav_menu([
              'theme_location' => 'social_navigation',
              'menu_class' => 'menu flex space-x-6',
              'container' => false,
              'echo' => false
            ]) !!}
          </div>
        </div>
      @endif
    </div>
  </div>
</header>

<script>
// Sync mobile and desktop dark mode toggles
document.addEventListener('DOMContentLoaded', function() {
  const desktopToggle = document.getElementById('dark-mode-toggle');
  const mobileToggle = document.getElementById('mobile-dark-mode-toggle');
  const html = document.documentElement;

  function setTheme(isDark) {
    html.classList.toggle('dark', isDark);
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    if (desktopToggle) desktopToggle.setAttribute('aria-pressed', isDark);
    if (mobileToggle) mobileToggle.setAttribute('aria-pressed', isDark);
  }

  const savedTheme = localStorage.getItem('theme');
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isDark = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
  setTheme(isDark);

  function toggleTheme() {
    const isDark = html.classList.contains('dark');
    setTheme(!isDark);
  }

  if (desktopToggle) {
    desktopToggle.addEventListener('click', toggleTheme);
  }
  if (mobileToggle) {
    mobileToggle.addEventListener('click', toggleTheme);
  }
});
</script>
