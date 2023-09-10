@if ($paginator->hasPages())

  <div class="buttons">
    {{-- Previous page link --}}
    @if ($paginator->onFirstPage())
      <button type="button" class="button disabled text-opacity-30 hover:border-transparent hover:cursor-default" aria-disabled="true" aria-label="@lang('pagination.previous')">
        <span aria-hidden="true">&lsaquo;</span>
      </button>
    @else
      <button type="button" class="">
        <a href="{{ isset($_GET['search']) ? $paginator->previousPageUrl().'&search='.$_GET['search'] : $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" class="button">&lsaquo;</a>
      </button>
    @endif


    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
      @if (is_string($element))
        <div class="disabled" aria-disabled="true"><span>{{ $element }}</span></div>
      @endif

      {{-- Array Of Links --}}
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <button class="disabled button hover:border-transparent hover:cursor-default  " aria-current="page"><span class="text-gray-400">{{ $page }}</span></button>
          @else
            <a class="button" href="{{ isset($_GET['search']) ? $url.'&search='.$_GET['search'] : $url }}">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <button>
        <a href="{{ isset($_GET['search']) ? $paginator->nextPageUrl().'&search='.$_GET['search'] : $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="button">&rsaquo;</a>
      </button>
    @else
      <button class="button disabled text-opacity-30 hover:border-transparent hover:cursor-default" aria-disabled="true" aria-label="@lang('pagination.next')">
        <span aria-hidden="true">&rsaquo;</span>
      </button>
    @endif

    
        {{-- <button type="button" class="button">$</button> --}}
    </div>
    <small>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }} </small>



@endif
