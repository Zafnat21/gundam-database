@extends('layouts.app')

@section('title', 'Gundam Database')

@section('content')
    <header class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold">Gundam Database</h1>
        <p class="text-zinc-400 mt-2">
            Mobile Suits and Pilots database with relational data.
        </p>
    </header>

    <div x-data="{ tab: 'mobile-suits' }" class="space-y-6">
        <div class="flex flex-wrap gap-3">
            <button
                @click="tab = 'mobile-suits'"
                :class="tab === 'mobile-suits' ? 'bg-white text-black' : 'bg-zinc-800 text-white'"
                class="px-4 py-2 rounded-xl font-medium transition"
            >
                Mobile Suits
            </button>

            <button
                @click="tab = 'pilots'"
                :class="tab === 'pilots' ? 'bg-white text-black' : 'bg-zinc-800 text-white'"
                class="px-4 py-2 rounded-xl font-medium transition"
            >
                Pilots
            </button>
        </div>

        <section x-show="tab === 'mobile-suits'" x-cloak>
            @include('gundam.partials.mobile-suits-grid')
        </section>

        <section x-show="tab === 'pilots'" x-cloak>
            @include('gundam.partials.pilots-grid')
        </section>
    </div>
@endsection