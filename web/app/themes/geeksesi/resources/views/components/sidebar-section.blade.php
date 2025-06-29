@props(['title', 'menuLocation' => null, 'content' => null, 'links' => []])

<div class="sidebar-section space-y-3">
  <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $title }}</h3>

  @if($menuLocation && has_nav_menu($menuLocation))
    <nav class="sidebar-nav">
      {!! wp_nav_menu([
        'theme_location' => $menuLocation,
        'menu_class' => 'sidebar-menu space-y-2',
        'container' => false,
        'echo' => false
      ]) !!}
    </nav>
  @elseif($content)
    <div class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
      {!! $content !!}
    </div>
  @elseif(!empty($links))
    <ul class="space-y-2">
      @foreach($links as $link)
        <li>
          <a href="{{ $link['url'] ?? '#' }}"
             class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center transition-colors duration-200">
            @if(isset($link['icon']))
              <span class="mr-2">{{ $link['icon'] }}</span>
            @endif
            {{ $link['text'] }}
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</div>
