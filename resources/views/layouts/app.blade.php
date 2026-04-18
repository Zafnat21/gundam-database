<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Gundam Database')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(51,65,85,0.38),_rgba(2,6,23,1)_58%)]">
        <header class="sticky top-0 z-30 border-b border-slate-800/80 bg-slate-950/90 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div>
                    <h1 class="text-lg md:text-xl font-semibold text-slate-100 leading-none">
                        My Gundam Database
                    </h1>
                    <p class="mt-1 text-xs text-slate-500 tracking-[0.18em] uppercase">
                        Mobile Suits Archive
                    </p>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-8">
            @yield('content')
        </main>
    </div>
</body>
</html>