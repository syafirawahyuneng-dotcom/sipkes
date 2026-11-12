<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Portal SIP-Kes TeFa V-Kes</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gradient-to-tr from-slate-900 via-primary-950 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 border border-slate-100">
        
        <div class="text-center mb-8">
            @if(isset($siteLogo) && $siteLogo)
                <div class="mb-4 flex justify-center">
                    <img src="{{ $siteLogo }}" alt="SIP-Kes Logo" class="h-16 w-auto object-contain">
                </div>
            @else
                <div class="w-16 h-16 rounded-2xl bg-primary-600 text-white flex items-center justify-center text-3xl mx-auto mb-4 shadow-lg shadow-primary-600/30">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
            @endif
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Login Administrator</h1>
            <p class="text-xs text-slate-500 mt-1">Teaching Factory Inovasi Kesehatan • Polije</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Akun Admin</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email', 'admin@sipkes.id') }}" required autofocus class="w-full text-xs sm:text-sm pl-9 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="admin@sipkes.id">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" required class="w-full text-xs sm:text-sm pl-9 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <span>Ingat saya</span>
                </label>
                <span class="text-slate-400 text-[11px]">Default: admin@sipkes.id / admin123</span>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm shadow-md shadow-primary-600/30 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700">
                &larr; Kembali ke Website Publik SIP-Kes
            </a>
        </div>

    </div>

</body>
</html>

