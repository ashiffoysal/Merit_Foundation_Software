@extends('layouts.frontend')
@section('content')

  <div class="login-page">

    <!-- Left Panel -->
    <div class="login-left">
      <div class="ll-brand" onclick="showPage('news')">
        <div class="ll-brand-ic"><i class="fas fa-book-open"></i></div>
        <div><div class="ll-brand-t">MERIT</div><span class="ll-brand-s">Education Foundation</span></div>
      </div>
      <h2 class="ll-h">Welcome<br>Back to <em>Merit</em></h2>
      <p class="ll-p">Sign in to manage your lessons, track your child's progress, and support our mission to educate every child.</p>
      <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-graduation-cap"></i></div><div><div class="ll-feat-t">Manage Your Lessons</div><div class="ll-feat-s">Book, reschedule and review your session history</div></div></div>
      <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-chart-line"></i></div><div><div class="ll-feat-t">Track Progress</div><div class="ll-feat-s">Follow your child's Quran learning journey with detailed reports</div></div></div>
      <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-heart"></i></div><div><div class="ll-feat-t">Manage Donations</div><div class="ll-feat-s">View your donation history and Gift Aid declarations</div></div></div>
      <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-shield-alt"></i></div><div><div class="ll-feat-t">Safe &amp; Secure</div><div class="ll-feat-s">Your data is protected under UK GDPR standards</div></div></div>
      <div class="ll-footer">Merit Education Foundation · UK Registered Charity · Safeguarding First</div>
    </div>

    <!-- Right Panel -->
    <div class="login-right">
      <div class="login-right-inner">

        <!-- Login Form -->
        <div id="login-form-wrap">
          <div class="login-tab-wrap">
            <button class="login-tab active" onclick="switchLoginTab(this,'login')">Sign In</button>
            <button class="login-tab" onclick="switchLoginTab(this,'register')">Register</button>
          </div>

          <!-- Sign In -->
          <div id="signin-panel">
            <h2 class="login-form-title">Sign In</h2>
            <p class="login-form-sub">Welcome back. Enter your credentials to access your account.</p>
            <div class="field-group"><label class="field-label">Email Address</label><input type="email" class="field-input" placeholder="you@email.com"></div>
            <div class="field-group">
              <label class="field-label">Password</label>
              <div class="pass-toggle"><input type="password" class="field-input" placeholder="Enter password" id="pw1"><span class="pt-eye" onclick="togglePw('pw1',this)"><i class="fas fa-eye"></i></span></div>
            </div>
            <div class="remember-row">
              <label><input type="checkbox"> Remember me</label>
              <span class="forgot-link">Forgot password?</span>
            </div>
            <button class="btn-gold" style="width:100%;justify-content:center;padding:15px;font-size:.82rem" onclick="showPage('dashboard')"><i class="fas fa-sign-in-alt"></i>Sign In</button>
            <div class="divider-or"><span>or continue with</span></div>
            <div class="social-login-btn"><i class="fab fa-google" style="color:#EA4335"></i>Continue with Google</div>
            <div class="social-login-btn"><i class="fab fa-facebook-f" style="color:#1877F2"></i>Continue with Facebook</div>
          </div>

          <!-- Register -->
          <div id="register-panel" style="display:none">
            <h2 class="login-form-title">Create Account</h2>
            <p class="login-form-sub">Join Merit Education Foundation today — for you and your child.</p>
            <div class="row g-3">
              <div class="col-6"><div class="field-group"><label class="field-label">First Name</label><input type="text" class="field-input" placeholder="First name"></div></div>
              <div class="col-6"><div class="field-group"><label class="field-label">Last Name</label><input type="text" class="field-input" placeholder="Last name"></div></div>
            </div>
            <div class="field-group"><label class="field-label">Email Address</label><input type="email" class="field-input" placeholder="you@email.com"></div>
            <div class="field-group"><label class="field-label">Phone Number</label><input type="tel" class="field-input" placeholder="+44 7000 000000"></div>
            <div class="field-group"><label class="field-label">Password</label><div class="pass-toggle"><input type="password" class="field-input" placeholder="Create password" id="pw2"><span class="pt-eye" onclick="togglePw('pw2',this)"><i class="fas fa-eye"></i></span></div></div>
            <div class="field-group"><label class="field-label">Confirm Password</label><div class="pass-toggle"><input type="password" class="field-input" placeholder="Confirm password" id="pw3"><span class="pt-eye" onclick="togglePw('pw3',this)"><i class="fas fa-eye"></i></span></div></div>
            <div style="margin-bottom:20px">
              <label style="font-size:.78rem;color:var(--muted);display:flex;align-items:flex-start;gap:9px;line-height:1.5;cursor:pointer"><input type="checkbox" style="accent-color:var(--navy);width:15px;height:15px;margin-top:2px;flex-shrink:0"> I agree to the <span style="color:var(--gold);cursor:pointer" onclick="showPage('privacy')">Privacy Policy</span> and Terms & Conditions</label>
            </div>
            <button class="btn-gold" style="width:100%;justify-content:center;padding:15px;font-size:.82rem" onclick="showPage('dashboard')"><i class="fas fa-user-plus"></i>Create Account</button>
          </div>
        </div>

        <div class="login-back" onclick="showPage('news')"><i class="fas fa-arrow-left"></i>Back to website</div>
      </div>
    </div>
  </div>
@endsection
{{--  
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
 --}}