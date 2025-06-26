<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center mb-0">
    <!-- Previous Page -->
    <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
      <a class="page-link" href="{{ $paginator->previousPageUrl() ?? 'javascript:void(0)' }}" aria-label="Previous">
        <i class="bi bi-chevron-left"></i>
      </a>
    </li>

    <!-- Page Numbers -->
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="page-item disabled">
          <span class="page-link">{{ $element }}</span>
        </li>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach
      @endif
    @endforeach

    <!-- Next Page -->
    <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
      <a class="page-link" href="{{ $paginator->nextPageUrl() ?? 'javascript:void(0)' }}" aria-label="Next">
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
  </ul>
</nav>

<style>
.pagination {
  margin-bottom: 0;
}

.page-link {
  color: #667eea;
  border: 1px solid #dee2e6;
  padding: 0.5rem 0.75rem;
  transition: all 0.3s ease;
}

.page-link:hover {
  color: #fff;
  background-color: #667eea;
  border-color: #667eea;
  transform: translateY(-1px);
}

.page-item.active .page-link {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-color: #667eea;
  color: white;
}

.page-item.disabled .page-link {
  color: #6c757d;
  background-color: #fff;
  border-color: #dee2e6;
  cursor: not-allowed;
}

.page-item.disabled .page-link:hover {
  transform: none;
  background-color: #fff;
  color: #6c757d;
  border-color: #dee2e6;
}
</style>