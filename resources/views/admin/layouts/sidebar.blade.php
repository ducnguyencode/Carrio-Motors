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

                    <!-- Resources -->
                    <li class="nav-header">RESOURCES</li>

                    @if(auth()->user()->hasRole(['admin', 'content']))
                    <!-- Social Media Links -->
                    <li class="nav-item">
                        <a href="{{ route('admin.social-media.index') }}" class="nav-link {{ Request::is('admin/social-media*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-share-alt"></i>
                            <p>Social Media</p>
                        </a>
                    </li>
                    @endif
