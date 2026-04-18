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
        <header class="sticky top-0 z-30 border-b border-slate-700/80 bg-slate-900/95 shadow-[0_10px_30px_rgba(2,6,23,0.45)] backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-4">
                <div class="min-w-fit">
                    <h1 class="text-lg md:text-xl font-semibold text-slate-100 leading-none">
                        My Gundam Database
                    </h1>
                </div>

                <div class="flex-1 max-w-2xl mx-auto">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path d="m20 20-3.5-3.5"></path>
                            </svg>
                        </span>

                        <input
                            type="text"
                            placeholder="Search mobile suits, pilots, or tags..."
                            class="w-full rounded-2xl border border-slate-700 bg-slate-800/90 py-3 pl-11 pr-4 text-sm text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-600/40"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center justify-center w-11 h-11 rounded-2xl border border-slate-700 bg-slate-800/90 text-slate-300 transition hover:bg-slate-700 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18"></path>
                            <path d="M6 12h12"></path>
                            <path d="M10 18h4"></path>
                        </svg>
                    </button>

                    <button class="inline-flex items-center justify-center w-11 h-11 rounded-2xl border border-slate-700 bg-slate-800/90 text-slate-300 transition hover:bg-slate-700 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                            <path d="M8 11V7a4 4 0 1 1 8 0v4"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-8">
            @yield('content')
        </main>
    </div>
</body>
</html>