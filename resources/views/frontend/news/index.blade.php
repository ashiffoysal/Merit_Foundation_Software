@extends('layouts.frontend')
@section('title', 'News - Merit Education Foundation')
@section('content')


<style>
  * ════════════════════════════════════════
   PAGE HEROES (shared)
════════════════════════════════════════ */
.page-hero{padding:145px 0 75px;background:var(--dark);position:relative;overflow:hidden}
.page-hero {
    padding-top: 136px;
    padding-bottom: 100px;
}
.page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 80% at 50% 40%,rgba(26,46,122,.85),transparent 65%)}
.page-hero::after{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);background-size:64px 64px}
.ph-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.28);border-radius:30px;padding:6px 18px;margin-bottom:18px;position:relative;z-index:1}
.ph-badge span{font-size:.68rem;color:var(--gold);letter-spacing:2.5px;text-transform:uppercase;font-weight:600}
.ph-h{font-family:'Cormorant Garamond',serif;font-size:clamp(2.4rem,5.5vw,4rem);font-weight:700;color:var(--white);line-height:1;position:relative;z-index:1}
.ph-h em{font-style:italic;color:var(--gold)}
.ph-p{font-size:.95rem;color:rgba(255,255,255,.48);line-height:1.8;font-weight:300;position:relative;z-index:1;max-width:530px;margin-top:14px}
* ════════════════════════════════════════
   NEWS PAGE
════════════════════════════════════════ */
.news-filter-bar{background:var(--white);border-bottom:1px solid var(--border);position:sticky;top:70px;z-index:800;padding:16px 0}
.filter-pill{display:inline-flex;align-items:center;gap:7px;padding:8px 18px;border-radius:30px;border:1.5px solid var(--border);font-size:.73rem;font-weight:600;letter-spacing:1px;cursor:pointer;transition:.3s;background:transparent;color:var(--muted)}
.filter-pill:hover,.filter-pill.active{background:var(--navy);color:var(--white);border-color:var(--navy)}
.filter-pill.active-gold{background:var(--gold);color:var(--navy);border-color:var(--gold)}
.search-wrap{position:relative;max-width:280px}
.search-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.82rem;pointer-events:none}
.search-wrap input{padding:10px 14px 10px 38px;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:.82rem;color:var(--txt);background:var(--cream);outline:none;transition:.3s;width:100%}
.search-wrap input:focus{border-color:var(--gold);background:var(--white)}

/* Featured Article */
.news-featured{background:linear-gradient(160deg,var(--navy) 0%,var(--navy2) 100%);border-radius:20px;padding:52px 48px;position:relative;overflow:hidden;cursor:pointer;transition:.35s}
.news-featured:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg)}
.news-featured::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.025'%3E%3Cpath d='M30 0L60 30L30 60L0 30z'/%3E%3C/g%3E%3C/svg%3E")}
.news-featured>*{position:relative;z-index:1}
.nf-cat{display:inline-flex;align-items:center;gap:7px;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.3);border-radius:20px;padding:5px 14px;font-size:.65rem;color:var(--gold);letter-spacing:2px;text-transform:uppercase;font-weight:700;margin-bottom:16px}
.nf-h{font-family:'Cormorant Garamond',serif;font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:700;color:var(--white);line-height:1.1;margin-bottom:14px}
.nf-p{font-size:.88rem;color:rgba(255,255,255,.58);line-height:1.8;max-width:600px;margin-bottom:24px;font-weight:300}
.nf-meta{display:flex;align-items:center;gap:20px;flex-wrap:wrap}
.nf-meta-item{display:flex;align-items:center;gap:7px;font-size:.73rem;color:rgba(255,255,255,.42)}
.nf-meta-item i{color:var(--gold);font-size:.65rem}
.nf-img{position:absolute;right:0;top:0;bottom:0;width:38%;object-fit:cover;opacity:.15;mask-image:linear-gradient(to left,rgba(0,0,0,.8),transparent)}

