<div class="panel p-3.5 sm:p-4 shadow-sm">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center">

        <!-- Search Input -->
        <div class="relative flex-1 min-w-[200px]">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-satwa-forest">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m16 16 4 4" stroke-linecap="round"/>
                </svg>
            </div>
            <input
                id="filter-search"
                oninput="applyFilters()"
                type="search"
                placeholder="Cari nama satwa, tanda khusus, atau jalan..."
                aria-label="Cari laporan"
                class="field !pl-10 !h-11 text-xs sm:text-sm"
            >
        </div>

        <!-- Filter Dropdowns with Uniform Dimensions -->
        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">

            <!-- Filter Kota Dropdown -->
            <div class="relative flex-1 sm:flex-none sm:w-44">
                <select
                    id="filter-location"
                    onchange="applyFilters()"
                    class="field !h-11 !pr-9 text-xs sm:text-sm font-medium appearance-none cursor-pointer w-full"
                >
                    <option value="all">Semua Kota</option>
                    <option value="surabaya">Surabaya</option>
                    <option value="sidoarjo">Sidoarjo</option>
                    <option value="gresik">Gresik</option>
                    <option value="malang">Malang</option>
                    <option value="mojokerto">Mojokerto</option>
                    <option value="pasuruan">Pasuruan</option>
                    <option value="batu">Batu</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-satwa-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Filter Spesies Dropdown -->
            <div class="relative flex-1 sm:flex-none sm:w-44">
                <select
                    id="filter-species"
                    onchange="applyFilters()"
                    class="field !h-11 !pr-9 text-xs sm:text-sm font-medium appearance-none cursor-pointer w-full"
                >
                    <option value="all">Semua Spesies</option>
                    <option value="kucing">Kucing</option>
                    <option value="anjing">Anjing</option>
                    <option value="burung">Burung</option>
                    <option value="reptil">Reptil</option>
                    <option value="mamalia">Mamalia kecil</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-satwa-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Sort Dropdown -->
            <div class="relative flex-1 sm:flex-none sm:w-44">
                <select
                    id="sort-order"
                    onchange="applyFilters()"
                    class="field !h-11 !pr-9 text-xs sm:text-sm font-medium appearance-none cursor-pointer w-full"
                >
                    <option value="newest">Urutkan: Terbaru</option>
                    <option value="oldest">Urutkan: Terlama</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-satwa-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

        </div>

    </div>
</div>
