@extends('frontend.layout.master')
@section('content')

<section id="form">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="signup-form">
                    <h2>New User Signup!</h2>

                    {{-- Thông báo thành công --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('postRegister') }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="Name" required />
                        <input type="email" name="email" placeholder="Email Address" required />
                        <input type="password" name="password" placeholder="Password" required />
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

                        {{-- reCAPTCHA v2 --}}
                        <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                        <br>
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- reCAPTCHA v2 script - Corrigé --}}
<script src='https://www.google.com/recaptcha/api.js' async defer></script>

@endsection
