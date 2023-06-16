@if ($paginator->hasPages())

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
                        <i class="mdi mdi-chevron-left"></i></a>
                </li>
            @endif



            @foreach ($elements as $element)
                {{-- @if (is_string($element))
                    <li class="page-item">
                        <a class="page-link">{{ $element }}</a>
                    </li>
                @endif --}}

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ $page }} <span
                                        class="sr-only">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                </li>
            @endif


        </ul>
    </nav>
@endif
