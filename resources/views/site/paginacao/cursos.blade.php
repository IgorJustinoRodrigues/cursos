@if ($paginator->hasPages())
    <ul class="default-pagination lab-ul">
        @if ($paginator->onFirstPage())
            <li class="d-none">
                <a href=""><i class="icofont-rounded-left"></i></a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}&busca={{$busca}}&categoria={{$categoria}}&ordem={{$ordem}}"><i class="icofont-rounded-left"></i></a>
            </li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li>
                    <a href="#" class="active">{{ $element }}</a>
                </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page + 2 >= $paginator->currentPage() and $page <= $paginator->currentPage() or $page - 2 <= $paginator->currentPage() and $page >= $paginator->currentPage())
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a href="#" class="disabled active">{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}&busca={{$busca}}&categoria={{$categoria}}&ordem={{$ordem}}">{{ $page }}</a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}&busca={{$busca}}&categoria={{$categoria}}&ordem={{$ordem}}"><i class="icofont-rounded-right"></i></a>
            </li>
        @else
            <li class="d-none">
                <a href=""><i class="icofont-rounded-right"></i></a>
            </li>
        @endif
    </ul>
@endif
