@extends('layouts.app')
@section('content')

<div class="df-page-header">
    <h1 class="df-page-title">All Categories</h1>
    <div class="d-flex align-items-center gap-3">
        <nav class="df-breadcrumb d-none d-md-flex">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator"><i class="bi bi-chevron-right"></i></span>
            <span class="current">Categories</span>
        </nav>
        <a href="{{ route('admin.categories.create') }}" class="df-btn df-btn-primary">
            <i class="bi bi-plus-lg"></i> Add Category
        </a>
    </div>
</div>

@if(session('success'))
    <div class="df-alert df-alert-success">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

<div class="df-card">
    <div class="df-card-header">
        <h5 class="df-card-title"><i class="bi bi-folder2-open"></i> Category List</h5>
        <span class="df-badge df-badge-muted">{{ $categories->count() }} categories</span>
    </div>
    <div class="df-card-body-flush">
        <div class="table-responsive">
            <table class="df-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Products</th>
                        <th>Subcategories</th>
                        <th style="width:130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" class="df-product-img" alt="{{ $category->name }}">
                                @else
                                    <div class="df-product-img-placeholder">
                                        <i class="bi bi-folder"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}" style="font-weight:600; text-decoration:none;">
                                    {{ $category->name }}
                                </a>
                                @if($category->description)
                                    <div class="df-product-desc">{{ Str::limit($category->description, 40) }}</div>
                                @endif
                            </td>
                            <td><code style="font-size:0.82rem; color:var(--df-text-secondary);">{{ $category->slug }}</code></td>
                            <td>
                                @if($category->parent)
                                    <span class="df-badge df-badge-info">{{ $category->parent->name }}</span>
                                @else
                                    <span style="color:var(--df-text-muted);">Root</span>
                                @endif
                            </td>
                            <td><span class="df-badge df-badge-primary">{{ $category->products_count ?? $category->products->count() }}</span></td>
                            <td><span class="df-badge df-badge-muted">{{ $category->children->count() }}</span></td>
                            <td>
                                <div class="df-actions">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="df-action-btn info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="df-action-btn warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                          style="display:inline" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="df-action-btn danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="df-empty-state">
                                    <div class="empty-icon"><i class="bi bi-folder2-open"></i></div>
                                    <p>No categories yet. <a href="{{ route('admin.categories.create') }}">Create your first category</a></p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection