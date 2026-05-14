@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1>Blogs</h1>
            <p>All blog posts listed below</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="btn-gold-sm">
            <i class="fas fa-plus"></i> New Blog
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table class="data-table" id="blogsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($blog->featured_image)
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                         alt="{{ $blog->title }}"
                                         style="width:52px; height:40px; object-fit:cover; border-radius:6px;">
                                @else
                                    <div style="width:52px; height:40px; border-radius:6px;
                                                background:#f0f0f0; display:flex;
                                                align-items:center; justify-content:center;
                                                color:#aaa; font-size:18px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $blog->title }}</strong>
                                <br>
                                <small class="text-muted">{{ $blog->slug }}</small>
                            </td>
                            <td>
                                {{ $blog->category->name ?? '—' }}
                            </td>
                            <td>
                                @php
                                    $statusMap = [
                                        'published' => ['class' => 'badge bg-success', 'label' => 'Published'],
                                        'draft'     => ['class' => 'badge bg-secondary', 'label' => 'Draft'],
                                        'archived'  => ['class' => 'badge bg-warning text-dark', 'label' => 'Archived'],
                                    ];
                                    $s = $statusMap[$blog->status] ?? ['class' => 'badge bg-secondary', 'label' => ucfirst($blog->status)];
                                @endphp
                                <span class="{{ $s['class'] }}">{{ $s['label'] }}</span>
                            </td>
                            <td>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('d M Y') : '—' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- View --}}
                                    <a href=""
                                       class="btn-outline-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                       class="btn-outline-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this blog?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-sm" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No blog posts found.
                                <a href="{{ route('admin.blogs.create') }}">Create your first one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">



    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#blogsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [1, 6] }, // Image & Actions not sortable
                    { searchable: false, targets: [1, 6] }, // Image & Actions not searchable
                ],
                language: {
                    search:         '',
                    searchPlaceholder: 'Search blogs...',
                    lengthMenu:     'Show _MENU_ entries',
                    info:           'Showing _START_ to _END_ of _TOTAL_ blogs',
                    infoEmpty:      'No blogs found',
                    infoFiltered:   '(filtered from _MAX_ total)',
                    paginate: {
                        first:    '«',
                        last:     '»',
                        next:     '›',
                        previous: '‹',
                    },
                    emptyTable: 'No blog posts available',
                },
            });
        });
    </script>
@endsection