<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Merit Education Foundation</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('frontend/assets/style.css') }}"/>
</head>
<body>
<!-- ── Loader ── -->
{{-- <div id="loader"><div class="loader-t">MERIT</div><div class="loader-track"><div class="loader-fill"></div></div></div> --}}
<!-- ══════════════ NAVBAR ══════════════ -->
@include('frontend.include.header')
<!-- ══════════════════════════════════════
   HOME PAGE
══════════════════════════════════════ -->
@yield('content')

@include('frontend.include.footer')


<button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="fas fa-chevron-up"></i></button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/assets/custom.js') }}"></script>
</body>
</html>
