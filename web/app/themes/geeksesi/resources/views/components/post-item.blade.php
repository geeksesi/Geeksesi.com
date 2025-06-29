<article class="post-item border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0 last:pb-0">
  <div class="flex flex-col space-y-2">
    <h3 class="text-lg font-medium">
      <a href="{{ get_permalink() }}"
         class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
        {{ get_the_title() }}
      </a>
    </h3>

    <div class="text-sm text-gray-500 dark:text-gray-400">
      {{ get_the_date() }}
    </div>
  </div>
</article>
