@if ($pagi->hasPages())
  <nav class="flex items-center my-8" aria-label="pagination">
    @if (! $pagi->onFirstPage())
      <a
        href="{{ $pagi->previousPageUrl() }}"
        rel="prev"
        aria-label="Previous Page"
        class="border rounded-sm mr-3 py-1 px-4 hover:bg-blue-600 hover:text-white"
      >
        <span aria-hidden="true">&larr; Previous</span>
      </a>
    @endif

    <ul class="flex">
      @foreach ($pagi->elements() as $element)
        @if (is_string($element))
          <li class="disabled">
            <span class="mr-3 py-1">&hellip;</span>
          </li>
        @endif

        @if (is_array($element))
          @foreach ($element as $page => $url)
            <li>
              @if ($page == $pagi->currentPage())
                <span
                  class="border rounded-sm mr-3 py-1 px-4 bg-blue-600 text-white"
                  aria-current="page"
                >{{ $page }}</span>
              @else
                <a
                  href="{{ $url }}"
                  class="border rounded-sm mr-3 py-1 px-4 hover:bg-blue-600 hover:text-white"
                >{{ $page }}</a>
              @endif
            </li>
          @endforeach
        @endif
      @endforeach
    </ul>

    @if ($pagi->hasMorePages())
      <a
        href="{{ $pagi->nextPageUrl() }}"
        rel="next"
        aria-label="Next Page"
        class="border rounded-sm mr-3 py-1 px-4 hover:bg-blue-600 hover:text-white"
      >
        <span aria-hidden="true">Next &rarr;</span>
      </a>
    @endif
  </nav>
@endif
