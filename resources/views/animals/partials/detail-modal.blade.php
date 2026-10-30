<div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-satwa-forest/50 p-4" onclick="if(event.target===this)closeDetailModal()">
    <div class="panel fade-in w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-xl">

        <!-- Modal Header -->
        <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-satwa-line p-5 sm:p-6 bg-satwa-card/95 backdrop-blur-sm">
            <div class="min-w-0 pr-2">
                <span class="rounded-full bg-satwa-terracotta/10 px-2.5 py-0.5 text-[11px] font-semibold text-satwa-terracotta">
                    Laporan Satwa Hilang
                </span>
                <h2 id="modal-title" class="mt-2 font-heading text-xl font-semibold text-satwa-forest break-words [overflow-wrap:anywhere]">Detail Satwa</h2>
                <p id="modal-location" class="mt-1 text-xs text-satwa-muted break-words [overflow-wrap:anywhere]">Lokasi</p>
            </div>
            <button onclick="closeDetailModal()" aria-label="Tutup detail" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-satwa-bg text-satwa-muted hover:bg-satwa-sand transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6 6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body: Conforms to all form data fields with word-break on long strings -->
        <div class="space-y-4 p-5 sm:p-6">

            <!-- Photo or Watermark Placeholder with Robust Fallback -->
            <div id="modal-image-wrap" class="overflow-hidden rounded-xl border border-satwa-line bg-satwa-sand/60">
                <img id="modal-image" src="" alt="Foto satwa" class="hidden max-h-60 w-full object-cover">
                <div id="modal-image-placeholder" class="hidden h-44 w-full flex-col items-center justify-center p-4 text-center bg-satwa-sand/70">
                    <svg class="h-12 w-12 text-satwa-forest/35" viewBox="0 0 40 40" fill="currentColor">
                        <path d="M20 36c-8 0-13-5-13-12 0-5 3-8 5-11 1-2 1-5 0-8 4 1 7 4 7 8 1-3 3-6 6-7-1 4 0 7 2 9 3 3 6 6 6 11 0 6-5 10-13 10Z"/>
                        <circle cx="14.5" cy="24" r="2.3" fill="#FCFAF4"/>
                        <circle cx="20" cy="21" r="2.3" fill="#FCFAF4"/>
                        <circle cx="25.5" cy="24" r="2.3" fill="#FCFAF4"/>
                        <path d="M20 26c-3 0-5 2-5 4 0 2 2 3 5 3s5-1 5-3c0-2-2-4-5-4Z" fill="#FCFAF4"/>
                    </svg>
                    <span class="mt-2 text-xs font-semibold text-satwa-muted uppercase tracking-wider">SatwaTrace - Belum Ada Foto</span>
                </div>
            </div>

            <!-- Structured Data Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="rounded-lg bg-satwa-bg p-3 border border-satwa-line/60">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-satwa-muted">Nama Pelapor</p>
                    <p id="modal-reporter" class="mt-1 font-medium text-satwa-forest break-words [overflow-wrap:anywhere]">Pemilik Satwa</p>
                </div>

                <div class="rounded-lg bg-satwa-bg p-3 border border-satwa-line/60">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-satwa-muted">Kategori Spesies</p>
                    <p id="modal-species" class="mt-1 font-medium text-satwa-forest capitalize break-words [overflow-wrap:anywhere]">Kucing</p>
                </div>

                <div class="rounded-lg bg-satwa-bg p-3 border border-satwa-line/60">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-satwa-muted">Kota & Alamat Detail</p>
                    <p id="modal-detail-address" class="mt-1 font-medium text-satwa-forest break-words [overflow-wrap:anywhere]">Surabaya</p>
                </div>

                <div class="rounded-lg bg-satwa-bg p-3 border border-satwa-line/60">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-satwa-muted">Tanda Khusus / Microchip</p>
                    <p id="modal-code" class="mt-1 font-medium text-satwa-forest break-words break-all [overflow-wrap:anywhere]">Tidak ada</p>
                </div>
            </div>

            <!-- Ciri Fisik & Kronologi -->
            <div class="rounded-xl bg-satwa-bg p-3.5 border border-satwa-line/60">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-satwa-muted">Ciri Fisik & Kronologi Hilang</p>
                <p id="modal-description" class="mt-1.5 text-xs leading-relaxed text-satwa-text break-words [overflow-wrap:anywhere]">Tidak ada keterangan tambahan.</p>
            </div>

            <!-- Imbalan -->
            <div class="rounded-xl bg-satwa-bg p-3.5 border border-satwa-line/60 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-satwa-muted">Imbalan Bagi Penemu</p>
                    <p id="modal-reward" class="mt-0.5 text-sm font-semibold text-satwa-terracotta break-words [overflow-wrap:anywhere]">Tanpa imbalan</p>
                </div>
                <span class="rounded-md bg-satwa-card px-2.5 py-1 text-[11px] text-satwa-muted border border-satwa-line">
                    Sesuai Perjanjian
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-2.5 border-t border-satwa-line pt-4 sm:flex-row">
                <a id="modal-wa-btn" href="#" target="_blank" rel="noopener noreferrer" class="primary-btn flex-1 py-2.5">
                    Hubungi Pemilik via WhatsApp
                </a>
                <button id="modal-share-btn" type="button" onclick="shareReportFromModal()" class="secondary-btn py-2.5 gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="18" cy="5" r="2.5"/>
                        <circle cx="6" cy="12" r="2.5"/>
                        <circle cx="18" cy="19" r="2.5"/>
                        <path d="m8.2 10.8 7.6-4.6M8.2 13.2l7.6 4.6"/>
                    </svg>
                    Bagikan
                </button>
                <button onclick="closeDetailModal()" class="secondary-btn py-2.5">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
