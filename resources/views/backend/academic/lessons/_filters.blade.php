<form class="ac-filters" data-filter-for="{{ $target }}">
    <div class="row g-2">
        @if($withSearch ?? true)
            <div class="col-lg-3 col-md-6"><input type="search" name="search" value="{{ request('search') }}" class="f-input" placeholder="Lesson name…"></div>
        @endif
        <div class="col-lg-2 col-md-6 col-6"><select name="teacher_id" class="f-input"><option value="">All teachers</option>@foreach($teachers as $t)<option value="{{ $t->id }}" @selected(request('teacher_id') == $t->id)>{{ $t->full_name }}</option>@endforeach</select></div>
        <div class="col-lg-2 col-md-4 col-6"><select name="branch_id" class="f-input"><option value="">All branches</option>@foreach($branches as $b)<option value="{{ $b->id }}" @selected(request('branch_id') == $b->id)>{{ $b->name }}</option>@endforeach</select></div>
        <div class="col-lg-1 col-md-4 col-6"><select name="subject_id" class="f-input"><option value="">Subject</option>@foreach($subjects as $s)<option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-lg-1 col-md-4 col-6"><select name="level_id" class="f-input"><option value="">Level</option>@foreach($levels as $l)<option value="{{ $l->id }}" @selected(request('level_id') == $l->id)>{{ $l->name }}</option>@endforeach</select></div>
        @if($withWeekday ?? true)
            <div class="col-lg-1 col-md-4 col-6"><select name="weekday" class="f-input"><option value="">Day</option>@foreach(\App\Models\Lesson::WEEKDAYS as $k => $d)<option value="{{ $k }}" @selected(request()->filled('weekday') && request('weekday') == $k)>{{ $d }}</option>@endforeach</select></div>
        @else
            <div class="col-lg-2 col-md-4 col-6"><select name="classroom_id" class="f-input"><option value="">All classrooms</option>@foreach($classrooms as $c)<option value="{{ $c->id }}" @selected(request('classroom_id') == $c->id)>{{ $c->label }}</option>@endforeach</select></div>
        @endif
        <div class="col-lg-1 col-md-4 col-6"><select name="type" class="f-input"><option value="">Type</option><option value="group" @selected(request('type') == 'group')>Group</option><option value="one_to_one" @selected(request('type') == 'one_to_one')>1-to-1</option></select></div>
        <div class="col-lg-1 col-md-4 col-6"><select name="active" class="f-input"><option value="">{{ ($withWeekday ?? true) ? 'Any' : 'Active' }}</option><option value="yes" @selected(request('active') == 'yes')>Active</option><option value="no" @selected(request('active') == 'no')>Inactive</option></select></div>
        <div class="col-lg-1 col-md-4 col-6"><button class="btn-outline-sm w-100 justify-content-center" data-reset><i class="fas fa-undo"></i></button></div>
    </div>
</form>
