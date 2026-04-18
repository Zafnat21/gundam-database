<div>
    <div
        x-show="filteredPilots().length > 0"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
    >
        <template x-for="(pilot, index) in paginatedPilots()" :key="pilot.id">
            <article
                @click='openModal("pilot", pilot)'
                class="card-animate group cursor-pointer rounded-3xl border border-slate-800/90 bg-slate-900/70 shadow-[0_10px_30px_rgba(0,0,0,0.35)] overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(15,23,42,0.55)]"
                :style="`animation-delay: ${index * 90}ms;`"
            >
                <div class="aspect-[4/3] bg-slate-800 overflow-hidden">
                    <template x-if="pilot.image_url">
                        <img
                            :src="pilot.image_url"
                            :alt="pilot.name"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.03]"
                        >
                    </template>

                    <template x-if="!pilot.image_url">
                        <div class="w-full h-full flex items-center justify-center text-slate-500">
                            No Image
                        </div>
                    </template>
                </div>

                <div class="p-5 space-y-4">
                    <div class="space-y-2">
                        <h2 class="text-xl font-semibold text-slate-100" x-text="pilot.name"></h2>
                        <p class="text-sm text-slate-400 line-clamp-2" x-text="pilot.description"></p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <template
                            x-for="tag in (pilot.tags || '').split(',').map(tag => tag.trim()).filter(Boolean)"
                            :key="tag"
                        >
                            <span class="px-3 py-1 text-xs rounded-full border border-slate-700 bg-slate-800/90 text-slate-200" x-text="tag"></span>
                        </template>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Related Mobile Suits</p>

                        <div class="flex gap-3 overflow-x-auto pb-1">
                            <template x-for="mobileSuit in (pilot.mobile_suits || pilot.mobileSuits || [])" :key="mobileSuit.id">
                                <div class="min-w-[72px] max-w-[72px]">
                                    <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 shadow-sm">
                                        <template x-if="mobileSuit.image_url">
                                            <img
                                                :src="mobileSuit.image_url"
                                                :alt="mobileSuit.name"
                                                class="w-full h-16 object-cover"
                                            >
                                        </template>

                                        <template x-if="!mobileSuit.image_url">
                                            <div class="w-full h-16 flex items-center justify-center text-[10px] text-slate-500">
                                                No Image
                                            </div>
                                        </template>
                                    </div>

                                    <p
                                        class="mt-2 text-[11px] leading-tight text-slate-300 text-center line-clamp-2"
                                        x-text="mobileSuit.name"
                                    ></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </article>
        </template>
    </div>

    <div
        x-show="filteredPilots().length === 0"
        x-cloak
        class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-12 text-center"
    >
        <p class="text-sm uppercase tracking-[0.25em] text-slate-500">No Result</p>
        <h3 class="mt-3 text-xl font-semibold text-slate-100">No pilots found</h3>
        <p class="mt-2 text-sm text-slate-400">
            Coba keyword atau filter lain untuk mencari Pilot yang kamu inginkan.
        </p>
    </div>

    <div
        x-show="filteredPilots().length > 0"
        class="mt-8 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-800 bg-slate-900/60 px-4 py-3"
    >
        <button
            @click="goToPreviousPilotPage()"
            :disabled="pilotPage === 1"
            :class="pilotPage === 1
                ? 'opacity-40 cursor-not-allowed'
                : 'hover:bg-slate-800 hover:text-white'"
            class="px-4 py-2 rounded-xl border border-slate-700 bg-slate-900 text-slate-200 transition"
        >
            Previous
        </button>

        <div class="flex flex-wrap items-center justify-center gap-2">
            <template x-for="page in pilotPageNumbers()" :key="page">
                <button
                    @click="setPilotPage(page)"
                    :class="pilotPage === page
                        ? 'bg-slate-200 text-slate-950 border-slate-200'
                        : 'bg-slate-900 text-slate-200 border-slate-700 hover:bg-slate-800 hover:text-white'"
                    class="min-w-[40px] px-3 py-2 rounded-xl border text-sm transition"
                    x-text="page"
                ></button>
            </template>
        </div>

        <button
            @click="goToNextPilotPage()"
            :disabled="pilotPage === totalPilotPages()"
            :class="pilotPage === totalPilotPages()
                ? 'opacity-40 cursor-not-allowed'
                : 'hover:bg-slate-800 hover:text-white'"
            class="px-4 py-2 rounded-xl border border-slate-700 bg-slate-900 text-slate-200 transition"
        >
            Next
        </button>
    </div>
</div>