/* News Card */
.news-card{background:var(--white);border:1px solid var(--border);border-radius:var(--r);overflow:hidden;transition:all .4s;cursor:pointer;height:100%}
.news-card:hover{transform:translateY(-8px);box-shadow:var(--shadow-lg);border-color:rgba(201,168,76,.3)}
.news-card-img{height:200px;background:var(--light);position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center}
.news-card-img-bg{position:absolute;inset:0;transition:transform .5s cubic-bezier(.16,1,.3,1)}
.news-card:hover .news-card-img-bg{transform:scale(1.06)}
.news-card-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(15,31,92,.6),transparent)}
.nc-cat-tag{position:absolute;top:14px;left:14px;background:var(--gold);color:var(--navy);font-size:.6rem;font-weight:800;letter-spacing:2px;text-transform:uppercase;padding:4px 12px;border-radius:20px;z-index:1}
.nc-read-time{position:absolute;bottom:14px;right:14px;background:rgba(0,0,0,.5);color:rgba(255,255,255,.8);font-size:.65rem;padding:4px 10px;border-radius:20px;display:flex;align-items:center;gap:5px;z-index:1}
.news-card-body{padding:24px 22px}
.nc-date{font-size:.68rem;color:var(--muted);letter-spacing:1px;margin-bottom:10px;display:flex;align-items:center;gap:8px}
.nc-date::before{content:'';width:18px;height:1px;background:var(--gold)}
.nc-h{font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:700;color:var(--navy);margin-bottom:10px;line-height:1.3;transition:.3s}
.news-card:hover .nc-h{color:var(--gold)}
.nc-p{font-size:.8rem;color:var(--muted);line-height:1.75;margin-bottom:18px}
.nc-footer{display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--border)}
.nc-author{display:flex;align-items:center;gap:8px}
.nc-av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;font-family:'Cormorant Garamond',serif;color:var(--white);flex-shrink:0}
.nc-author-name{font-size:.72rem;font-weight:600;color:var(--txt)}
.nc-read-more{font-size:.7rem;font-weight:700;color:var(--gold);letter-spacing:1px;text-transform:uppercase;display:flex;align-items:center;gap:5px;transition:.3s}
.nc-read-more i{font-size:.6rem;transition:transform .3s}
.news-card:hover .nc-read-more i{transform:translateX(4px)}

/* Pagination */
.pag-btn{width:40px;height:40px;border:1.5px solid var(--border);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.82rem;font-weight:600;cursor:pointer;transition:.3s;color:var(--muted)}
.pag-btn:hover,.pag-btn.active{border-color:var(--navy);background:var(--navy);color:var(--white)}
.pag-btn.active{background:var(--gold);border-color:var(--gold);color:var(--navy)}

/* Sidebar */
.sidebar-widget{background:var(--white);border:1px solid var(--border);border-radius:var(--r);padding:26px 22px;margin-bottom:22px}
.sw-title{font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-weight:700;color:var(--navy);margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.recent-item{display:flex;gap:12px;align-items:flex-start;margin-bottom:16px;cursor:pointer;transition:.3s;padding:8px;border-radius:8px}
.recent-item:hover{background:var(--cream)}
.ri-img{width:56px;height:56px;border-radius:9px;background:var(--light);flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden}
.ri-date{font-size:.65rem;color:var(--muted);margin-bottom:4px}
.ri-h{font-size:.78rem;font-weight:600;color:var(--navy);line-height:1.4;transition:.3s}
.recent-item:hover .ri-h{color:var(--gold)}
.cat-item{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:8px;cursor:pointer;transition:.3s;margin-bottom:6px}
.cat-item:hover{background:var(--cream)}
.cat-name{font-size:.82rem;font-weight:500;color:var(--txt)}
.cat-count{background:var(--light);color:var(--muted);font-size:.68rem;font-weight:700;padding:3px 9px;border-radius:20px}
.tag-cloud{display:flex;flex-wrap:wrap;gap:8px}
.tag{padding:6px 14px;border:1px solid var(--border);border-radius:20px;font-size:.72rem;color:var(--muted);cursor:pointer;transition:.3s}
.tag:hover{border-color:var(--gold);color:var(--gold)}

/* ════════════════════════════════════════
   NEWS DETAIL PAGE
════════════════════════════════════════ */
.article-hero{padding:145px 0 60px;background:var(--dark);position:relative;overflow:hidden}
.article-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 90% 80% at 40% 60%,rgba(26,46,122,.9),transparent 60%),radial-gradient(ellipse 50% 50% at 80% 20%,rgba(201,168,76,.06),transparent)}
.article-hero::after{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);background-size:64px 64px}
.article-cat{display:inline-flex;align-items:center;gap:7px;background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.28);border-radius:20px;padding:5px 16px;font-size:.65rem;color:var(--gold);letter-spacing:2px;text-transform:uppercase;font-weight:700;margin-bottom:16px;position:relative;z-index:1}
.article-h1{font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,5vw,3.6rem);font-weight:700;color:var(--white);line-height:1.05;position:relative;z-index:1;max-width:760px}
.article-meta-bar{display:flex;align-items:center;gap:24px;flex-wrap:wrap;margin-top:22px;padding-top:22px;border-top:1px solid rgba(255,255,255,.08);position:relative;z-index:1}
.am-item{display:flex;align-items:center;gap:8px;font-size:.73rem;color:rgba(255,255,255,.4)}
.am-item i{color:var(--gold);font-size:.65rem}
.am-item strong{color:rgba(255,255,255,.72);font-weight:600}
.article-share{display:flex;align-items:center;gap:8px;margin-left:auto}
.share-btn{width:32px;height:32px;border:1px solid rgba(255,255,255,.15);border-radius:7px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.4);font-size:.75rem;cursor:pointer;transition:.3s}
.share-btn:hover{border-color:var(--gold);color:var(--gold)}

