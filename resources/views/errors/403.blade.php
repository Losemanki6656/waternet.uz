<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 – {{ __('messages.forbidden') ?? 'Ruxsat yo\'q' }} | Waternet</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Nunito', sans-serif;
        }
        .error-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(85,110,230,.12);
            padding: 56px 48px;
            max-width: 480px;
            width: 100%;
            text-align: center;
        }
        .error-icon-wrap {
            width: 96px; height: 96px;
            border-radius: 50%;
            background: rgba(244,106,106,.1);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
        }
        .error-icon-wrap i {
            font-size: 42px;
            color: #f46a6a;
        }
        .error-code {
            font-size: 72px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #f46a6a, #f1b44c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        .error-title {
            font-size: 22px;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 12px;
        }
        .error-desc {
            color: #74788d;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .btn-home {
            background: linear-gradient(135deg, #556ee6, #6f42c1);
            border: none;
            color: #fff;
            padding: 12px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity .2s, transform .15s;
        }
        .btn-home:hover {
            color: #fff;
            opacity: .9;
            transform: translateY(-1px);
        }
        .btn-back {
            color: #74788d;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 16px;
            transition: color .2s;
        }
        .btn-back:hover { color: #343a40; }
        .logo-wrap {
            margin-bottom: 36px;
        }
        .logo-wrap img { height: 28px; }
        .logo-wrap span {
            font-size: 18px;
            font-weight: 700;
            color: #343a40;
            vertical-align: middle;
            margin-left: 6px;
        }
    </style>
</head>
<body>
    <div class="error-card">

        <div class="logo-wrap">
            <img src="{{ asset('assets/images/favicon.png') }}" alt="Waternet">
            <span>Waternet</span>
        </div>

        <div class="error-icon-wrap">
            <i class="fas fa-shield-alt"></i>
        </div>

        <div class="error-code">403</div>
        <div class="error-title">{{ __('messages.access_denied') ?? 'Kirish taqiqlangan' }}</div>
        <p class="error-desc">
            {{ __('messages.forbidden_desc') ?? 'Siz ushbu sahifaga kirish uchun ruxsatga ega emassiz. Agar bu xato deb hisoblasangiz, tizim administratoriga murojaat qiling.' }}
        </p>

        <div>
            <a href="{{ url('/') }}" class="btn-home">
                <i class="fas fa-home"></i>
                {{ __('messages.go_home') ?? 'Bosh sahifaga' }}
            </a>
        </div>

        <div>
            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                {{ __('messages.go_back') ?? 'Orqaga qaytish' }}
            </a>
        </div>

    </div>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    {{-- FontAwesome is bundled in icons.min.css --}}
</body>
</html>
