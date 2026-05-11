@extends('layouts.backend')
@section('content')
    <div class="container">
        <div class="page-header d-flex align-items-start justify-content-between">
            <div>
                <h1>Students</h1>
                <p>Manage all enrolled and charity-funded students</p>
            </div>
            <button class="btn-gold-sm" onclick="openModal('add-student')"><i class="fas fa-plus"></i>Add Student</button>
        </div>
        <!-- Filter Bar -->
        {{-- <div class="card mb-4">
          <div class="card-body-custom pt-3">
            <div class="row g-3 align-items-end">
              <div class="col-md-3"><div class="f-group mb-0"><label class="f-label">Search</label><div style="position:relative"><i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.78rem"></i><input type="text" class="f-input" placeholder="Name, email..." style="padding-left:34px"></div></div></div>
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Level</label><select class="f-select"><option>All Levels</option><option>Beginner/Qaida</option><option>Quran Reading</option><option>Tajweed</option><option>Hifz</option></select></div></div>
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Status</label><select class="f-select"><option>All Status</option><option>Active</option><option>Trial</option><option>Inactive</option><option>Charity-funded</option></select></div></div>
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Tutor</label><select class="f-select"><option>All Tutors</option><option>Ustadh Bilal</option><option>Ustadha Fatima</option><option>Ustadh Hassan</option></select></div></div>
              <div class="col-md-3 d-flex gap-2"><button class="btn-prim" style="flex:1"><i class="fas fa-filter"></i>Filter</button><button class="btn-outline-sm"><i class="fas fa-download"></i>Export</button></div>
            </div>
          </div>
        </div> --}}
        <div class="card">
            <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-user-graduate"></i>All Contact Message <span
                        style="font-size:.72rem;background:var(--bg);color:var(--muted);padding:3px 10px;border-radius:20px;margin-left:8px;font-weight:600">124
                        total</span></div>
                {{-- <div class="tab-bar" style="margin:0;width:auto">
                    <button class="tab-btn active" style="padding:6px 16px;font-size:.72rem">All</button>
                    <button class="tab-btn" style="padding:6px 16px;font-size:.72rem">Paying</button>
                    <button class="tab-btn" style="padding:6px 16px;font-size:.72rem">Charity</button>
                </div> --}}
            </div>
            <div class="card-body-custom">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" style="accent-color:var(--gold)"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                 <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactMessages as $item)
                                <tr>
                                    <td><input type="checkbox" style="accent-color:var(--gold)"></td>
                                    <td><div style="font-weight:600;font-size:.82rem">{{ $item->first_name }} {{ $item->last_name }}</div></td>
                                    <td><span style="font-size:.82rem">{{ $item->email }}</span></td>
                                    <td><span style="font-size:.78rem">{{ $item->phone }}</span></td>
                                    <td><span style="font-size:.78rem">{{ $item->subject }}</span></td>
                                    <td><span style="font-size:.78rem">{{ Str::limit($item->message, 100) }}</span></td>
                                    <td><span
                                            class="badge-status bs-${s.status==='active'?'active':s.status==='new'?'new':'pending'}"><span
                                                class="bs-dot"></span>${s.status==='active'?'Active':s.status==='new'?'New':'Trial'}</span>
                                    </td>
                                    <td><span style="font-size:.72rem;color:var(--muted)">18 Nov</span></td>
                                    <td>
                                        <div class="d-flex gap-1"><button class="btn-outline-sm"
                                                style="padding:4px 10px;font-size:.68rem" onclick="openModal('student')"><i
                                                    class="fas fa-eye"></i></button><button class="btn-outline-sm"
                                                style="padding:4px 10px;font-size:.68rem"><i
                                                    class="fas fa-edit"></i></button><button class="btn-danger-sm"
                                                style="padding:4px 10px;font-size:.68rem"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-3 pt-2"
                    style="border-top:1px solid var(--border)">
                    <span style="font-size:.75rem;color:var(--muted)">Showing 1–10 of 124 students</span>
                    <div class="d-flex gap-2">
                        <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem"><i
                                class="fas fa-chevron-left"></i></button>
                        <button class="btn-prim" style="padding:6px 14px;font-size:.72rem">1</button>
                        <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem">2</button>
                        <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem">3</button>
                        <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem"><i
                                class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