.article-content{font-size:.95rem;color:var(--txt);line-height:1.9;font-weight:300}
.article-content h2{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:var(--navy);margin:40px 0 16px}
.article-content h3{font-family:'Cormorant Garamond',serif;font-size:1.35rem;font-weight:700;color:var(--navy);margin:30px 0 12px}
.article-content p{margin-bottom:20px}
.article-content blockquote{background:var(--cream);border-left:4px solid var(--gold);border-radius:0 12px 12px 0;padding:24px 28px;margin:32px 0;font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-style:italic;color:var(--navy)}
.article-content ul,.article-content ol{padding-left:22px;margin-bottom:20px}
.article-content li{margin-bottom:9px;line-height:1.75}
.article-content strong{color:var(--navy);font-weight:700}
.article-content .highlight-box{background:var(--navy);color:var(--white);border-radius:14px;padding:28px 32px;margin:32px 0}
.article-content .highlight-box h4{font-family:'Cormorant Garamond',serif;font-size:1.2rem;color:var(--gold);margin-bottom:10px}
.article-content .highlight-box p{color:rgba(255,255,255,.65);font-size:.88rem;margin:0}

.article-image-block{border-radius:16px;overflow:hidden;background:linear-gradient(135deg,var(--navy),var(--navy2));height:300px;display:flex;align-items:center;justify-content:center;margin:32px 0;position:relative}
.article-image-block::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.03'%3E%3Cpath d='M30 0L60 30L30 60L0 30z'/%3E%3C/g%3E%3C/svg%3E")}
.article-image-caption{font-size:.75rem;color:var(--muted);text-align:center;margin-top:-20px;margin-bottom:32px;font-style:italic}

.tag-article{display:inline-flex;align-items:center;gap:6px;background:var(--cream);border:1px solid var(--border);border-radius:20px;padding:5px 14px;font-size:.7rem;color:var(--muted);cursor:pointer;transition:.3s;margin:4px}
.tag-article:hover{border-color:var(--gold);color:var(--gold)}

.author-card{background:var(--cream);border:1px solid var(--border);border-radius:16px;padding:28px 24px;display:flex;gap:20px;align-items:flex-start}
.author-av-lg{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:var(--white);flex-shrink:0}
.author-name-lg{font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:700;color:var(--navy);margin-bottom:4px}
.author-role{font-size:.73rem;color:var(--gold);letter-spacing:1px;text-transform:uppercase;margin-bottom:10px}
.author-bio{font-size:.8rem;color:var(--muted);line-height:1.7;margin:0}

