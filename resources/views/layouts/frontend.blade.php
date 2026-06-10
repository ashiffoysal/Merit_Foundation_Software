<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> @yield('title') | {{ $companyInfo ? $companyInfo->organisation_name : 'Merit Education Foundation' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/style.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- meta tags --}}
    <meta name="description" content="{{ $seoData ? $seoData->meta_description : 'Merit Education Foundation is a UK-based education charity dedicated to providing quality education to disadvantaged children around the world.' }}" />
    <meta name="keywords" content="{{ $seoData ? $seoData->meta_keywords : 'education, charity, disadvantaged children, Quran teaching' }}" />
    <meta name="author" content="{{ $seoData ? $seoData->meta_author : 'Merit Education Foundation' }}" />
    {{-- canonical_url --}}
    <link rel="canonical" href="{{ $seoData ? $seoData->canonical_url : url()->current() }}" />
    {{-- index_status --}}
    <meta name="robots" content="{{ $seoData ? $seoData->index_status : 'index, follow' }}" />
    {{-- new_url --}}
    <link rel="alternate" type="application/rss+xml" title="Merit Education Foundation" href="{{ $seoData ? $seoData->new_url : url('/rss') }}" />
    {{-- 	og_title --}}
    <meta property="og:title" content="{{ $seoData ? $seoData->og_title : 'Merit Education Foundation' }}" />
    {{-- og_description --}}
    <meta property="og:description" content="{{ $seoData ? $seoData->og_description : 'Merit Education Foundation is a UK-based education charity dedicated to providing quality education to disadvantaged children around the world.' }}" />
    {{-- og_image --}}  
    <meta property="og:image" content="{{ $seoData && $seoData->og_image ? asset('storage/' . $seoData->og_image) : asset('frontend/assets/default-og-image.jpg') }}" />
    {{-- og_url --}}
    <meta property="og:url" content="{{ $seoData ? $seoData->og_url : url()->current() }}" />
    {{-- og_type --}}
    <meta property="og:type" content="{{ $seoData ? $seoData->og_type : 'website' }}" />

    {{-- twitter_title --}}
    <meta name="twitter:title" content="{{ $seoData ? $seoData->twitter_title : 'Merit Education Foundation' }}" />
    {{-- twitter_description --}}
    <meta name="twitter:description" content="{{ $seoData ? $seoData->twitter_description : 'Merit Education Foundation is a UK-based education charity dedicated to providing quality education to disadvantaged children around the world.' }}" />
    {{-- twitter_image --}}
    <meta name="twitter:image" content="{{ $seoData && $seoData->twitter_image ? asset('storage/' . $seoData->twitter_image) : asset('frontend/assets/default-twitter-image.jpg') }}" />
    {{-- twitter_card --}}
    <meta name="twitter:card" content="{{ $seoData ? $seoData->twitter_card : 'summary_large_image' }}" />


</head>

<body>
   
    @include('frontend.include.header')

    @yield('content')

    @include('frontend.include.footer')


    <button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i
            class="fas fa-chevron-up"></i></button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/custom.js') }}"></script>
</body>

</html>
