@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-start-pill px-4">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-start-pill px-4" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link border-0">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link bg-primary border-primary">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-end-pill px-4" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-end-pill px-4">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    {{-- Result Info --}}
    <div class="text-center mt-3">
        <p class="text-muted small mb-0">
            Showing
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            to
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            of
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            results
        </p>
    </div>

    <style>
        .pagination {
            gap: 0.25rem;
        }

        .page-link {
            color: #495057;
            border: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .page-link:hover {
            color: #0d6efd;
            background-color: #e9ecef;
            border-color: #dee2e6;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.3);
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .page-item:first-child .page-link {
            border-radius: 50rem 0.375rem 0.375rem 50rem;
        }

        .page-item:last-child .page-link {
            border-radius: 0.375rem 50rem 50rem 0.375rem;
        }

        @media (max-width: 576px) {
            .pagination {
                font-size: 0.875rem;
            }

            .page-link {
                padding: 0.375rem 0.75rem;
            }
        }
    </style>
@endif
