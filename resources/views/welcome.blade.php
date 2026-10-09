<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatwaTrace - Pencarian & Adopsi Satwa Terintegrasi</title>
    
    <!-- Fonts: Syne (Playful yet Structured Header) & Plus Jakarta Sans (Clean Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        satwa: {
                            bg: '#F9F7F2',        /* Warm Earth Paper */
                            card: '#FFFFFF',
                            text: '#222523',      /* Charcoal */
                            muted: '#5C635E',
                            border: '#1B2A20',    /* Dark Forest Line */
                            terracotta: '#C85A32',/* Primary Accent */
                            olive: '#4A5D4E',     /* Secondary Accent */
                            ochre: '#D99B26',     /* Highlight */
                            sand: '#EFECE6',
                            subtle: '#E4E0D7'
                        }
                    },
                    fontFamily: {
                        heading: ['Syne', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F9F7F2;
            color: #222523;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Syne', sans-serif;
        }
        /* Sharp borders with minimal, precise rounding */
        .box-edge {
            border: 2px solid #1B2A20;
            border-radius: 4px;
        }
        .box-edge-sm {
            border: 1.5px solid #1B2A20;
            border-radius: 3px;
        }
        .shadow-flat {
            box-shadow: 3px 3px 0px #1B2A20;
        }
        .shadow-flat-sm {
            box-shadow: 2px 2px 0px #1B2A20;
        }
        .tab-active {
            background-color: #1B2A20;
            color: #F9F7F2;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- Header / Navbar -->
    <header class="bg-satwa-card border-b-2 border-satwa-border sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Brand Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-satwa-terracotta border-2 border-satwa-border flex items-center justify-center font-heading font-extrabold text-white text-xl">
                        S
                    </div>
                    <div>
                        <span class="font-heading font-extrabold text-xl tracking-tight block leading-none">SatwaTrace</span>
                        <span class="text-xs text-satwa-muted font-medium">Lost & Legal Rescue Registry</span>
                    </div>
                </div>

                <!-- Mode Switcher Tabs -->
                <div class="hidden md:flex bg-satwa-sand p-1 border-2 border-satwa-border">
                    <button onclick="switchMainTab('marketplace')" id="tab-btn-marketplace" class="px-4 py-1.5 font-heading font-bold text-sm tab-active transition-colors">
                        Jelajah & Peta Lokasi
                    </button>
                    <button onclick="switchMainTab('report')" id="tab-btn-report" class="px-4 py-1.5 font-heading font-bold text-sm text-satwa-text hover:bg-satwa-subtle transition-colors">
                        + Buat Laporan / Registrasi
                    </button>
                </div>

                <!-- Specs Drawer Trigger Button -->
                <button onclick="toggleSpecsDrawer()" class="box-edge-sm bg-satwa-ochre/20 hover:bg-satwa-ochre/30 px-3 py-1.5 text-xs font-bold flex items-center gap-1.5 text-satwa-border">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <span>Backend Specs</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Switcher -->
        <div class="flex md:hidden border-t border-satwa-border bg-satwa-sand">
            <button onclick="switchMainTab('marketplace')" id="tab-btn-marketplace-mob" class="flex-1 py-2 font-heading font-bold text-xs text-center border-r border-satwa-border bg-satwa-border text-white">
                Jelajah & Peta
            </button>
            <button onclick="switchMainTab('report')" id="tab-btn-report-mob" class="flex-1 py-2 font-heading font-bold text-xs text-center text-satwa-text">
                + Registrasi Satwa
            </button>
        </div>
    </header>

    <!-- MAIN CONTENT WRAPPER -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- SECTION 1: MARKETPLACE & MAP LOOKUP VIEW -->
        <section id="view-marketplace" class="space-y-6">
            
            <!-- Filter Bar & Mode Toggle -->
            <div class="bg-satwa-card box-edge p-4 shadow-flat">
                <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
                    
                    <!-- Purpose Switcher (Lost vs Legal Rescue) -->
                    <div class="flex border-2 border-satwa-border bg-satwa-bg">
                        <button onclick="setMarketplaceCategory('lost')" id="cat-btn-lost" class="px-4 py-2 text-xs font-heading font-bold bg-satwa-terracotta text-white border-r-2 border-satwa-border flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            Peliharaan Hilang
                        </button>
                        <button onclick="setMarketplaceCategory('adopt')" id="cat-btn-adopt" class="px-4 py-2 text-xs font-heading font-bold text-satwa-text hover:bg-satwa-subtle flex items-center gap-2">
                            Satwa Liar/Eksotis Legal
                        </button>
                    </div>

                    <!-- Filter Controls -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 flex-grow max-w-3xl">
                        <!-- Location Filter -->
                        <div class="relative">
                            <label class="block text-[10px] uppercase font-bold text-satwa-muted mb-0.5">Lokasi & Radius</label>
                            <select id="filter-location" onchange="applyFilters()" class="w-full bg-satwa-bg box-edge-sm px-3 py-1.5 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                                <option value="all">Semua Lokasi (Surabaya & Sekitar)</option>
                                <option value="gubeng">Gubeng (Radius &lt; 3 km)</option>
                                <option value="wonokromo">Wonokromo (Radius &lt; 5 km)</option>
                                <option value="sukolilo">Sukolilo (Radius &lt; 8 km)</option>
                            </select>
                        </div>

                        <!-- Species Filter -->
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-satwa-muted mb-0.5">Jenis Satwa</label>
                            <select id="filter-species" onchange="applyFilters()" class="w-full bg-satwa-bg box-edge-sm px-3 py-1.5 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                                <option value="all">Semua Spesies</option>
                                <option value="kucing">Kucing / Anjing</option>
                                <option value="burung">Burung / Avian</option>
                                <option value="reptil">Reptil / Eksotis</option>
                                <option value="mamalia">Mamalia Kecil</option>
                            </select>
                        </div>

                        <!-- Search Field -->
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-satwa-muted mb-0.5">Cari Spesifik</label>
                            <input type="text" id="filter-search" oninput="applyFilters()" placeholder="Ring ID, Ras, Ciri khas..." class="w-full bg-satwa-bg box-edge-sm px-3 py-1.5 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Grid Layout: Map & Cards Split -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Left/Main: Cards Listing (7 cols) -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="flex justify-between items-center">
                        <h2 class="font-heading font-bold text-lg text-satwa-border flex items-center gap-2">
                            <span id="active-category-title">Daftar Peliharaan Hilang</span>
                            <span id="result-count" class="text-xs bg-satwa-sand px-2 py-0.5 box-edge-sm font-body font-bold">4 Kasus</span>
                        </h2>
                        <span class="text-xs text-satwa-muted">Urutkan: **Terbaru**</span>
                    </div>

                    <!-- Items Container -->
                    <div id="cards-container" class="space-y-3">
                        <!-- Card Item 1 (Lost) -->
                        <div class="card-item bg-satwa-card box-edge p-4 shadow-flat hover:translate-x-0.5 hover:-translate-y-0.5 transition-transform cursor-pointer" data-type="lost" data-location="gubeng" data-species="burung" onclick="openDetailModal('Elang Kestrel / Ring BKSDA #882', 'Gubeng, Surabaya', 'Hilang sejak 2 hari lalu di sekitar Rektorat Unair C.', 'Rp 1.500.000', 'BKSDA-RING-88291', '081234567890')">
                            <div class="flex gap-4">
                                <img src="https://images.unsplash.com/photo-1543549070-a12ab14905f9?auto=format&fit=crop&w=200&q=80" alt="Satwa" class="w-24 h-24 object-cover box-edge-sm flex-shrink-0">
                                <div class="flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-heading font-bold text-base text-satwa-text">Elang Kestrel (Falco tinnunculus)</h3>
                                            <span class="text-[11px] font-bold text-satwa-terracotta bg-satwa-terracotta/10 px-2 py-0.5 box-edge-sm">HILANG</span>
                                        </div>
                                        <p class="text-xs text-satwa-muted font-medium mt-1">Gubeng, Surabaya • Radius 2 km</p>
                                        <p class="text-xs text-satwa-text mt-2 line-clamp-2">Memakai Ring Logam BKSDA #88291 di kaki kanan. Jinak, lepas saat latihan rutin di area terbuka Unair.</p>
                                    </div>
                                    <div class="flex justify-between items-center mt-3 pt-2 border-t border-satwa-subtle text-xs">
                                        <span class="font-bold text-satwa-olive">Imbalan: Rp 1.500.000</span>
                                        <span class="text-satwa-muted font-medium">2 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Item 2 (Lost) -->
                        <div class="card-item bg-satwa-card box-edge p-4 shadow-flat hover:translate-x-0.5 hover:-translate-y-0.5 transition-transform cursor-pointer" data-type="lost" data-location="wonokromo" data-species="kucing" onclick="openDetailModal('Mochi - Kucing Mainecoon', 'Wonokromo, Surabaya', 'Hilang dari pekarangan rumah dekat Stasiun Wonokromo.', 'Imbalan Sepadan', 'Non-Microchip', '081987654321')">
                            <div class="flex gap-4">
                                <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=200&q=80" alt="Kucing" class="w-24 h-24 object-cover box-edge-sm flex-shrink-0">
                                <div class="flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-heading font-bold text-base text-satwa-text">Mochi (Kucing Mainecoon Mix)</h3>
                                            <span class="text-[11px] font-bold text-satwa-terracotta bg-satwa-terracotta/10 px-2 py-0.5 box-edge-sm">HILANG</span>
                                        </div>
                                        <p class="text-xs text-satwa-muted font-medium mt-1">Wonokromo, Surabaya • Radius 4 km</p>
                                        <p class="text-xs text-satwa-text mt-2 line-clamp-2">Warna abu-abu putih, ekor tebal. Memakai kalung merah tanpa kerincingan.</p>
                                    </div>
                                    <div class="flex justify-between items-center mt-3 pt-2 border-t border-satwa-subtle text-xs">
                                        <span class="font-bold text-satwa-olive">Imbalan: Uang Tunai</span>
                                        <span class="text-satwa-muted font-medium">5 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Item 3 (Adoptable Legal Wildlife) -->
                        <div class="card-item bg-satwa-card box-edge p-4 shadow-flat hover:translate-x-0.5 hover:-translate-y-0.5 transition-transform cursor-pointer hidden" data-type="adopt" data-location="sukolilo" data-species="reptil" onclick="openDetailModal('Iguana Hijau F2 Legal', 'Sukolilo, Surabaya', 'Hasil penangkaran legal F2, siap adopsi dengan dokumen serah terima.', 'Biaya Adopsi & Sertifikat', 'REG-BKSDA-2024-991', '081122334455')">
                            <div class="flex gap-4">
                                <img src="https://images.unsplash.com/photo-1500463959177-e0869687df26?auto=format&fit=crop&w=200&q=80" alt="Iguana" class="w-24 h-24 object-cover box-edge-sm flex-shrink-0">
                                <div class="flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-heading font-bold text-base text-satwa-text">Iguana Hijau (Iguana iguana F2)</h3>
                                            <span class="text-[11px] font-bold text-satwa-olive bg-satwa-olive/10 px-2 py-0.5 box-edge-sm">ADOPSI LEGAL</span>
                                        </div>
                                        <p class="text-xs text-satwa-muted font-medium mt-1">Sukolilo, Surabaya • Penangkaran Izin F2</p>
                                        <p class="text-xs text-satwa-text mt-2 line-clamp-2">Panjang ~60cm, karakter tenang, nafsu makan baik. Memiliki sertifikat asal-usul penangkaran.</p>
                                    </div>
                                    <div class="flex justify-between items-center mt-3 pt-2 border-t border-satwa-subtle text-xs">
                                        <span class="font-bold text-satwa-terracotta">Dokumen Lengkap</span>
                                        <span class="text-satwa-muted font-medium">1 hari yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right: Map Interface Mockup (5 cols) -->
                <div class="lg:col-span-5">
                    <div class="bg-satwa-card box-edge p-4 shadow-flat sticky top-20">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-heading font-bold text-sm text-satwa-text">Peta Radar Lokasi</h3>
                            <span class="text-[10px] font-bold bg-satwa-sand px-2 py-0.5 box-edge-sm">GPS Active</span>
                        </div>

                        <!-- Map Graphical Canvas Area -->
                        <div class="relative bg-[#E3E8E3] box-edge h-80 overflow-hidden flex items-center justify-center">
                            <!-- Background Map Grid Pattern -->
                            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#1B2A20_1px,transparent_1px)] [background-size:16px_16px]"></div>
                            
                            <!-- Vector Road Lines Simulation -->
                            <svg class="absolute inset-0 w-full h-full stroke-satwa-border/20 fill-none" stroke-width="2">
                                <path d="M -20 100 Q 150 120 400 80 T 600 200" />
                                <path d="M 120 -20 L 180 350" />
                                <path d="M 280 -20 L 220 350" />
                                <circle cx="200" cy="180" r="90" class="stroke-satwa-terracotta/30 stroke-dashed" stroke-dasharray="4" />
                            </svg>

                            <!-- Interactive Pins -->
                            <div class="absolute top-1/3 left-1/3 group cursor-pointer" onclick="alert('Lokasi: Gubeng - Elang Kestrel Hilang')">
                                <div class="w-7 h-7 bg-satwa-terracotta border-2 border-satwa-border text-white flex items-center justify-center font-bold text-xs shadow-flat-sm group-hover:scale-110 transition-transform">
                                    🦅
                                </div>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-satwa-border text-white text-[10px] px-2 py-1 whitespace-nowrap z-10">
                                    Gubeng (Elang Kestrel)
                                </div>
                            </div>

                            <div class="absolute top-1/2 right-1/4 group cursor-pointer" onclick="alert('Lokasi: Wonokromo - Kucing Mochi Hilang')">
                                <div class="w-7 h-7 bg-satwa-terracotta border-2 border-satwa-border text-white flex items-center justify-center font-bold text-xs shadow-flat-sm group-hover:scale-110 transition-transform">
                                    🐱
                                </div>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-satwa-border text-white text-[10px] px-2 py-1 whitespace-nowrap z-10">
                                    Wonokromo (Mochi)
                                </div>
                            </div>

                            <div class="absolute bottom-1/4 left-1/2 group cursor-pointer" onclick="alert('Lokasi: Sukolilo - Adopsi Iguana F2')">
                                <div class="w-7 h-7 bg-satwa-olive border-2 border-satwa-border text-white flex items-center justify-center font-bold text-xs shadow-flat-sm group-hover:scale-110 transition-transform">
                                    🦎
                                </div>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-satwa-border text-white text-[10px] px-2 py-1 whitespace-nowrap z-10">
                                    Sukolilo (Iguana Legal)
                                </div>
                            </div>

                            <!-- Map Label Footer -->
                            <div class="absolute bottom-2 left-2 bg-satwa-card/90 border border-satwa-border px-2 py-1 text-[10px] font-bold">
                                Radius Peta: 10 KM Surabaya
                            </div>
                        </div>

                        <p class="text-xs text-satwa-muted mt-3">
                            Klik pin pada peta untuk meninjau titik koordinat perkiraan lokasi satwa terlihat atau dilaporkan hilang.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION 2: REGISTRATION / REPORT FORM VIEW -->
        <section id="view-report" class="space-y-6 hidden">
            
            <div class="max-w-3xl mx-auto bg-satwa-card box-edge p-6 shadow-flat">
                
                <div class="border-b-2 border-satwa-border pb-4 mb-6">
                    <h2 class="font-heading font-extrabold text-xl text-satwa-border">Formulir Registrasi & Laporan Satwa</h2>
                    <p class="text-xs text-satwa-muted mt-1">Didesain lengkap dengan struktur nama input yang siap dihubungkan ke Laravel Request Validation & Database Migration.</p>
                </div>

                <!-- Form Setup Ready for Laravel Blade Directive -->
                <form action="#" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); alert('Simulasi: Laporan berhasil dikirim ke database!');">
                    <!-- @csrf directive mock -->
                    
                    <div class="space-y-5">
                        
                        <!-- Laporan Type Choice -->
                        <div>
                            <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-2">Jenis Laporan *</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="border-2 border-satwa-border p-3 cursor-pointer bg-satwa-bg flex items-center gap-2 hover:bg-satwa-sand">
                                    <input type="radio" name="report_type" value="lost" checked class="accent-satwa-terracotta">
                                    <div>
                                        <span class="block font-heading font-bold text-xs">Peliharaan Hilang</span>
                                        <span class="block text-[10px] text-satwa-muted">Laporkan satwa peliharaan yang lepas</span>
                                    </div>
                                </label>
                                <label class="border-2 border-satwa-border p-3 cursor-pointer bg-satwa-bg flex items-center gap-2 hover:bg-satwa-sand">
                                    <input type="radio" name="report_type" value="adopt" class="accent-satwa-olive">
                                    <div>
                                        <span class="block font-heading font-bold text-xs">Adopsi Satwa Legal</span>
                                        <span class="block text-[10px] text-satwa-muted">Registrasi satwa eksotis/penangkaran</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Nama / Judul Satwa *</label>
                                <input type="text" name="title" required placeholder="Contoh: Kestrel Ring #882 atau Kucing Mochi" class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                            </div>
                            <div>
                                <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Kategori / Spesies *</label>
                                <select name="species" required class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                                    <option value="">-- Pilih Spesies --</option>
                                    <option value="kucing">Kucing / Anjing</option>
                                    <option value="burung">Burung / Avian</option>
                                    <option value="reptil">Reptil / Eksotis</option>
                                    <option value="mamalia">Mamalia Kecil</option>
                                </select>
                            </div>
                        </div>

                        <!-- Identification Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Nomor Ring / Microchip / Dokumen</label>
                                <input type="text" name="identification_code" placeholder="Contoh: BKSDA-RING-88291 (Jika ada)" class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                                <span class="text-[10px] text-satwa-muted mt-0.5 block">Wajib untuk satwa eksotis yang dilindungi/hasil penangkaran F2.</span>
                            </div>
                            <div>
                                <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Imbalan / Biaya Adopsi (Opsional)</label>
                                <input type="text" name="reward_or_fee" placeholder="Contoh: Rp 1.000.000 atau Gratis Adopsi" class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                            </div>
                        </div>

                        <!-- Location & Map Picker Simulation -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Kecamatan / Area Hilang/Lokasi *</label>
                                <input type="text" name="district" required placeholder="Contoh: Gubeng, Surabaya" class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                            </div>
                            <div>
                                <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Nomor WhatsApp Kontak *</label>
                                <input type="text" name="contact_phone" required placeholder="08123456789" class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border">
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Ciri-Ciri Fisik & Deskripsi Lengkap *</label>
                            <textarea name="description" rows="3" required placeholder="Jelaskan warna bulu/sisik, tanda khusus, riwayat kesehatan, atau kronologi hilang..." class="w-full bg-satwa-bg box-edge-sm p-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-satwa-border"></textarea>
                        </div>

                        <!-- Photo Upload Area -->
                        <div>
                            <label class="block font-heading font-bold text-xs text-satwa-border uppercase mb-1">Foto Satwa *</label>
                            <div class="border-2 border-dashed border-satwa-border p-4 bg-satwa-bg text-center cursor-pointer hover:bg-satwa-sand transition-colors">
                                <svg class="w-8 h-8 mx-auto text-satwa-muted mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs font-bold block text-satwa-text">Klik untuk unggah foto satwa</span>
                                <span class="text-[10px] text-satwa-muted">JPG, PNG maksimal 5MB</span>
                                <input type="file" name="photo" class="hidden">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-satwa-terracotta text-white font-heading font-bold text-sm py-3 box-edge shadow-flat hover:bg-satwa-terracotta/90 transition-colors">
                                Publish Laporan Ke Database
                            </button>
                        </div>

                    </div>
                </form>

            </div>

        </section>

    </main>

    <!-- DETAIL MODAL -->
    <div id="detail-modal" class="fixed inset-0 bg-satwa-border/70 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-satwa-card box-edge p-6 max-w-lg w-full shadow-flat space-y-4">
            <div class="flex justify-between items-start border-b border-satwa-subtle pb-3">
                <div>
                    <h3 id="modal-title" class="font-heading font-bold text-lg text-satwa-text">Detail Satwa</h3>
                    <p id="modal-location" class="text-xs text-satwa-muted font-medium">Lokasi</p>
                </div>
                <button onclick="closeDetailModal()" class="text-satwa-text font-bold text-lg hover:text-satwa-terracotta">&times;</button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <span class="font-bold text-satwa-muted uppercase block text-[10px]">Kode Identifikasi / Ring:</span>
                    <span id="modal-code" class="font-bold text-satwa-text text-sm">--</span>
                </div>
                <div>
                    <span class="font-bold text-satwa-muted uppercase block text-[10px]">Keterangan:</span>
                    <p id="modal-description" class="text-satwa-text leading-relaxed">--</p>
                </div>
                <div>
                    <span class="font-bold text-satwa-muted uppercase block text-[10px]">Nilai Imbalan / Status:</span>
                    <span id="modal-reward" class="font-bold text-satwa-olive text-sm">--</span>
                </div>
            </div>

            <div class="pt-3 border-t border-satwa-subtle flex gap-2">
                <a id="modal-wa-btn" href="#" target="_blank" class="flex-1 bg-satwa-olive text-white text-center font-heading font-bold py-2 box-edge-sm text-xs hover:bg-satwa-olive/90">
                    Hubungi via WhatsApp
                </a>
                <button onclick="closeDetailModal()" class="px-4 bg-satwa-sand text-satwa-text font-bold text-xs box-edge-sm hover:bg-satwa-subtle">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- BACKEND SPECS DRAWER (SLIDE-OVER FOR DEVELOPER INTEGRATION) -->
    <div id="specs-drawer" class="fixed inset-y-0 right-0 w-full sm:w-96 bg-satwa-border text-satwa-bg z-50 p-6 overflow-y-auto transform translate-x-full transition-transform duration-300">
        <div class="flex justify-between items-center pb-4 border-b border-satwa-bg/20">
            <h3 class="font-heading font-bold text-base text-satwa-ochre">Laravel Backend Architecture</h3>
            <button onclick="toggleSpecsDrawer()" class="text-satwa-bg font-bold text-xl hover:text-satwa-terracotta">&times;</button>
        </div>

        <div class="mt-4 space-y-5 text-xs">
            <div>
                <p class="font-bold text-satwa-ochre mb-1">// Proposed Migration Table (`animals`)</p>
                <pre class="bg-black/40 p-3 border border-satwa-subtle/30 text-emerald-400 font-mono text-[10px] rounded-sm overflow-x-auto">
Schema::create('animals', function (Blueprint $table) {$table->id();
    $table->enum('type', ['lost', 'adopt']);$table->string('title');
    $table->string('species');$table->string('identification_code')->nullable();
    $table->string('district');$table->text('description');
    $table->string('reward_or_fee')->nullable();$table->string('contact_phone');
    $table->string('photo_path');$table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();$table->timestamps();
});</pre>
            </div>

            <div>
                <p class="font-bold text-satwa-ochre mb-1">// Controller Method Example</p>
                <pre class="bg-black/40 p-3 border border-satwa-subtle/30 text-amber-300 font-mono text-[10px] rounded-sm overflow-x-auto">
public function index(Request $request) {$query = Animal::query();
    
    if ($request->has('type')) {
        $query->where('type',$request->type);
    }
    
    $animals =$query->latest()->get();
    return view('welcome', compact('animals'));
}</pre>
            </div>

            <div>
                <p class="font-bold text-satwa-ochre mb-1">// Blade Card Loop Example</p>
                <pre class="bg-black/40 p-3 border border-satwa-subtle/30 text-amber-300 font-mono text-[10px] rounded-sm overflow-x-auto">
@verbatim
@forelse($animals as$animal)
    <div class="bg-white border border-satwa-border p-4">
        <h3>{{ $animal->title }}</h3>
        <p>{{ $animal->district }}</p>
    </div>
@empty
    <p>Belum ada laporan.</p>
@endforelse
@endverbatim</pre>
            </div>
        </div>
    </div>

    <!-- JavaScript Interactivity -->
    <script>
        // Main Tab Switcher
        function switchMainTab(tab) {
            const viewMarketplace = document.getElementById('view-marketplace');
            const viewReport = document.getElementById('view-report');
            const btnMarketplace = document.getElementById('tab-btn-marketplace');
            const btnReport = document.getElementById('tab-btn-report');
            const btnMarketplaceMob = document.getElementById('tab-btn-marketplace-mob');
            const btnReportMob = document.getElementById('tab-btn-report-mob');

            if (tab === 'marketplace') {
                viewMarketplace.classList.remove('hidden');
                viewReport.classList.add('hidden');
                
                btnMarketplace.classList.add('tab-active');
                btnMarketplace.classList.remove('text-satwa-text');
                btnReport.classList.remove('tab-active');
                btnReport.classList.add('text-satwa-text');

                btnMarketplaceMob.classList.add('bg-satwa-border', 'text-white');
                btnReportMob.classList.remove('bg-satwa-border', 'text-white');
            } else {
                viewMarketplace.classList.add('hidden');
                viewReport.classList.remove('hidden');
                
                btnReport.classList.add('tab-active');
                btnReport.classList.remove('text-satwa-text');
                btnMarketplace.classList.remove('tab-active');
                btnMarketplace.classList.add('text-satwa-text');

                btnReportMob.classList.add('bg-satwa-border', 'text-white');
                btnMarketplaceMob.classList.remove('bg-satwa-border', 'text-white');
            }
        }

        // Category Filter (Lost vs Adopt)
        let activeCategory = 'lost';
        function setMarketplaceCategory(cat) {
            activeCategory = cat;
            const btnLost = document.getElementById('cat-btn-lost');
            const btnAdopt = document.getElementById('cat-btn-adopt');
            const title = document.getElementById('active-category-title');

            if (cat === 'lost') {
                btnLost.className = "px-4 py-2 text-xs font-heading font-bold bg-satwa-terracotta text-white border-r-2 border-satwa-border flex items-center gap-2";
                btnAdopt.className = "px-4 py-2 text-xs font-heading font-bold text-satwa-text hover:bg-satwa-subtle flex items-center gap-2";
                title.innerText = "Daftar Peliharaan Hilang";
            } else {
                btnAdopt.className = "px-4 py-2 text-xs font-heading font-bold bg-satwa-olive text-white border-l-2 border-satwa-border flex items-center gap-2";
                btnLost.className = "px-4 py-2 text-xs font-heading font-bold text-satwa-text hover:bg-satwa-subtle flex items-center gap-2";
                title.innerText = "Satwa Liar/Eksotis Legal Siap Adopsi";
            }

            applyFilters();
        }

        // Combined Filter Handler
        function applyFilters() {
            const location = document.getElementById('filter-location').value;
            const species = document.getElementById('filter-species').value;
            const search = document.getElementById('filter-search').value.toLowerCase();
            const cards = document.querySelectorAll('.card-item');

            let visibleCount = 0;

            cards.forEach(card => {
                const cardType = card.getAttribute('data-type');
                const cardLoc = card.getAttribute('data-location');
                const cardSpec = card.getAttribute('data-species');
                const cardText = card.innerText.toLowerCase();

                const matchType = (cardType === activeCategory);
                const matchLoc = (location === 'all' || cardLoc === location);
                const matchSpec = (species === 'all' || cardSpec === species);
                const matchSearch = (search === '' || cardText.includes(search));

                if (matchType && matchLoc && matchSpec && matchSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            document.getElementById('result-count').innerText = visibleCount + " Kasus";
        }

        // Modal Controls
        function openDetailModal(title, loc, desc, reward, code, phone) {
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-location').innerText = loc;
            document.getElementById('modal-description').innerText = desc;
            document.getElementById('modal-reward').innerText = reward;
            document.getElementById('modal-code').innerText = code;
            document.getElementById('modal-wa-btn').href = "https://wa.me/" + phone;
            document.getElementById('detail-modal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Backend Specs Drawer Toggle
        function toggleSpecsDrawer() {
            const drawer = document.getElementById('specs-drawer');
            drawer.classList.toggle('translate-x-full');
        }
    </script>
</body>
</html>