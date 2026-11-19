@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => 'Parents', 'subtitle' => 'Parents / guardians and their children',
    'actions' => '<a href="' . route('admin.parents.create') . '" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Parent</a>',
])
<div class="card mb-3">
    <form class="ac-filters" data-filter-for="#parents-table">
        <div class="row g-2">
            <div class="col-md-6"><input type="search" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search name, phone or email…"></div>
            <div class="col-md-3 col-6">
                <select name="relationship" class="f-input"><option value="">Any relationship</option>
                    @foreach(\App\Models\Guardian::RELATIONSHIPS as $k => $v)<option value="{{ $k }}" @selected(request('relationship') == $k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2 col-4">
                <select name="status" class="f-input"><option value="">Any status</option><option value="active" @selected(request('status') == 'active')>Active</option><option value="inactive" @selected(request('status') == 'inactive')>Inactive</option></select>
            </div>
            <div class="col-md-1 col-2"><button class="btn-outline-sm w-100 justify-content-center" data-reset><i class="fas fa-undo"></i></button></div>
        </div>
    </form>
</div>
<div class="card" id="parents-table" data-ajax-table data-url="{{ route('admin.parents.index') }}">
    @include('backend.academic.parents._table')
</div>
@endsection
