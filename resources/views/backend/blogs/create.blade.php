@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header">
        <h1>Blogs</h1>
        <p>Create a new blog post</p>
    </div>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

            {{-- ── LEFT COLUMN: main content ── --}}
            <div class="col-lg-8">

                {{-- Success --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Basic Info --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title">
                            <i class="fas fa-pen-nib"></i> Basic Information
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">

                            {{-- Title --}}
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label" for="title">
                                        Blog Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           class="f-input @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}"
                                           placeholder="e.g. Top 10 Tips for Better Coding">
                                    @error('title')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label" for="category_id">
                                        Category <span class="text-danger">*</span>
                                    </label>
                                    <select name="category_id"
                                            id="category_id"
                                            class="f-input @error('category_id') is-invalid @enderror">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label" for="status">Status</label>
                                    <select name="status"
                                            id="status"
                                            class="f-input @error('status') is-invalid @enderror">
                                        <option value="draft"      {{ old('status', 'draft') === 'draft'     ? 'selected' : '' }}>Draft</option>
                                        <option value="published"  {{ old('status') === 'published'          ? 'selected' : '' }}>Published</option>
                                        <option value="archived"   {{ old('status') === 'archived'           ? 'selected' : '' }}>Archived</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Short Description --}}
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label" for="short_description">
                                        Short Description <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="short_description"
                                              id="short_description"
                                              rows="3"
                                              class="f-input @error('short_description') is-invalid @enderror"
                                              placeholder="A brief summary shown in blog listings...">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Full Description (CKEditor 5) --}}
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label" for="description">
                                        Full Content
                                    </label>
                                    {{-- Hidden textarea that CKEditor writes its HTML into on submit --}}
                                    <textarea name="description"
                                              id="description"
                                              class="@error('description') is-invalid @enderror"
                                              style="display:none;">{{ old('description') }}</textarea>
                                    {{-- CKEditor mounts here --}}
                                    <div id="description-editor"
                                         class="@error('description') border border-danger rounded @enderror"
                                         style="min-height: 350px;">
                                        {!! old('description') !!}
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback d-block mt-1">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title">
                            <i class="fas fa-search"></i> SEO Settings
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">

                            {{-- Meta Title --}}
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label" for="meta_title">Meta Title</label>
                                    <input type="text"
                                           name="meta_title"
                                           id="meta_title"
                                           class="f-input @error('meta_title') is-invalid @enderror"
                                           value="{{ old('meta_title') }}"
                                           placeholder="SEO title (leave blank to use blog title)">
                                    @error('meta_title')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Meta Description --}}
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label" for="meta_description">Meta Description</label>
                                    <textarea name="meta_description"
                                              id="meta_description"
                                              rows="2"
                                              class="f-input @error('meta_description') is-invalid @enderror"
                                              placeholder="Short description for search engines (150–160 characters)...">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Meta Keywords --}}
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label" for="meta_keywords">Meta Keywords</label>
                                    <input type="text"
                                           name="meta_keywords"
                                           id="meta_keywords"
                                           class="f-input @error('meta_keywords') is-invalid @enderror"
                                           value="{{ old('meta_keywords') }}"
                                           placeholder="e.g. laravel, php, web development">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>{{-- /col-lg-8 --}}

            {{-- ── RIGHT COLUMN: sidebar ── --}}
            <div class="col-lg-4">

                {{-- Featured Image --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title">
                            <i class="fas fa-image"></i> Featured Image
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <div class="f-group">
                            <label class="f-label" for="featured_image">Upload Image</label>

                            {{-- Preview box --}}
                            <div id="image-preview-wrapper"
                                 style="display:none; margin-bottom: 0.75rem;">
                                <img id="image-preview"
                                     src="#"
                                     alt="Preview"
                                     style="width:100%; border-radius:8px; object-fit:cover; max-height:200px;">
                            </div>

                            <input type="file"
                                   name="featured_image"
                                   id="featured_image"
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp"
                                   class="f-input @error('featured_image') is-invalid @enderror"
                                   onchange="previewImage(event)">

                            <small class="text-muted d-block mt-1">
                                Accepted: jpeg, png, jpg, gif, svg, webp &bull; Max: 2 MB
                            </small>

                            @error('featured_image')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Publish Actions --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title">
                            <i class="fas fa-paper-plane"></i> Publish
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn-gold-sm">
                                <i class="fas fa-plus me-1"></i> Create Blog
                            </button>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>

            </div>{{-- /col-lg-4 --}}

        </div>{{-- /row --}}
    </form>
</div>


    {{-- CKEditor 5 (Classic build via CDN) --}}
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">



{{-- CKEditor 5 Classic build --}}
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

<script>
    const { ClassicEditor, Essentials, Bold, Italic, Underline, Strikethrough,
            Subscript, Superscript, BlockQuote, Heading, Link, List, ListProperties,
            Paragraph, Alignment, FontColor, FontBackgroundColor, FontSize, FontFamily,
            Image, ImageCaption, ImageStyle, ImageToolbar, ImageUpload,
            Table, TableToolbar, TableProperties, TableCellProperties,
            Indent, IndentBlock, CodeBlock, HorizontalLine, HtmlEmbed,
            SourceEditing, MediaEmbed, RemoveFormat, SpecialCharacters,
            SpecialCharactersEssentials, WordCount } = CKEDITOR;

    ClassicEditor
        .create(document.getElementById('description-editor'), {
            plugins: [
                Essentials, Bold, Italic, Underline, Strikethrough,
                Subscript, Superscript, BlockQuote, Heading, Link,
                List, ListProperties, Paragraph, Alignment,
                FontColor, FontBackgroundColor, FontSize, FontFamily,
                Image, ImageCaption, ImageStyle, ImageToolbar,
                Table, TableToolbar, TableProperties, TableCellProperties,
                Indent, IndentBlock, CodeBlock, HorizontalLine,
                SourceEditing, MediaEmbed, RemoveFormat,
                SpecialCharacters, SpecialCharactersEssentials, WordCount,
            ],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'codeBlock', 'horizontalLine', 'specialCharacters', '|',
                    'removeFormat', 'sourceEditing', '|',
                    'undo', 'redo',
                ],
                shouldNotGroupWhenFull: true,
            },
            heading: {
                options: [
                    { model: 'paragraph',  title: 'Paragraph',  class: 'ck-heading_paragraph' },
                    { model: 'heading1',   view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2',   view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3',   view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4',   view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                ],
            },
            image: {
                toolbar: ['imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                          'toggleImageCaption', 'imageTextAlternative'],
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells',
                                 'tableProperties', 'tableCellProperties'],
            },
            list: {
                properties: { styles: true, startIndex: true, reversed: true },
            },
        })
        .then(editor => {
            // Sync CKEditor content → hidden textarea before form submits
            editor.model.document.on('change:data', () => {
                document.getElementById('description').value = editor.getData();
            });

            // Also sync on form submit (safety net)
            document.querySelector('form').addEventListener('submit', () => {
                document.getElementById('description').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('CKEditor init error:', error);
        });

    // ── Image preview ──────────────────────────────────────────────
    function previewImage(event) {
        const wrapper = document.getElementById('image-preview-wrapper');
        const preview = document.getElementById('image-preview');
        const file    = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            wrapper.style.display = 'block';
        } else {
            wrapper.style.display = 'none';
        }
    }
</script>


@endsection
