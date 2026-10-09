{{--
    resources/views/welcome.blade.php

    CARA MENGHUBUNGKAN KE BACKEND NANTI
    -----------------------------------
    1. Blok php di bawah hanya DATA DEMO. Controller cukup mengirim variabel $animals
       dengan field yang sama, lalu hapus blok php tersebut:
           return view('welcome', ['animals' => Animal::latest()->get()]);
    2. Field yang dipakai view ini (samakan dengan kolom migration / accessor model):
         id, type (lost|adopt), title, latin_name, district (slug filter), district_label,
         species (kucing|burung|reptil|mamalia), radius_km, description, reward_label,
         code, phone, photo_url, time_label, map_x, map_y
       - time_label  -> $animal->created_at->diffForHumans()
       - photo_url   -> Storage::url($animal->photo_path)
       - map_x/map_y -> persen posisi pin di peta demo; nanti diganti latitude/longitude
         (Leaflet / Google Maps).
    3. Form "Buat Laporan" sudah memakai @csrf. Ganti action="#" dengan route('animals.store').
    4. Filter masih client-side (JS). Kalau data banyak, pindahkan ke query string
       (?type=&species=&district=&q=) dan proses di controller.
--}}
@php
    $animals = $animals ?? collect([
        [
            'id' => 1, 'type' => 'lost', 'title' => 'Elang Kestrel', 'latin_name' => 'Falco tinnunculus',
            'district' => 'gubeng', 'district_label' => 'Gubeng, Surabaya', 'species' => 'burung', 'radius_km' => 2,
            'description' => 'Memakai Ring Logam BKSDA #88291 di kaki kanan. Jinak, lepas saat latihan rutin di area terbuka Unair.',
            'reward_label' => 'Imbalan: Rp 1.500.000', 'code' => 'BKSDA-RING-88291', 'phone' => '6281234567890',
            'photo_url' => 'https://images.unsplash.com/photo-1543549070-a12ab14905f9?auto=format&fit=crop&w=500&q=85',
            'time_label' => '2 jam lalu', 'map_x' => 33, 'map_y' => 24,
        ],
        [
            'id' => 2, 'type' => 'lost', 'title' => 'Mochi', 'latin_name' => 'Kucing Mainecoon Mix',
            'district' => 'wonokromo', 'district_label' => 'Wonokromo, Surabaya', 'species' => 'kucing', 'radius_km' => 4,
            'description' => 'Warna abu-abu putih, ekor tebal. Memakai kalung merah tanpa kerincingan.',
            'reward_label' => 'Imbalan: Uang Tunai', 'code' => 'Belum memiliki microchip', 'phone' => '6281987654321',
            'photo_url' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=500&q=85',
            'time_label' => '5 jam lalu', 'map_x' => 41, 'map_y' => 55,
        ],
        [
            'id' => 3, 'type' => 'adopt', 'title' => 'Iguana Hijau', 'latin_name' => 'Iguana iguana F2',
            'district' => 'sukolilo', 'district_label' => 'Sukolilo, Surabaya', 'species' => 'reptil', 'radius_km' => null,
            'description' => 'Panjang ~60cm, karakter tenang, nafsu makan baik. Memiliki sertifikat asal-usul penangkaran.',
            'reward_label' => 'Biaya adopsi & sertifikat', 'code' => 'REG-BKSDA-2024-991', 'phone' => '6281122334455',
            'photo_url' => 'https://images.unsplash.com/photo-1500463959177-e0869687df26?auto=format&fit=crop&w=500&q=85',
            'time_label' => '1 hari lalu', 'map_x' => 75, 'map_y' => 33,
        ],
        [
            'id' => 4, 'type' => 'lost', 'title' => 'Lovebird', 'latin_name' => 'Agapornis sp.',
            'district' => 'sukolilo', 'district_label' => 'Sukolilo, Surabaya', 'species' => 'burung', 'radius_km' => 5,
            'description' => 'Hijau kuning, paruh merah. Jinak dan mudah beradaptasi.',
            'reward_label' => 'Imbalan: Rp 500.000', 'code' => 'Tidak ada ring', 'phone' => '6281200000000',
            'photo_url' => 'https://images.unsplash.com/photo-1452570053594-1b985d6ea890?auto=format&fit=crop&w=500&q=85',
            'time_label' => '2 hari lalu', 'map_x' => 62, 'map_y' => 72,
        ],
    ])->map(fn ($a) => (object) $a);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SatwaTrace — Wildlife Registry</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">

    {{-- Sementara pakai CDN. Nanti pindahkan ke Vite (npm run dev) bersama tailwind.config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        satwa: {
                            bg: '#F6F3EA',
                            card: '#FCFAF4',
                            text: '#26302A',
                            muted: '#7B8077',
                            forest: '#1F3A2C',
                            olive: '#5C7455',
                            terracotta: '#C8643F',
                            terracottaDark: '#B5552F',
                            ochre: '#D9A441',
                            sand: '#EFEBDF',
                            line: '#E6E1D3',
                            softgreen: '#E6ECE2',
                            softorange: '#F8EBE2'
                        }
                    },
                    fontFamily: {
                        heading: ['Fraunces', 'Georgia', 'serif'],
                        body: ['DM Sans', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 2px 14px rgba(31, 58, 44, 0.04)',
                        float: '0 12px 35px rgba(31, 58, 44, 0.12)'
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #F6F3EA;
            color: #26302A;
        }

        h1, h2, h3, .font-heading { font-family: 'Fraunces', Georgia, serif; }

        button, input, select, textarea { font: inherit; }
        button { -webkit-tap-highlight-color: transparent; cursor: pointer; }

        .panel {
            background: #FCFAF4;
            border: 1px solid #E6E1D3;
            border-radius: 14px;
        }

        /* ---------- Navbar ---------- */
        .nav-link {
            position: relative;
            padding: 24px 4px;
            color: #3D4A41;
            font-size: 13px;
            font-weight: 600;
            transition: color .2s;
        }
        .nav-link:hover { color: #1F3A2C; }
        .nav-link.active { color: #1F3A2C; }
        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: 0;
            height: 3px;
            border-radius: 3px 3px 0 0;
            background: #1F3A2C;
        }

        .dev-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border: 1px solid #DDD8C9;
            border-radius: 8px;
            background: #FCFAF4;
            color: #1F3A2C;
            font-size: 12px;
            font-weight: 600;
            transition: background .2s;
        }
        .dev-btn:hover { background: #F1EEE3; }

        /* ---------- Form fields ---------- */
        .field {
            width: 100%;
            min-height: 43px;
            padding: 10px 12px;
            background: #FBFAF5;
            border: 1px solid #E2DDCE;
            border-radius: 8px;
            color: #26302A;
            font-size: 13px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .field:focus {
            border-color: #5C7455;
            box-shadow: 0 0 0 3px rgba(92, 116, 85, .12);
        }
        .field::placeholder { color: #A3A59C; }

        .field-label {
            display: block;
            margin-bottom: 7px;
            color: #4B5A4D;
            font-size: 11px;
            font-weight: 700;
        }

        .primary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 18px;
            border: 1px solid #1F3A2C;
            border-radius: 8px;
            background: #1F3A2C;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            transition: background .2s, transform .2s;
        }
        .primary-btn:hover { background: #2D4F3C; transform: translateY(-1px); }

        .secondary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 9px 14px;
            border: 1px solid #E2DDCE;
            border-radius: 8px;
            background: #FCFAF4;
            color: #1F3A2C;
            font-size: 12px;
            font-weight: 700;
            transition: background .2s;
        }
        .secondary-btn:hover { background: #F3F0E5; }

        /* ---------- Filter bar ---------- */
        .type-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 42px;
            padding: 0 18px;
            border: 1px solid #E2DDCE;
            border-radius: 8px;
            background: #FCFAF4;
            color: #26302A;
            font-size: 12.5px;
            font-weight: 700;
            white-space: nowrap;
            transition: all .2s;
        }
        .type-btn:hover { background: #F3F0E5; }
        .type-btn.active-lost {
            color: #fff;
            border-color: #C8643F;
            background: linear-gradient(180deg, #CF6C47, #BD5A35);
            box-shadow: 0 4px 12px rgba(200, 100, 63, .25);
        }
        .type-btn.active-adopt {
            color: #fff;
            border-color: #4F6A4F;
            background: linear-gradient(180deg, #62805F, #4C6649);
            box-shadow: 0 4px 12px rgba(76, 102, 73, .25);
        }

        .select-box {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 44px;
            padding: 0 12px;
            border: 1px solid #E2DDCE;
            border-radius: 8px;
            background: #FCFAF4;
            color: #5C7455;
        }
        .select-box label {
            display: block;
            color: #7B8077;
            font-size: 10px;
            line-height: 1.2;
        }
        .select-box select, .select-box input {
            width: 100%;
            padding: 0;
            border: 0;
            background: transparent;
            color: #26302A;
            font-size: 12px;
            font-weight: 500;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }
        .select-box input::placeholder { color: #8D9187; }
        .select-box:focus-within { border-color: #5C7455; box-shadow: 0 0 0 3px rgba(92,116,85,.1); }

        /* ---------- Animal card ---------- */
        .animal-card {
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s, transform .2s;
        }
        .animal-card:hover {
            border-color: #C9D1C2;
            box-shadow: 0 8px 24px rgba(31, 58, 44, .07);
            transform: translateY(-2px);
        }
        .animal-image {
            width: 122px;
            height: 114px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 10px;
            background: #EFEBDF;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 76px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .04em;
            white-space: nowrap;
        }
        .status-lost  { color: #fff; background: #C8643F; }
        .status-adopt { color: #fff; background: #5C7455; }

        .icon-btn {
            display: flex;
            width: 24px; height: 24px;
            align-items: center;
            justify-content: center;
            border: 1px solid #E2DDCE;
            border-radius: 6px;
            background: #F6F3EA;
            color: #5B6558;
            transition: background .2s;
        }
        .icon-btn:hover { background: #ECE8DB; }

        /* ---------- Map ---------- */
        .map-canvas {
            position: relative;
            overflow: hidden;
            height: 335px;
            border-radius: 10px;
            background: #EFEBDF;
        }
        .map-canvas > svg.map-bg { position: absolute; inset: 0; width: 100%; height: 100%; }

        .map-pin-wrap {
            position: absolute;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            transform: translate(-50%, -100%);
        }
        .map-pin-wrap:hover { z-index: 6; }

        .map-pin {
            position: relative;
            display: flex;
            width: 36px; height: 36px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 50% 50% 50% 0;
            box-shadow: 0 4px 10px rgba(31, 58, 44, .25);
            transform: rotate(-45deg);
            transition: transform .2s;
        }
        .map-pin svg { transform: rotate(45deg); width: 16px; height: 16px; color: #fff; }
        .map-pin:hover { transform: rotate(-45deg) scale(1.1); }
        .map-pin.lost  { background: #C8643F; }
        .map-pin.adopt { background: #5C7455; }

        .map-label {
            position: absolute;
            top: calc(100% + 6px);
            padding: 5px 9px;
            border-radius: 6px;
            background: #fff;
            color: #26302A;
            font-size: 9.5px;
            font-weight: 600;
            line-height: 1.35;
            text-align: center;
            white-space: nowrap;
            box-shadow: 0 3px 10px rgba(31, 58, 44, .1);
        }

        /* ---------- Report form ---------- */
        .form-choice:has(input:checked) { border-color: #5C7455; background: #EFF3EA; }
        .form-choice input { accent-color: #5C7455; }

        .upload-zone {
            border: 1px dashed #BCC5B8;
            border-radius: 10px;
            background: #FBFAF5;
            transition: background .2s, border-color .2s;
        }
        .upload-zone:hover { border-color: #5C7455; background: #EFF3EA; }

        #detail-modal { backdrop-filter: blur(5px); }
        #specs-drawer { box-shadow: -15px 0 50px rgba(0,0,0,.12); }

        .fade-in { animation: fadeIn .22s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-img {
            -webkit-mask-image: linear-gradient(to bottom, #000 80%, transparent 100%);
            mask-image: linear-gradient(to bottom, #000 80%, transparent 100%);
        }

        @media (max-width: 640px) {
            .animal-image { width: 92px; height: 100px; }
            .map-canvas { height: 300px; }
        }
    </style>
</head>

<body class="flex min-h-screen flex-col antialiased">

    <!-- ===================== NAVBAR ===================== -->
    <header class="sticky top-0 z-30 border-b border-satwa-line bg-satwa-bg/95 backdrop-blur-md">
        <div class="mx-auto flex h-[62px] max-w-[1400px] items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

            <a href="#" onclick="switchMainTab('marketplace'); return false;" class="flex shrink-0 items-center gap-3">
                <svg class="h-9 w-9 text-satwa-forest" viewBox="0 0 40 40" fill="currentColor" aria-hidden="true">
                    <path d="M20 36c-8 0-13-5-13-12 0-5 3-8 5-11 1-2 1-5 0-8 4 1 7 4 7 8 1-3 3-6 6-7-1 4 0 7 2 9 3 3 6 6 6 11 0 6-5 10-13 10Z"/>
                    <circle cx="14.5" cy="24" r="2.3" fill="#F6F3EA"/>
                    <circle cx="20" cy="21" r="2.3" fill="#F6F3EA"/>
                    <circle cx="25.5" cy="24" r="2.3" fill="#F6F3EA"/>
                    <path d="M20 26c-3 0-5 2-5 4 0 2 2 3 5 3s5-1 5-3c0-2-2-4-5-4Z" fill="#F6F3EA"/>
                </svg>
                <div>
                    <span class="block font-heading text-[19px] font-semibold leading-tight text-satwa-forest">SatwaTrace</span>
                    <span class="block text-[9px] font-semibold uppercase tracking-[.2em] text-satwa-muted">Wildlife Registry</span>
                </div>
            </a>

            <nav class="hidden items-center gap-10 md:flex">
                <button onclick="switchMainTab('marketplace')" id="tab-btn-marketplace" class="nav-link active">Jelajah Satwa</button>
                <button onclick="switchMainTab('report')" id="tab-btn-report" class="nav-link">Buat Laporan</button>
            </nav>

            <button onclick="toggleSpecsDrawer()" class="dev-btn">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="m8 8-4 4 4 4m8-8 4 4-4 4M14 4l-4 16" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="hidden sm:inline">Developer</span>
            </button>
        </div>

        <nav class="flex border-t border-satwa-line md:hidden">
            <button onclick="switchMainTab('marketplace')" id="tab-btn-marketplace-mob" class="nav-link active flex-1 text-center">Jelajah Satwa</button>
            <button onclick="switchMainTab('report')" id="tab-btn-report-mob" class="nav-link flex-1 text-center">Buat Laporan</button>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-[1400px] flex-1 px-4 pb-10 sm:px-6 lg:px-8">

        <!-- ===================== MARKETPLACE ===================== -->
        <section id="view-marketplace">

            <!-- HERO -->
            <div class="relative flex items-center justify-between gap-6 pb-8 pt-9 sm:pt-11">
                <div class="relative z-10 max-w-xl">
                    <p class="text-[10.5px] font-semibold uppercase tracking-[.3em] text-satwa-forest">
                        Temukan <span class="mx-1.5">•</span> Lindungi <span class="mx-1.5">•</span> Hubungkan
                    </p>
                    <h1 class="mt-5 font-heading text-[34px] font-semibold leading-[1.12] tracking-tight text-satwa-forest sm:text-[42px]">
                        Temukan satwa yang hilang atau jelajahi peluang adopsi.
                    </h1>
                    <p class="mt-5 max-w-md text-[13.5px] leading-6 text-satwa-muted">
                        SatwaTrace adalah platform terpadu untuk pencarian peliharaan yang hilang dan adopsi satwa liar/eksotis legal dengan informasi yang terverifikasi.
                    </p>
                </div>

                <!-- Ilustrasi hero (ganti dengan aset sendiri di public/images bila perlu) -->
                <div class="relative hidden h-[215px] w-[360px] shrink-0 lg:block xl:w-[400px]" aria-hidden="true">
                    <div class="absolute right-[60px] top-[-10px] h-[230px] w-[230px] rounded-full bg-[#E7E8DA]"></div>
                    <img src="https://images.unsplash.com/photo-1543549070-a12ab14905f9?auto=format&fit=crop&w=600&q=85"
                         alt="" class="hero-img absolute right-[78px] top-[-18px] h-[235px] w-[190px] rounded-t-[95px] object-cover">
                    <svg class="absolute bottom-[-6px] left-[10px] h-[120px] w-[150px] text-[#9DAA92]" viewBox="0 0 150 120" fill="currentColor" opacity=".75">
                        <path d="M10 118C0 80 20 40 62 18c4 40-10 80-52 100Z"/>
                        <path d="M50 118C46 80 70 50 112 42c-2 36-20 62-62 76Z" opacity=".8"/>
                        <path d="M85 118c0-26 14-44 40-52 4 26-10 46-40 52Z" opacity=".65"/>
                    </svg>
                    <svg class="absolute bottom-[-6px] right-[-8px] h-[135px] w-[130px] text-[#9DAA92]" viewBox="0 0 130 135" fill="currentColor" opacity=".7">
                        <path d="M120 132C124 90 100 48 58 28c-6 44 10 80 62 104Z"/>
                        <path d="M85 132c4-30-10-56-40-70-4 30 8 56 40 70Z" opacity=".75"/>
                    </svg>
                </div>
            </div>

            <!-- FILTER BAR -->
            <div class="panel p-3 shadow-card sm:p-4">
                <div class="grid grid-cols-1 gap-3 lg:grid-cols-[auto_auto_1fr_1fr_1.1fr] lg:items-center">

                    <button onclick="setMarketplaceCategory('lost')" id="cat-btn-lost" class="type-btn">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="5.5" cy="11" r="2.2"/><circle cx="9.5" cy="6" r="2.2"/><circle cx="14.5" cy="6" r="2.2"/><circle cx="18.5" cy="11" r="2.2"/><path d="M12 12c-3 0-5.5 2.5-5.5 5 0 2 1.7 2.8 3.4 2.4.8-.2 1.4-.4 2.1-.4s1.300.2 2.100.4c1.700.4 3.400-.4 3.400-2.400 0-2.500-2.500-5-5.500-5Z"/></svg>
                        Peliharaan Hilang
                    </button>

                    <button onclick="setMarketplaceCategory('adopt')" id="cat-btn-adopt" class="type-btn">
                        <svg class="h-4 w-4 text-satwa-olive" viewBox="0 0 24 24" fill="currentColor"><path d="M20 3C9 3 4 9 4 15c0 1.500.4 2.800 1 4 1-4 4-7.500 9-9.500-3.500 3-5.500 6-6.500 10.500 1 .6 2.200 1 3.500 1 6 0 10-5.500 9-18Z"/></svg>
                        Adopsi Satwa Legal
                    </button>

                    <div class="select-box">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <div class="min-w-0 flex-1">
                            <label for="filter-location">Lokasi</label>
                            <select id="filter-location" onchange="applyFilters()">
                                <option value="all">Semua wilayah</option>
                                <option value="gubeng">Gubeng</option>
                                <option value="wonokromo">Wonokromo</option>
                                <option value="sukolilo">Sukolilo</option>
                            </select>
                        </div>
                        <svg class="h-3.5 w-3.5 shrink-0 text-satwa-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>

                    <div class="select-box">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><circle cx="5.5" cy="11" r="2.2"/><circle cx="9.500" cy="6" r="2.2"/><circle cx="14.500" cy="6" r="2.2"/><circle cx="18.500" cy="11" r="2.2"/><path d="M12 12c-3 0-5.500 2.500-5.500 5 0 2 1.700 2.800 3.400 2.400.8-.2 1.400-.4 2.100-.4s1.300.2 2.100.4c1.700.4 3.400-.4 3.400-2.400 0-2.500-2.500-5-5.500-5Z"/></svg>
                        <div class="min-w-0 flex-1">
                            <label for="filter-species">Jenis satwa</label>
                            <select id="filter-species" onchange="applyFilters()">
                                <option value="all">Semua spesies</option>
                                <option value="kucing">Kucing / Anjing</option>
                                <option value="burung">Burung / Avian</option>
                                <option value="reptil">Reptil / Eksotis</option>
                                <option value="mamalia">Mamalia kecil</option>
                            </select>
                        </div>
                        <svg class="h-3.5 w-3.5 shrink-0 text-satwa-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>

                    <div class="select-box">
                        <svg class="h-4 w-4 shrink-0 text-satwa-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="m16 16 4 4" stroke-linecap="round"/></svg>
                        <input id="filter-search" oninput="applyFilters()" type="search" placeholder="Cari nama, ring ID, ciri khas..." aria-label="Cari laporan">
                    </div>
                </div>
            </div>

            <!-- LIST + MAP -->
            <div class="mt-6 grid grid-cols-1 items-start gap-5 lg:grid-cols-12">

                <!-- LAPORAN TERBARU -->
                <section class="lg:col-span-7">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <h2 id="active-category-title" class="font-heading text-[22px] font-semibold text-satwa-forest">Laporan Terbaru</h2>
                            <span id="result-count" class="rounded-full border border-satwa-line bg-satwa-card px-2.5 py-1 text-[10px] font-semibold text-satwa-muted">0 laporan</span>
                        </div>
                        <label class="flex items-center gap-1 text-[11px] text-satwa-muted">
                            Urutkan:
                            <select id="sort-order" onchange="applyFilters()" class="cursor-pointer bg-transparent font-semibold text-satwa-forest outline-none">
                                <option value="newest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </label>
                    </div>

                    <div id="cards-container" class="flex flex-col gap-3">

                        @forelse ($animals as $animal)
                            <article
                                class="animal-card card-item panel p-3 shadow-card sm:p-3.5"
                                data-index="{{ $loop->index }}"
                                data-id="{{ $animal->id }}"
                                data-type="{{ $animal->type }}"
                                data-location="{{ $animal->district }}"
                                data-species="{{ $animal->species }}"
                                data-title="{{ $animal->title }}"
                                data-latin="{{ $animal->latin_name }}"
                                data-description="{{ $animal->description }}"
                                data-reward="{{ $animal->reward_label }}"
                                data-code="{{ $animal->code }}"
                                data-phone="{{ $animal->phone }}"
                                data-district="{{ $animal->district_label }}"
                                data-image="{{ $animal->photo_url }}"
                                onclick="openCardDetail(this)"
                                tabindex="0"
                                onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardDetail(this)}"
                                role="button"
                                aria-label="Lihat detail {{ $animal->title }}"
                            >
                                <div class="flex gap-3.5">
                                    <img src="{{ $animal->photo_url }}" alt="Foto {{ $animal->title }}" class="animal-image" loading="lazy">

                                    <div class="flex min-w-0 flex-1 flex-col justify-between">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <h3 class="font-heading text-[17px] font-semibold leading-snug text-satwa-forest">
                                                    {{ $animal->title }}
                                                    <span class="ml-1 font-body text-[11.5px] font-normal text-satwa-muted">({{ $animal->latin_name }})</span>
                                                </h3>
                                                <p class="mt-1.5 flex flex-wrap items-center gap-x-2 text-[10.5px] text-satwa-muted">
                                                    <span class="inline-flex items-center gap-1.5 font-semibold text-satwa-text">
                                                        <svg class="h-3.5 w-3.5 text-satwa-forest" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22s8-6 8-12a8 8 0 1 0-16 0c0 6 8 12 8 12Zm0-9a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                                                        {{ $animal->district_label }}
                                                    </span>
                                                    @if ($animal->radius_km)
                                                        <span>•</span>
                                                        <span>Radius {{ $animal->radius_km }} km</span>
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="hidden shrink-0 flex-col items-end gap-4 sm:flex">
                                                <button type="button" class="icon-btn" aria-label="Bagikan laporan" onclick="event.stopPropagation(); shareReport({{ $animal->id }})">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.200 10.800 7.600-4.600M8.200 13.200l7.600 4.600"/></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <p class="mt-2 line-clamp-2 text-[11.5px] leading-5 text-satwa-muted">{{ $animal->description }}</p>

                                        <div class="mt-2.5 flex items-center justify-between gap-3">
                                            <span class="inline-flex items-center gap-2 text-[11.5px] font-semibold text-satwa-text">
                                                <svg class="h-4 w-4 text-satwa-ochre" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.700 3.100 3 7 3s7-1.300 7-3V6"/><path d="M5 12v6c0 1.700 3.100 3 7 3s7-1.300 7-3v-6"/></svg>
                                                {{ $animal->reward_label }}
                                            </span>

                                            <div class="flex flex-col items-center gap-1.5 sm:hidden">
                                                <span class="status-badge {{ $animal->type === 'lost' ? 'status-lost' : 'status-adopt' }}">{{ $animal->type === 'lost' ? 'HILANG' : 'ADOPSI' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Badge status (desktop) -->
                                    <div class="hidden shrink-0 flex-col items-center justify-center gap-2 pl-1 pr-2 sm:flex" style="min-width: 108px;">
                                        <span class="status-badge {{ $animal->type === 'lost' ? 'status-lost' : 'status-adopt' }}">
                                            {{ $animal->type === 'lost' ? 'HILANG' : 'ADOPSI LEGAL' }}
                                        </span>
                                        <span class="text-[10.5px] text-satwa-muted">{{ $animal->time_label }}</span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            {{-- Tidak ada data dari backend --}}
                        @endforelse

                        <div id="empty-state" class="panel hidden px-5 py-12 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-satwa-sand text-satwa-olive">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><path d="m16 16 4 4" stroke-linecap="round"/></svg>
                            </div>
                            <h3 class="mt-4 font-heading text-base font-semibold text-satwa-forest">Tidak ada hasil ditemukan</h3>
                            <p class="mt-2 text-xs text-satwa-muted">Coba ubah kata kunci atau filter pencarian.</p>
                            <button onclick="resetFilters()" class="secondary-btn mt-4">Reset pencarian</button>
                        </div>
                    </div>
                </section>

                <!-- PETA RADAR -->
                <aside class="flex flex-col gap-3 lg:col-span-5 lg:sticky lg:top-[78px]">

                    <div class="panel p-4 shadow-card">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <h2 class="font-heading text-[19px] font-semibold text-satwa-forest">Peta Radar Lokasi</h2>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-satwa-softgreen px-3 py-1.5 text-[10px] font-semibold text-satwa-forest">
                                <span class="h-1.5 w-1.5 rounded-full bg-satwa-olive"></span>
                                GPS Active
                            </span>
                        </div>

                        <div class="map-canvas" id="map-canvas">
                            <!-- Latar peta demo. Ganti dengan Leaflet / Google Maps saat koordinat sudah ada. -->
                            <svg class="map-bg" viewBox="0 0 560 335" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                                <rect width="560" height="335" fill="#EEEADF"/>
                                <path d="M380 0h180v110c-40 10-70-20-100-30-30-10-60-30-80-80Z" fill="#CFE0E6"/>
                                <path d="M30 150c20-30 60-40 85-20 20 20 5 50-25 60-35 10-75-10-60-40Z" fill="#DDE5CD"/>
                                <path d="M400 215c25-20 70-10 85 20 12 25-15 45-50 42-35-3-55-40-35-62Z" fill="#DDE5CD"/>
                                <path d="M20 270c15-15 45-15 55 5s-10 40-35 38c-25-3-35-25-20-43Z" fill="#DDE5CD"/>
                                <g stroke="#fff" stroke-width="7" stroke-linecap="round" fill="none">
                                    <path d="M-10 120 560 215"/>
                                    <path d="M-10 250 560 100"/>
                                    <path d="M110 -10 250 345"/>
                                    <path d="M330 -10 290 345"/>
                                    <path d="M440 -10 380 345"/>
                                </g>
                                <g stroke="#fff" stroke-width="3.500" stroke-linecap="round" fill="none" opacity=".9">
                                    <path d="M0 60 560 150"/>
                                    <path d="M0 320 560 270"/>
                                    <path d="M200 0 150 335"/>
                                    <path d="M520 130 470 335"/>
                                </g>
                                <circle cx="215" cy="168" r="135" fill="rgba(200,100,63,.04)" stroke="#C8643F" stroke-width="1.200" stroke-dasharray="4 4" opacity=".7"/>
                                <text x="36" y="178" font-size="15" fill="#6B6F64" font-family="DM Sans, sans-serif">Surabaya</text>
                            </svg>

                            @foreach ($animals as $animal)
                                <div class="map-pin-wrap" data-id="{{ $animal->id }}" data-map-type="{{ $animal->type }}" data-map-location="{{ $animal->district }}" style="left: {{ $animal->map_x }}%; top: {{ $animal->map_y }}%;">
                                    <button type="button" class="map-pin {{ $animal->type === 'lost' ? 'lost' : 'adopt' }}" onclick="openMapDetail({{ $animal->id }})" aria-label="Lihat lokasi {{ $animal->title }}">
                                        @if ($animal->species === 'burung')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 5c-3 0-5 1-7 3-1.500-1-3-1-5 0L3 12l4 1c-1 2-1 4 0 6 2-1 3-2 4-4 2 1 5 0 7-3 1.500-2 3-5 3-7Z"/></svg>
                                        @elseif ($animal->species === 'reptil')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 3C9 3 4 9 4 15c0 1.500.4 2.800 1 4 1-4 4-7.500 9-9.500-3.500 3-5.500 6-6.500 10.500 1 .6 2.200 1 3.500 1 6 0 10-5.500 9-18Z"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="5.500" cy="11" r="2.200"/><circle cx="9.500" cy="6" r="2.200"/><circle cx="14.500" cy="6" r="2.200"/><circle cx="18.500" cy="11" r="2.200"/><path d="M12 12c-3 0-5.500 2.500-5.500 5 0 2 1.700 2.800 3.400 2.400.8-.2 1.400-.4 2.100-.4s1.300.2 2.100.4c1.700.4 3.400-.4 3.400-2.400 0-2.500-2.500-5-5.500-5Z"/></svg>
                                        @endif
                                    </button>
                                    <span class="map-label">{{ \Illuminate\Support\Str::before($animal->district_label, ',') }}<br>({{ $animal->title }})</span>
                                </div>
                            @endforeach

                            <div class="absolute bottom-3 left-3 rounded-lg bg-white/90 px-3 py-2 text-[9.5px] font-semibold text-satwa-text shadow-card">
                                <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-satwa-terracotta"></span>Satwa hilang</span>
                                <span class="mt-1.5 flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-satwa-olive"></span>Adopsi legal</span>
                            </div>

                            <div class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-lg bg-white/90 px-2.5 py-1.5 text-[9.5px] font-semibold text-satwa-text shadow-card">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 5 6v6c0 4 3 7 7 9 4-2 7-5 7-9V6l-7-3Z" stroke-linejoin="round"/></svg>
                                Radius peta: 10 KM
                            </div>
                        </div>

                        <div class="mt-3 flex items-center gap-3 rounded-lg bg-satwa-bg px-4 py-3">
                            <svg class="h-5 w-5 shrink-0 text-satwa-forest" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm1 15h-2v-6h2v6Zm0-8h-2V7h2v2Z"/></svg>
                            <p class="text-[11px] leading-5 text-satwa-text">Klik pin pada peta untuk melihat detail lokasi satwa atau laporan yang terdaftar.</p>
                        </div>
                    </div>

                    <div class="panel relative flex items-center justify-between gap-3 overflow-hidden px-4 py-3.5 shadow-card">
                        <div class="flex items-center gap-3">
                            <svg class="h-6 w-6 shrink-0 text-satwa-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 22s8-6 8-12a8 8 0 1 0-16 0c0 6 8 12 8 12Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <div>
                                <p class="text-[12px] font-bold text-satwa-forest">Area Pemantauan</p>
                                <p class="mt-0.5 text-[10.5px] text-satwa-muted">Gubeng, Wonokromo, Sukolilo</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-satwa-sand px-3.5 py-1.5 text-[10.5px] font-semibold text-satwa-forest">Surabaya</span>
                            <svg class="h-10 w-10 text-[#A9B59E]" viewBox="0 0 40 44" fill="currentColor" aria-hidden="true"><path d="M36 42c2-16-6-30-22-36-2 16 4 30 22 36Z"/><path d="M20 42c0-10-6-18-16-20 0 10 6 18 16 20Z" opacity=".7"/></svg>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 rounded-[14px] border border-[#EFDCC9] bg-[#FAF0E4] px-4 py-3.5">
                        <svg class="mt-0.5 h-8 w-8 shrink-0 text-satwa-terracotta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3 5 6v6c0 4 3 7 7 9 4-2 7-5 7-9V6l-7-3Z" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <p class="text-[12px] font-bold text-satwa-forest">Utamakan verifikasi</p>
                            <p class="mt-1 text-[10.5px] leading-5 text-satwa-muted">Periksa identitas pelapor dan dokumen satwa sebelum melakukan transaksi atau serah terima.</p>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <!-- ===================== BUAT LAPORAN ===================== -->
        <section id="view-report" class="hidden space-y-7 pt-9">

            <div>
                <p class="text-[10.5px] font-semibold uppercase tracking-[.3em] text-satwa-forest">Kontribusi Komunitas</p>
                <h1 class="mt-4 font-heading text-[34px] font-semibold leading-tight tracking-tight text-satwa-forest sm:text-[40px]">Buat laporan satwa</h1>
                <p class="mt-3 max-w-xl text-[13.5px] leading-6 text-satwa-muted">Lengkapi informasi berikut agar laporan lebih mudah dikenali dan ditindaklanjuti.</p>
            </div>

            <div class="mx-auto max-w-3xl">
                {{-- TODO backend: ganti action="#" dengan route('animals.store') dan hapus onsubmit demo --}}
                <form action="#" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); alert('Ini masih formulir demo. Hubungkan form ke route Laravel untuk menyimpan laporan.');">
                    @csrf

                    <div class="panel overflow-hidden shadow-card">
                        <div class="border-b border-satwa-line px-5 py-5 sm:px-7">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-satwa-olive">01 / Kategori laporan</p>
                            <h2 class="mt-2 font-heading text-lg font-semibold text-satwa-forest">Apa yang ingin Anda laporkan?</h2>
                            <p class="mt-1 text-xs text-satwa-muted">Pilih jenis laporan yang sesuai.</p>

                            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <label class="form-choice flex cursor-pointer gap-3 rounded-xl border border-satwa-line p-4 transition-colors">
                                    <input type="radio" name="type" value="lost" checked class="mt-1">
                                    <span>
                                        <span class="block text-xs font-bold text-satwa-forest">Peliharaan hilang</span>
                                        <span class="mt-1 block text-[11px] leading-5 text-satwa-muted">Laporkan satwa peliharaan yang hilang atau terpisah dari pemiliknya.</span>
                                    </span>
                                </label>
                                <label class="form-choice flex cursor-pointer gap-3 rounded-xl border border-satwa-line p-4 transition-colors">
                                    <input type="radio" name="type" value="adopt" class="mt-1">
                                    <span>
                                        <span class="block text-xs font-bold text-satwa-forest">Adopsi satwa</span>
                                        <span class="mt-1 block text-[11px] leading-5 text-satwa-muted">Daftarkan satwa dengan dokumen asal-usul dan perizinan yang relevan.</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-6 px-5 py-6 sm:px-7">

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-satwa-olive">02 / Informasi satwa</p>
                                <h2 class="mt-2 font-heading text-base font-semibold text-satwa-forest">Identitas dan karakteristik</h2>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="title" class="field-label">Nama / judul satwa *</label>
                                    <input id="title" type="text" name="title" required maxlength="150" class="field" placeholder="Contoh: Mochi, kucing abu-abu">
                                </div>
                                <div>
                                    <label for="species" class="field-label">Kategori spesies *</label>
                                    <select id="species" name="species" required class="field">
                                        <option value="">Pilih spesies</option>
                                        <option value="kucing">Kucing / Anjing</option>
                                        <option value="burung">Burung / Avian</option>
                                        <option value="reptil">Reptil / Eksotis</option>
                                        <option value="mamalia">Mamalia kecil</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="identification_code" class="field-label">Ring ID / microchip / dokumen</label>
                                    <input id="identification_code" type="text" name="identification_code" maxlength="100" class="field" placeholder="Nomor identifikasi jika tersedia">
                                </div>
                                <div>
                                    <label for="reward_or_fee" class="field-label">Imbalan / biaya adopsi</label>
                                    <input id="reward_or_fee" type="text" name="reward_or_fee" maxlength="100" class="field" placeholder="Contoh: Rp 500.000">
                                </div>
                            </div>

                            <div class="border-t border-satwa-line"></div>

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-satwa-olive">03 / Lokasi dan kontak</p>
                                <h2 class="mt-2 font-heading text-base font-semibold text-satwa-forest">Di mana satwa berada?</h2>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="district" class="field-label">Kecamatan / area *</label>
                                    <input id="district" type="text" name="district" required maxlength="150" class="field" placeholder="Contoh: Gubeng, Surabaya">
                                </div>
                                <div>
                                    <label for="contact_phone" class="field-label">Nomor WhatsApp *</label>
                                    <input id="contact_phone" type="tel" name="contact_phone" required maxlength="20" class="field" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div>
                                <label for="description" class="field-label">Ciri fisik dan deskripsi lengkap *</label>
                                <textarea id="description" name="description" required maxlength="5000" rows="5" class="field resize-y" placeholder="Jelaskan warna, ukuran, tanda khusus, kondisi satwa, atau kronologi kehilangan..."></textarea>
                                <p class="mt-2 text-[10px] text-satwa-muted">Jangan mencantumkan informasi pribadi yang tidak diperlukan.</p>
                            </div>

                            <div class="border-t border-satwa-line"></div>

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-satwa-olive">04 / Dokumentasi</p>
                                <h2 class="mt-2 font-heading text-base font-semibold text-satwa-forest">Foto satwa</h2>
                                <p class="mt-1 text-xs text-satwa-muted">Gunakan foto yang jelas agar satwa mudah dikenali.</p>
                            </div>

                            <label for="photo" class="upload-zone flex cursor-pointer flex-col items-center justify-center px-4 py-8 text-center">
                                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-satwa-softgreen text-satwa-olive">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9" r="1.5"/><path d="m21 15-5-5L5 20" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                <span class="mt-3 text-xs font-bold text-satwa-forest">Pilih foto satwa</span>
                                <span id="photo-name" class="mt-1 text-[11px] text-satwa-muted">JPG, PNG, atau WebP · Maksimal 5 MB</span>
                                <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp" required class="hidden" onchange="handlePhotoChange(this)">
                            </label>

                            <div class="rounded-lg bg-satwa-bg p-4">
                                <p class="text-[11px] leading-5 text-satwa-muted">
                                    <strong class="text-satwa-forest">Catatan:</strong> Pengiriman formulir ini belum terhubung ke database. Route, validasi Laravel, penyimpanan foto, dan verifikasi dokumen perlu diimplementasikan di backend.
                                </p>
                            </div>

                            <button type="submit" class="primary-btn w-full !py-3">
                                Kirim laporan
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- ===================== FOOTER ===================== -->
    <footer class="border-t border-satwa-line">
        <div class="mx-auto flex max-w-[1400px] flex-col gap-3 px-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex items-center gap-2">
                <span class="font-heading text-sm font-semibold text-satwa-forest">SatwaTrace</span>
                <span class="text-[10px] text-satwa-muted">· Wildlife Registry</span>
            </div>
            <p class="text-[10px] leading-5 text-satwa-muted">Platform demonstrasi pencarian dan registrasi satwa.</p>
        </div>
    </footer>

    <!-- ===================== DETAIL MODAL ===================== -->
    <div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-satwa-forest/50 p-4" onclick="if(event.target===this)closeDetailModal()">
        <div class="panel fade-in w-full max-w-lg overflow-hidden shadow-float">
            <div class="flex items-start justify-between gap-4 border-b border-satwa-line p-5 sm:p-6">
                <div>
                    <span id="modal-status" class="status-badge status-lost">DETAIL SATWA</span>
                    <h2 id="modal-title" class="mt-3 font-heading text-xl font-semibold text-satwa-forest">Detail satwa</h2>
                    <p id="modal-location" class="mt-1 text-xs text-satwa-muted">Lokasi</p>
                </div>
                <button onclick="closeDetailModal()" aria-label="Tutup detail" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-satwa-bg text-xl text-satwa-muted hover:bg-satwa-sand">&times;</button>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                <img id="modal-image" src="" alt="Foto satwa" class="hidden max-h-56 w-full rounded-lg object-cover">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-satwa-muted">Kode identifikasi</p>
                    <p id="modal-code" class="mt-1 break-words text-sm font-bold text-satwa-forest">—</p>
                </div>

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-satwa-muted">Keterangan</p>
                    <p id="modal-description" class="mt-2 text-xs leading-6 text-satwa-text">—</p>
                </div>

                <div class="rounded-lg bg-satwa-bg p-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-satwa-muted">Imbalan / biaya adopsi</p>
                    <p id="modal-reward" class="mt-1 text-sm font-bold text-satwa-forest">—</p>
                </div>

                <div class="flex flex-col gap-2 border-t border-satwa-line pt-4 sm:flex-row">
                    <a id="modal-wa-btn" href="#" target="_blank" rel="noopener noreferrer" class="primary-btn flex-1">Hubungi via WhatsApp</a>
                    <button onclick="closeDetailModal()" class="secondary-btn">Tutup detail</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== DEVELOPER DRAWER ===================== -->
    <div id="specs-overlay" onclick="toggleSpecsDrawer()" class="fixed inset-0 z-40 hidden bg-satwa-forest/30 backdrop-blur-[2px]"></div>

    <aside id="specs-drawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-md translate-x-full overflow-y-auto bg-satwa-forest text-white transition-transform duration-300">
        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-white/10 bg-satwa-forest px-5 py-5">
            <div>
                <p class="text-[9px] font-bold uppercase tracking-[.16em] text-satwa-ochre">Developer reference</p>
                <h2 class="mt-1 font-heading text-base font-semibold">Backend Architecture</h2>
            </div>
            <button onclick="toggleSpecsDrawer()" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-xl hover:bg-white/20" aria-label="Tutup panel">&times;</button>
        </div>

        <div class="space-y-6 p-5">
            <div>
                <h3 class="text-xs font-bold text-satwa-ochre">01 / Database migration</h3>
                <p class="mt-1 text-[10px] leading-5 text-white/60">Contoh struktur tabel yang cocok dengan view ini.</p>
                <pre class="mt-3 overflow-x-auto rounded-lg border border-white/10 bg-black/20 p-4 font-mono text-[10px] leading-6 text-emerald-200"><code>Schema::create('animals', function (Blueprint $table) {
    $table->id();
    $table->enum('type', ['lost', 'adopt']);
    $table->string('title');
    $table->string('latin_name')->nullable();
    $table->string('species');
    $table->string('identification_code')->nullable();
    $table->string('district');
    $table->string('district_label');
    $table->unsignedTinyInteger('radius_km')->nullable();
    $table->text('description');
    $table->string('reward_label')->nullable();
    $table->string('contact_phone');
    $table->string('photo_path');
    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();
    $table->timestamps();
});</code></pre>
            </div>

            <div>
                <h3 class="text-xs font-bold text-satwa-ochre">02 / Controller</h3>
                <pre class="mt-3 overflow-x-auto rounded-lg border border-white/10 bg-black/20 p-4 font-mono text-[10px] leading-6 text-amber-100"><code>public function index()
{
    return view('welcome', [
        'animals' => Animal::latest()->get(),
    ]);
}</code></pre>
            </div>

            <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                <p class="text-xs font-bold text-satwa-ochre">Sebelum produksi</p>
                <ul class="mt-2 list-inside list-disc space-y-2 text-[11px] leading-5 text-white/75">
                    <li>Validasi input memakai Laravel Form Request.</li>
                    <li>Simpan foto lewat Laravel Storage, validasi MIME type dan ukuran.</li>
                    <li>Pakai kolom numerik untuk nominal imbalan, bukan string bebas.</li>
                    <li>Verifikasi dokumen dan status legal satwa sebelum listing tayang.</li>
                    <li>Pertimbangkan privasi pelapor sebelum menampilkan nomor kontak.</li>
                    <li>Pindahkan Tailwind CDN ke Vite untuk produksi.</li>
                </ul>
            </div>
        </div>
    </aside>

    <script>
        // 'all' = tampilkan semua laporan. Klik tombol kategori yang sama lagi untuk kembali ke 'all'.
        let activeCategory = 'all';

        const $ = (id) => document.getElementById(id);

        function switchMainTab(tab) {
            const isMarketplace = tab === 'marketplace';

            $('view-marketplace').classList.toggle('hidden', !isMarketplace);
            $('view-report').classList.toggle('hidden', isMarketplace);

            ['marketplace', 'report'].forEach(name => {
                const active = name === tab;
                ['tab-btn-' + name, 'tab-btn-' + name + '-mob'].forEach(id => {
                    $(id).classList.toggle('active', active);
                });
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function setMarketplaceCategory(category) {
            activeCategory = (activeCategory === category) ? 'all' : category;

            $('cat-btn-lost').className = 'type-btn' + (activeCategory === 'lost' ? ' active-lost' : '');
            $('cat-btn-adopt').className = 'type-btn' + (activeCategory === 'adopt' ? ' active-adopt' : '');

            applyFilters();
        }

        function applyFilters() {
            const location = $('filter-location').value;
            const species = $('filter-species').value;
            const search = $('filter-search').value.trim().toLowerCase();
            const oldestFirst = $('sort-order').value === 'oldest';
            const total = document.querySelectorAll('.card-item').length;

            let visibleCount = 0;

            document.querySelectorAll('.card-item').forEach(card => {
                const matches =
                    (activeCategory === 'all' || card.dataset.type === activeCategory) &&
                    (location === 'all' || card.dataset.location === location) &&
                    (species === 'all' || card.dataset.species === species) &&
                    (!search || card.innerText.toLowerCase().includes(search) || (card.dataset.code || '').toLowerCase().includes(search));

                card.classList.toggle('hidden', !matches);
                card.style.order = oldestFirst ? (total - Number(card.dataset.index)) : Number(card.dataset.index);

                if (matches) visibleCount++;
            });

            document.querySelectorAll('.map-pin-wrap').forEach(pin => {
                const matches =
                    (activeCategory === 'all' || pin.dataset.mapType === activeCategory) &&
                    (location === 'all' || pin.dataset.mapLocation === location);

                pin.classList.toggle('hidden', !matches);
            });

            $('result-count').textContent = visibleCount + ' laporan';
            $('empty-state').style.order = 999;
            $('empty-state').classList.toggle('hidden', visibleCount > 0);
        }

        function resetFilters() {
            activeCategory = 'all';
            $('cat-btn-lost').className = 'type-btn';
            $('cat-btn-adopt').className = 'type-btn';
            $('filter-location').value = 'all';
            $('filter-species').value = 'all';
            $('filter-search').value = '';
            $('sort-order').value = 'newest';
            applyFilters();
        }

        function openCardDetail(card) {
            const data = card.dataset;
            const isLost = data.type === 'lost';

            $('modal-title').textContent = data.title + (data.latin ? ' (' + data.latin + ')' : '');
            $('modal-location').textContent = data.district;
            $('modal-description').textContent = data.description;
            $('modal-code').textContent = data.code || '—';
            $('modal-reward').textContent = data.reward || '—';

            $('modal-status').textContent = isLost ? 'PELIHARAAN HILANG' : 'ADOPSI SATWA';
            $('modal-status').className = 'status-badge ' + (isLost ? 'status-lost' : 'status-adopt');

            const image = $('modal-image');
            image.src = data.image;
            image.classList.remove('hidden');

            const phone = (data.phone || '').replace(/\D/g, '');
            $('modal-wa-btn').href =
                'https://wa.me/' + phone + '?text=' +
                encodeURIComponent('Halo, saya melihat laporan satwa "' + data.title + '" di SatwaTrace. Apakah informasi ini masih berlaku?');

            $('detail-modal').classList.remove('hidden');
            $('detail-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function openMapDetail(id) {
            const card = document.querySelector('.card-item[data-id="' + id + '"]');
            if (!card || card.classList.contains('hidden')) return;
            openCardDetail(card);
        }

        function shareReport(id) {
            const card = document.querySelector('.card-item[data-id="' + id + '"]');
            if (!card) return;

            const text = 'Laporan satwa: ' + card.dataset.title + ' — ' + card.dataset.district;

            if (navigator.share) {
                navigator.share({ title: 'SatwaTrace', text: text, url: location.href }).catch(() => {});
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(text + ' ' + location.href);
                alert('Tautan laporan disalin.');
            }
        }

        function closeDetailModal() {
            $('detail-modal').classList.add('hidden');
            $('detail-modal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function toggleSpecsDrawer() {
            const drawer = $('specs-drawer');
            const overlay = $('specs-overlay');
            const isClosed = drawer.classList.contains('translate-x-full');

            drawer.classList.toggle('translate-x-full', !isClosed);
            overlay.classList.toggle('hidden', !isClosed);
            document.body.style.overflow = isClosed ? 'hidden' : '';
        }

        function handlePhotoChange(input) {
            const file = input.files[0];
            const defaultText = 'JPG, PNG, atau WebP · Maksimal 5 MB';

            if (!file) {
                $('photo-name').textContent = defaultText;
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!allowedTypes.includes(file.type) || file.size > 5 * 1024 * 1024) {
                alert('Pilih foto JPG, PNG, atau WebP dengan ukuran maksimal 5 MB.');
                input.value = '';
                $('photo-name').textContent = defaultText;
                return;
            }

            $('photo-name').textContent = file.name;
        }

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                closeDetailModal();

                if (!$('specs-drawer').classList.contains('translate-x-full')) {
                    toggleSpecsDrawer();
                }
            }
        });

        applyFilters();
    </script>
</body>
</html>