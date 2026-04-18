@extends('layouts.app')

@section('title', 'My Gundam Database')

@section('content')
    <section class="mb-8">
        <div class="max-w-3xl">
            <p class="text-xs uppercase tracking-[0.28em] text-slate-500 mb-3">Archive Overview</p>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-100">Mobile Suits & Pilots</h2>
            <p class="text-slate-400 mt-3 leading-relaxed">
                Temukan berbagai Mobile Suits dan Pilots dari berbagai universe Gundam, lengkap dengan hubungan data yang saling terhubung.
            </p>
        </div>
    </section>

    <div
        x-data="{
            tab: 'mobile-suits',
            search: '',
            selectedTag: 'All',
            sortOption: 'name-asc',
            filterOpen: false,
            mobileSuitPage: 1,
            pilotPage: 1,
            itemsPerPage: 6,
            modalOpen: false,
            modalType: '',
            selectedItem: null,
            imageModalOpen: false,
            selectedImage: '',
            selectedImageAlt: '',
            allMobileSuits: @js($mobileSuits),
            allPilots: @js($pilots),

            extractTags(items) {
                return [...new Set(
                    items.flatMap(item =>
                        (item.tags || '')
                            .split(',')
                            .map(tag => tag.trim())
                            .filter(Boolean)
                    )
                )].sort((a, b) => a.localeCompare(b));
            },

            availableTags() {
                const source = this.tab === 'mobile-suits' ? this.allMobileSuits : this.allPilots;
                return this.extractTags(source);
            },

            matchesSelectedTag(item) {
                if (this.selectedTag === 'All') return true;

                const tags = (item.tags || '')
                    .split(',')
                    .map(tag => tag.trim())
                    .filter(Boolean);

                return tags.includes(this.selectedTag);
            },

            applySearchAndFilter(items, type) {
                let results = [...items];

                if (this.search.trim()) {
                    const keyword = this.search.toLowerCase();
                    results = results.filter(item =>
                        item.name.toLowerCase().includes(keyword)
                    );
                }

                if (this.selectedTag !== 'All') {
                    results = results.filter(item => this.matchesSelectedTag(item));
                }

                results.sort((a, b) => {
                    if (this.sortOption === 'name-desc') {
                        return b.name.localeCompare(a.name);
                    }

                    return a.name.localeCompare(b.name);
                });

                return results;
            },

            filteredMobileSuits() {
                return this.applySearchAndFilter(this.allMobileSuits, 'mobile-suits');
            },

            filteredPilots() {
                return this.applySearchAndFilter(this.allPilots, 'pilots');
            },

            paginatedMobileSuits() {
                const start = (this.mobileSuitPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.filteredMobileSuits().slice(start, end);
            },

            totalMobileSuitPages() {
                return Math.max(1, Math.ceil(this.filteredMobileSuits().length / this.itemsPerPage));
            },

            mobileSuitPageNumbers() {
                return Array.from({ length: this.totalMobileSuitPages() }, (_, i) => i + 1);
            },

            setMobileSuitPage(page) {
                this.mobileSuitPage = page;
            },

            goToPreviousMobileSuitPage() {
                if (this.mobileSuitPage > 1) this.mobileSuitPage--;
            },

            goToNextMobileSuitPage() {
                if (this.mobileSuitPage < this.totalMobileSuitPages()) this.mobileSuitPage++;
            },

            resetMobileSuitPageIfNeeded() {
                if (this.mobileSuitPage > this.totalMobileSuitPages()) {
                    this.mobileSuitPage = 1;
                }
            },

            paginatedPilots() {
                const start = (this.pilotPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.filteredPilots().slice(start, end);
            },

            totalPilotPages() {
                return Math.max(1, Math.ceil(this.filteredPilots().length / this.itemsPerPage));
            },

            pilotPageNumbers() {
                return Array.from({ length: this.totalPilotPages() }, (_, i) => i + 1);
            },

            setPilotPage(page) {
                this.pilotPage = page;
            },

            goToPreviousPilotPage() {
                if (this.pilotPage > 1) this.pilotPage--;
            },

            goToNextPilotPage() {
                if (this.pilotPage < this.totalPilotPages()) this.pilotPage++;
            },

            resetPilotPageIfNeeded() {
                if (this.pilotPage > this.totalPilotPages()) {
                    this.pilotPage = 1;
                }
            },

            resetAllPages() {
                this.mobileSuitPage = 1;
                this.pilotPage = 1;
                this.resetMobileSuitPageIfNeeded();
                this.resetPilotPageIfNeeded();
            },

            clearFilters() {
                this.selectedTag = 'All';
                this.sortOption = 'name-asc';
                this.resetAllPages();
            },

            findFullItem(type, id) {
                if (type === 'mobile-suit') {
                    return this.allMobileSuits.find(item => item.id === id) || null;
                }

                if (type === 'pilot') {
                    return this.allPilots.find(item => item.id === id) || null;
                }

                return null;
            },

            openModal(type, item) {
                this.modalType = type;
                this.selectedItem = this.findFullItem(type, item.id) || item;
                this.modalOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.modalOpen = false;
                this.modalType = '';
                this.selectedItem = null;

                if (!this.imageModalOpen) {
                    document.body.classList.remove('overflow-hidden');
                }
            },

            openImageModal(imageUrl, imageAlt = 'Image') {
                if (!imageUrl) return;

                this.selectedImage = imageUrl;
                this.selectedImageAlt = imageAlt;
                this.imageModalOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeImageModal() {
                this.imageModalOpen = false;
                this.selectedImage = '';
                this.selectedImageAlt = '';

                if (!this.modalOpen) {
                    document.body.classList.remove('overflow-hidden');
                }
            },

            openRelatedPilot(pilot) {
                this.modalType = 'pilot';
                this.selectedItem = this.findFullItem('pilot', pilot.id);
            },

            openRelatedMobileSuit(mobileSuit) {
                this.modalType = 'mobile-suit';
                this.selectedItem = this.findFullItem('mobile-suit', mobileSuit.id);
            }
        }"
        x-init="
            $watch('search', () => resetAllPages());
            $watch('selectedTag', () => resetAllPages());
            $watch('sortOption', () => resetAllPages());
            $watch('itemsPerPage', () => resetAllPages());
            $watch('tab', () => {
                selectedTag = 'All';
                sortOption = 'name-asc';
                filterOpen = false;
                resetAllPages();
            });
        "
        @keydown.escape.window="
            if (imageModalOpen) {
                closeImageModal()
            } else if (modalOpen) {
                closeModal()
            } else if (filterOpen) {
                filterOpen = false
            }
        "
        class="space-y-6"
    >
        <div class="flex flex-wrap gap-3">
            <button
                @click="tab = 'mobile-suits'"
                :class="tab === 'mobile-suits'
                    ? 'bg-slate-200 text-slate-950 border-slate-200'
                    : 'bg-slate-900/80 text-slate-200 border-slate-700/80 hover:bg-slate-800'"
                class="px-4 py-2.5 rounded-xl border font-medium transition"
            >
                Mobile Suits
            </button>

            <button
                @click="tab = 'pilots'"
                :class="tab === 'pilots'
                    ? 'bg-slate-200 text-slate-950 border-slate-200'
                    : 'bg-slate-900/80 text-slate-200 border-slate-700/80 hover:bg-slate-800'"
                class="px-4 py-2.5 rounded-xl border font-medium transition"
            >
                Pilots
            </button>
        </div>

        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div class="relative max-w-xl w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="m20 20-3.5-3.5"></path>
                    </svg>
                </span>

                <input
                    x-model="search"
                    type="text"
                    :placeholder="tab === 'mobile-suits' ? 'Search mobile suits...' : 'Search pilots...'"
                    class="w-full rounded-2xl border border-slate-700 bg-slate-800/90 py-3 pl-11 pr-12 text-sm text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-600/40"
                >

                <button
                    x-show="search.length > 0"
                    x-cloak
                    @click="search = ''"
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-white transition"
                >
                    ✕
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-3">
                    <label for="itemsPerPage" class="text-sm text-slate-400 whitespace-nowrap">Show</label>
                    <select
                        id="itemsPerPage"
                        x-model.number="itemsPerPage"
                        class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm text-slate-100 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-600/40"
                    >
                        <option value="6">6</option>
                        <option value="9">9</option>
                        <option value="12">12</option>
                    </select>
                    <span class="text-sm text-slate-400 whitespace-nowrap">per page</span>
                </div>

                <div class="relative" @click.outside="filterOpen = false">
                    <button
                        @click="filterOpen = !filterOpen"
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-700 bg-slate-800/90 px-4 py-2.5 text-sm text-slate-200 transition hover:bg-slate-700 hover:text-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18"></path>
                            <path d="M6 12h12"></path>
                            <path d="M10 18h4"></path>
                        </svg>
                        <span>Filter</span>
                    </button>

                    <div
                        x-show="filterOpen"
                        x-cloak
                        x-transition
                        class="absolute right-0 mt-3 w-[320px] rounded-3xl border border-slate-700 bg-slate-900/98 p-4 shadow-[0_20px_60px_rgba(2,6,23,0.7)] backdrop-blur-md z-20"
                    >
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Filter & Sort</p>
                                <p class="text-sm text-slate-300 mt-1" x-text="tab === 'mobile-suits' ? 'Mobile Suits controls' : 'Pilots controls'"></p>
                            </div>

                            <button
                                @click="clearFilters()"
                                type="button"
                                class="text-xs text-slate-400 hover:text-white transition"
                            >
                                Reset
                            </button>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-xs uppercase tracking-[0.22em] text-slate-500">Tag</label>
                                <select
                                    x-model="selectedTag"
                                    class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-600/40"
                                >
                                    <option value="All">All Tags</option>
                                    <template x-for="tag in availableTags()" :key="tag">
                                        <option :value="tag" x-text="tag"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs uppercase tracking-[0.22em] text-slate-500">Sort</label>
                                <select
                                    x-model="sortOption"
                                    class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-600/40"
                                >
                                    <option value="name-asc">Name: A to Z</option>
                                    <option value="name-desc">Name: Z to A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section x-show="tab === 'mobile-suits'" x-cloak>
            @include('gundam.partials.mobile-suits-grid')
        </section>

        <section x-show="tab === 'pilots'" x-cloak>
            @include('gundam.partials.pilots-grid')
        </section>

        <div
            x-show="modalOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-sm"
            @click="closeModal()"
        ></div>

        <div
            x-show="modalOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                @click.stop
                class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl border border-slate-700 bg-slate-900 shadow-[0_25px_80px_rgba(2,6,23,0.7)]"
            >
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
                    <div>
                        <p
                            class="text-xs uppercase tracking-[0.25em] text-slate-500"
                            x-text="modalType === 'mobile-suit' ? 'Mobile Suit Detail' : 'Pilot Detail'"
                        ></p>
                        <h3
                            class="text-lg font-semibold text-slate-100"
                            x-text="selectedItem?.name || 'Detail'"
                        ></h3>
                    </div>

                    <button
                        @click="closeModal()"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-2xl border border-slate-700 bg-slate-800/90 text-slate-300 hover:bg-slate-700 hover:text-white transition"
                    >
                        ✕
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <button
                        type="button"
                        class="w-full rounded-3xl overflow-hidden border border-slate-800 bg-slate-800 group cursor-zoom-in"
                        @click="openImageModal(selectedItem?.image_url, selectedItem?.name)"
                    >
                        <template x-if="selectedItem?.image_url">
                            <img
                                :src="selectedItem?.image_url"
                                :alt="selectedItem?.name"
                                class="w-full h-[280px] md:h-[420px] object-cover transition duration-500 group-hover:scale-[1.02]"
                            >
                        </template>

                        <template x-if="!selectedItem?.image_url">
                            <div class="w-full h-[280px] md:h-[420px] flex items-center justify-center text-slate-500">
                                No Image
                            </div>
                        </template>
                    </button>

                    <div class="space-y-3">
                        <h4 class="text-2xl md:text-3xl font-bold text-slate-100" x-text="selectedItem?.name"></h4>

                        <div class="flex flex-wrap gap-2">
                            <template x-for="tag in (selectedItem?.tags || '').split(',').map(tag => tag.trim()).filter(Boolean)" :key="tag">
                                <span class="px-3 py-1 text-xs rounded-full border border-slate-700 bg-slate-800/90 text-slate-200" x-text="tag"></span>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p
                            class="text-xs uppercase tracking-[0.25em] text-slate-500"
                            x-text="modalType === 'mobile-suit' ? 'Related Pilots' : 'Related Mobile Suits'"
                        ></p>

                        <div class="flex gap-3 overflow-x-auto pb-2">
                            <template x-if="modalType === 'mobile-suit'">
                                <template x-for="pilot in (selectedItem?.pilots || [])" :key="pilot.id">
                                    <button
                                        type="button"
                                        @click="openRelatedPilot(pilot)"
                                        class="min-w-[88px] max-w-[88px] text-left group"
                                    >
                                        <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 transition hover:border-slate-500 hover:-translate-y-0.5">
                                            <template x-if="pilot.image_url">
                                                <img :src="pilot.image_url" :alt="pilot.name" class="w-full h-20 object-cover transition duration-300 group-hover:scale-[1.03]">
                                            </template>

                                            <template x-if="!pilot.image_url">
                                                <div class="w-full h-20 flex items-center justify-center text-[10px] text-slate-500">
                                                    No Image
                                                </div>
                                            </template>
                                        </div>
                                        <p class="mt-2 text-[11px] leading-tight text-slate-300 text-center line-clamp-2" x-text="pilot.name"></p>
                                    </button>
                                </template>
                            </template>

                            <template x-if="modalType === 'pilot'">
                                <template x-for="mobileSuit in (selectedItem?.mobile_suits || selectedItem?.mobileSuits || [])" :key="mobileSuit.id">
                                    <button
                                        type="button"
                                        @click="openRelatedMobileSuit(mobileSuit)"
                                        class="min-w-[88px] max-w-[88px] text-left group"
                                    >
                                        <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 transition hover:border-slate-500 hover:-translate-y-0.5">
                                            <template x-if="mobileSuit.image_url">
                                                <img :src="mobileSuit.image_url" :alt="mobileSuit.name" class="w-full h-20 object-cover transition duration-300 group-hover:scale-[1.03]">
                                            </template>

                                            <template x-if="!mobileSuit.image_url">
                                                <div class="w-full h-20 flex items-center justify-center text-[10px] text-slate-500">
                                                    No Image
                                                </div>
                                            </template>
                                        </div>
                                        <p class="mt-2 text-[11px] leading-tight text-slate-300 text-center line-clamp-2" x-text="mobileSuit.name"></p>
                                    </button>
                                </template>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Description</p>
                        <p class="text-sm md:text-base leading-relaxed text-slate-300" x-text="selectedItem?.description || 'No description available.'"></p>
                    </div>
                </div>
            </div>
        </div>

        <div
            x-show="imageModalOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[60] bg-black/90 backdrop-blur-sm"
            @click="closeImageModal()"
        ></div>

        <div
            x-show="imageModalOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[70] flex items-center justify-center p-4"
        >
            <div class="relative max-w-6xl w-full flex items-center justify-center" @click.stop>
                <button
                    @click="closeImageModal()"
                    class="absolute top-4 right-4 z-10 inline-flex items-center justify-center w-11 h-11 rounded-2xl border border-white/15 bg-black/50 text-white hover:bg-black/70 transition"
                >
                    ✕
                </button>

                <template x-if="selectedImage">
                    <img
                        :src="selectedImage"
                        :alt="selectedImageAlt"
                        class="max-w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl"
                    >
                </template>
            </div>
        </div>
    </div>
@endsection