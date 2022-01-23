@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center pagination-sm ">

            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true" class="material-icons">chevron_left</span>
                        <span>Anterior</span>
                    </a>
                </li>

            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}&busca={{ $busca }}" class="page-link"
                        aria-label="Previous">
                        <span aria-hidden="true" class="material-icons">chevron_left</span>
                        <span>Anterior</span>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item active">
                        <a class="page-link" href="#" aria-label="1">
                            <span>{{ $element }}</span>
                        </a>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page + 2 >= $paginator->currentPage() and $page <= $paginator->currentPage() or $page - 2 <= $paginator->currentPage() and $page >= $paginator->currentPage())
                            @if ($page == $paginator->currentPage())
                                <li class="page-item disabled active">
                                    <a class="page-link" href="#" aria-label="{{ $page }}">
                                        <span>{{ $page }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href={{ $url }}&busca={{ $busca }}
                                        aria-label="{{ $page }}">
                                        <span>{{ $page }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}&busca={{ $busca }}"
                        aria-label="Next">
                        <span>Próximo</span>
                        <span aria-hidden="true" class="material-icons">chevron_right</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="" aria-label="Next">
                        <span>Próximo</span>
                        <span aria-hidden="true" class="material-icons">chevron_right</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif

<p style="font-size: 12px; text-align:center">
    {!! __('Exibindo') !!}
    <span class="font-medium">{{ $paginator->firstItem() }}</span>
    {!! __('a') !!}
    <span class="font-medium">{{ $paginator->lastItem() }}</span>
    {!! __('de') !!}
    <span class="font-medium">{{ $paginator->total() }} Cursos</span>
</p>
