@extends('layouts.frontend')
@section('content')
  <div class="article-hero">
    <div class="container position-relative" style="z-index:2">
      <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ url('/news') }}"><span style="font-size:.75rem;color:rgba(255,255,255,.4);display:flex;align-items:center;gap:8px;cursor:pointer" onclick="showPage('news')"><i class="fas fa-arrow-left" style="color:var(--gold)"></i>Back to News</span></a>
        <i class="fas fa-chevron-right" style="font-size:.55rem;color:rgba(255,255,255,.2)"></i>
        <span style="font-size:.75rem;color:rgba(255,255,255,.4)">Blogs</span>
      </div>
      <div class="article-cat"><i class="fas fa-star"></i>{{ $blog->category->category_name }}</div>
      <h1 class="article-h1">{{ $blog->title }}</h1>
      <div class="article-meta-bar">
        <div class="am-item"><i class="fas fa-calendar"></i><strong>{{ $blog->created_at->format('d M Y') }}</strong></div>
        <div class="am-item"><i class="fas fa-user"></i><strong>Admin</strong></div>
       
      </div>
    </div>
  </div>

  <section style="padding:60px 0 100px;background:var(--cream)">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-8">

          <!-- Article Body -->
          <div class="article-content" data-r="up">
            
            {!! $blog->description !!}
          </div>

          <!-- Tags -->
          {{-- <div class="mt-4" data-r="up">
            <p style="font-size:.7rem;font-weight:700;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:12px">Tags</p>
            @foreach ($blog->tags as $tag)
                <span class="tag-article"><i class="fas fa-tag"></i>{{ $tag->name }}</span>
            @endforeach

          
          </div> --}}

          <!-- Author -->
          

          <!-- Related -->
          <div class="mt-5" data-r="up">
            <h4 class="serif" style="font-size:1.4rem;font-weight:700;color:var(--navy);margin-bottom:24px">Related Articles</h4>
            <div class="row g-3">
              @foreach ($recentBlogs as $item)
              <div class="col-md-4">
                <a href="{{ url('news/' . $item->slug) }}"><div class="related-card"><div class="related-img" style="background:linear-gradient(135deg,var(--teal),var(--navy))"><i class="fas fa-heart" style="font-size:2.5rem;color:rgba(255,255,255,.12)"></i></div><div class="related-body"><div class="related-cat">Impact</div><div class="related-h">Fatima's Story: From Orphan to Medical Student</div></div></div></div></a>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Sticky Sidebar -->
        <div class="col-lg-4">
          <div style="position:sticky;top:100px">
            <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));border-radius:16px;padding:28px 22px;position:relative;overflow:hidden">
              <div style="position:absolute;inset:0;background:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.025'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E\")"></div>
              <div style="position:relative">
                <i class="fas fa-heart" style="font-size:1.5rem;color:var(--gold);margin-bottom:14px;display:block"></i>
                <h5 class="serif" style="font-size:1.2rem;color:var(--white);margin-bottom:10px">Support Quran Education</h5>
                <p style="font-size:.78rem;color:rgba(255,255,255,.45);margin-bottom:18px;line-height:1.65">Your generous donation helps provide quality Quran lessons, Islamic education, and learning resources for students of all ages.</p>
                {{-- <a href="{{ url('donate') }}" class="btn-gold" style="width:100%;justify-content:center"><i class="fas fa-heart"></i>Book Lesson Now</a> --}}
                <a href="{{ url('book-lesson') }}" class="btn-outline-white" style="width:100%;justify-content:center;margin-top:10px;font-size:.72rem;padding:10px">Book a Lesson</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection