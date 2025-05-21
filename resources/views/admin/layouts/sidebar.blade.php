<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/invoices*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">
        <i class="bi bi-receipt me-2"></i>
        Invoices
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/blog*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
        <i class="bi bi-newspaper me-2"></i>
        Blog
    </a>
</li>
