<header class="sticky top-0 z-30 border-b border-satwa-line bg-satwa-bg/95 backdrop-blur-md">
    <div class="mx-auto flex h-[62px] max-w-[1400px] items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

        <a href="#" onclick="switchMainTab('marketplace'); return false;" class="flex shrink-0 items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" width="36" height="36" alt="Logo SatwaTrace" class="h-9 w-9 object-contain rounded-lg">
            <div>
                <span class="block font-heading text-[19px] font-semibold leading-tight text-satwa-forest">SatwaTrace</span>
                <span class="block text-[9px] font-semibold uppercase tracking-[.2em] text-satwa-muted">Pencarian Satwa Hilang</span>
            </div>
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <button onclick="switchMainTab('marketplace')" id="tab-btn-marketplace" class="nav-link active">Jelajah Satwa</button>
            <button onclick="switchMainTab('report')" id="tab-btn-report" class="nav-link">Buat Laporan</button>
        </nav>

        <div class="hidden sm:block">
            <button onclick="switchMainTab('report')" class="primary-btn !py-2 !px-4 !text-xs">
                Laporkan Satwa Hilang
            </button>
        </div>
    </div>

    <nav class="flex border-t border-satwa-line md:hidden">
        <button onclick="switchMainTab('marketplace')" id="tab-btn-marketplace-mob" class="nav-link active flex-1 text-center">Jelajah Satwa</button>
        <button onclick="switchMainTab('report')" id="tab-btn-report-mob" class="nav-link flex-1 text-center">Buat Laporan</button>
    </nav>
</header>