.related-card{background:var(--white);border:1px solid var(--border);border-radius:var(--r);overflow:hidden;transition:.35s;cursor:pointer}
.related-card:hover{transform:translateY(-5px);box-shadow:var(--shadow-md)}
.related-img{height:160px;background:linear-gradient(135deg,var(--navy),var(--navy2));display:flex;align-items:center;justify-content:center;position:relative}
.related-body{padding:18px 16px}
.related-cat{font-size:.62rem;font-weight:700;color:var(--gold);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:7px}
.related-h{font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:700;color:var(--navy);line-height:1.3}
</style>
<div class="">
  <!-- Hero -->
  <div class="page-hero" style="background:linear-gradient(160deg,var(--dark) 0%,var(--navy2) 100%)">
    <div class="page-hero::after" style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);background-size:64px 64px"></div>
    <div class="container position-relative" style="z-index:2">
      <div class="ph-badge"><span>Latest News</span></div>
      <h1 class="ph-h">News &amp; <em>Impact Stories</em></h1>
      <p class="ph-p">Stay informed on our programmes, student success stories, charity updates and educational insights from around the world.</p>
    </div>
  </div>

  <!-- Filter Bar -->
  {{-- <div class="news-filter-bar" id="filter-bar">
    <div class="container">
      <div class="d-flex align-items-center gap-3 flex-wrap">
   
        <div class="ms-auto search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search articles...">
        </div>
      </div>
    </div>
  </div> --}}

  <section style="padding:60px 0 100px;background:var(--cream)">
    <div class="container">
      <div class="row g-4">

        <!-- Main Content -->
        <div class="col-lg-8">
          
          <!-- Featured -->
          <div class="news-featured mb-4" data-r="up" onclick="showPage('news-detail')">
            <div class="nf-cat"><i class="fas fa-star"></i>{{ $firstBlogs->category->category_name }}</div>
            <h2 class="nf-h">{{ $firstBlogs->title }}</h2>
            <p class="nf-p">{{ Str::limit($firstBlogs->short_description, 150) }}</p>
            <div class="nf-meta">
              <div class="nf-meta-item"><i class="fas fa-calendar"></i>{{ $firstBlogs->created_at->format('d M Y') }}</div>
              <div class="nf-meta-item"><i class="fas fa-user"></i>Admin</div>
              {{-- <div class="nf-meta-item"><i class="fas fa-clock"></i>8 min read</div>
              <div class="nf-meta-item"><i class="fas fa-eye"></i>2,340 views</div> --}}
            </div>
            <a class="btn-gold btn-sm mt-4" style="pointer-events:none" href="{{ url('news/' . $firstBlogs->slug) }}"><i class="fas fa-arrow-right"></i>Read Full Story</a>
          </div>

          <!-- News Grid -->
          <div class="row g-4">
            @foreach ($allBlogs as $item)
                <div class="col-md-6" data-r="up">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:{{ $item->image ? 'url(' . asset($item->featured_image) . ')' : 'linear-gradient(135deg,#0D6B63,#0F1F5C)' }}"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag">{{ $item->category->category_name }}</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>5 min</div>
                  <i class="fas fa-graduation-cap" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">{{ $item->created_at->format('d M Y') }}</div>
                  <h4 class="nc-h">{{ $item->title }}</h4>
                  <p class="nc-p">{{ Str::limit($item->short_description, 150) }}</p>
                    <a href="{{ url('news/' . $item->slug) }}"><div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:var(--teal)"></div><span class="nc-author-name">Admin</span></div>
                    <div class="btn-gold btn-sm mt-4" style="pointer-events:none" href="{{ url('news/' . $item->slug) }}"><i class="fas fa-arrow-right"></i>Read Full Story</div>
                  </div>
                  </a>
                </div>
              </div>
            </div>
            @endforeach
            
          
          </div>

          <!-- Pagination -->
          {{ $allBlogs->links('vendor.pagination.custom') }}


        </div>

        <!-- Sidebar -->
        <div class="col-lg-4" data-r="right">
          <div class="sidebar-widget">
            <div class="sw-title">Recent Articles</div>
            @foreach ($mostRecent as $item)
            <a class="recent-item" href="{{ url('news/' . $item->slug) }}">
              <div class="ri-img" style="background:{{ $item->image ? 'url(' . asset($item->featured_image) . ')' : 'linear-gradient(135deg,#0D6B63,#0F1F5C)' }}"></div>
              <div><div class="ri-date">{{ $item->created_at->format('d M Y') }}</div><div class="ri-h">{{ $item->title }}</div></div>
            </a>
            @endforeach
           
            
          </div>

          <div class="sidebar-widget">
            <div class="sw-title">Categories</div>
            @foreach ($blogsCategory as $bcategory)
                 <div class="cat-item"><span class="cat-name"><i class="fas fa-heart me-2" style="color:var(--gold)"></i>{{ $bcategory->category_name }}</span><span class="cat-count">{{ $bcategory->blogs()->where('status', 'published')->count() }}</span></div>
            
            @endforeach
           
          </div>

          <div class="sidebar-widget">
            <div class="sw-title">Popular Tags</div>
            <div class="tag-cloud">
              <span class="tag">Quran Learning</span><span class="tag">UK Charity</span><span class="tag">Gift Aid</span><span class="tag">Tajweed</span><span class="tag">Orphan Support</span><span class="tag">Education</span><span class="tag">Impact</span><span class="tag">Bangladesh</span><span class="tag">Nigeria</span><span class="tag">Ramadan</span>
            </div>
          </div>

          {{-- <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));border-radius:16px;padding:28px 22px;position:relative;overflow:hidden">
            <div style="position:absolute;inset:0;background:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.025'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E\")"></div>
            <div style="position:relative">
              <div style="font-size:.65rem;font-weight:700;letter-spacing:2.5px;color:var(--gold);text-transform:uppercase;margin-bottom:12px">Newsletter</div>
              <h5 class="serif" style="font-size:1.15rem;color:var(--white);margin-bottom:10px">Stay Updated</h5>
              <p style="font-size:.78rem;color:rgba(255,255,255,.45);margin-bottom:18px;line-height:1.6">Get monthly impact reports and news delivered to your inbox.</p>
              <input type="email" class="field-input" placeholder="your@email.com" style="margin-bottom:10px;background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.12);color:var(--white)">
              <button class="btn-gold" style="width:100%;justify-content:center">Subscribe</button>
            </div>
          </div> --}}


        </div>
      </div>
    </div>
  </section>
 </div>
@endsection