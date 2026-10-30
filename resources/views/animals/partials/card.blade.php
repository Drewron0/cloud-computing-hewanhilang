@php
    $title = is_object($animal) ? $animal->title : $animal['title'];
    $reporterName = is_object($animal) ? ($animal->reporter_name ?? 'Pemilik Satwa') : ($animal['reporter_name'] ?? 'Pemilik Satwa');
    $id = is_object($animal) ? $animal->id : $animal['id'];
    $type = is_object($animal) ? $animal->type : $animal['type'];
    $city = is_object($animal) ? ($animal->city ?? 'Surabaya') : ($animal['city'] ?? 'Surabaya');
    $address = is_object($animal) ? ($animal->address_detail ?? $animal->district) : ($animal['address_detail'] ?? $animal['district']);
    $districtLabel = is_object($animal) ? ($animal->district_label ?? ($address ? "{$address}, {$city}" : $city)) : ($animal['district_label'] ?? $city);
    $species = is_object($animal) ? $animal->species : $animal['species'];
    $description = is_object($animal) ? $animal->description : $animal['description'];
    
    // Reward formatting
    $reward = 'Tanpa imbalan';
    $rawReward = is_object($animal) ? ($animal->reward_or_fee ?? $animal->reward_label ?? null) : ($animal['reward_or_fee'] ?? $animal['reward_label'] ?? null);
    if (!empty($rawReward)) {
        $cleanReward = preg_replace('/[^0-9]/', '', $rawReward);
        if (!empty($cleanReward) && (float) $cleanReward > 0) {
            $reward = 'Rp ' . number_format((float) $cleanReward, 0, ',', '.');
        } elseif (!str_contains(strtolower($rawReward), 'tanpa') && !str_contains(strtolower($rawReward), 'tidak')) {
            $reward = $rawReward;
        }
    }

    $code = is_object($animal) ? ($animal->code ?? $animal->identification_code ?? 'Tidak ada') : ($animal['code'] ?? 'Tidak ada');
    $phone = is_object($animal) ? ($animal->phone ?? $animal->contact_phone ?? '') : ($animal['phone'] ?? '');
    $email = is_object($animal) ? ($animal->email ?? '') : ($animal['email'] ?? '');
    $photoUrl = is_object($animal) ? ($animal->photo_url ?? (!empty($animal->photo_path) ? url('storage/' . $animal->photo_path) : null)) : ($animal['photo_url'] ?? null);
    $timeLabel = is_object($animal) ? ($animal->time_label ?? ($animal->created_at ? $animal->created_at->diffForHumans() : 'Baru saja')) : ($animal['time_label'] ?? 'Baru saja');
    $radius = is_object($animal) ? ($animal->radius_km ?? null) : ($animal['radius_km'] ?? null);
@endphp

<article
    class="animal-card card-item panel overflow-hidden shadow-sm flex flex-col justify-between h-full transition-all duration-200"
    data-index="{{ $index ?? 0 }}"
    data-id="{{ $id }}"
    data-type="{{ $type }}"
    data-reporter="{{ $reporterName }}"
    data-location="{{ strtolower($city) }}"
    data-species="{{ $species }}"
    data-title="{{ $title }}"
    data-description="{{ $description }}"
    data-reward="{{ $reward }}"
    data-code="{{ $code }}"
    data-phone="{{ $phone }}"
    data-email="{{ $email }}"
    data-city="{{ $city }}"
    data-address="{{ $address }}"
    data-district="{{ $districtLabel }}"
    data-image="{{ $photoUrl ?? '' }}"
    onclick="openCardDetail(this)"
    tabindex="0"
    onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardDetail(this)}"
    role="button"
    aria-label="Lihat detail {{ $title }}"
>
    <!-- Stacks vertically on mobile (taking top half), horizontal on tablet/desktop -->
    <div class="flex flex-col sm:flex-row sm:items-stretch sm:gap-4 p-3.5 sm:p-4 flex-1">

        <!-- Photo & Time Label Underneath with Error Fallback -->
        <div class="flex flex-col shrink-0 items-center sm:w-32">
            @if ($photoUrl)
                <img
                    src="{{ $photoUrl }}"
                    alt="Foto {{ $title }}"
                    class="w-full h-44 sm:h-28 sm:w-32 rounded-xl object-cover bg-satwa-sand border border-satwa-line"
                    loading="lazy"
                    onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >
                <div class="hidden w-full h-44 sm:h-28 sm:w-32 rounded-xl bg-satwa-sand/70 border border-satwa-line flex-col items-center justify-center p-3 text-satwa-forest/70">
                    <svg class="h-9 w-9 text-satwa-forest/35" viewBox="0 0 40 40" fill="currentColor" aria-hidden="true">
                        <path d="M20 36c-8 0-13-5-13-12 0-5 3-8 5-11 1-2 1-5 0-8 4 1 7 4 7 8 1-3 3-6 6-7-1 4 0 7 2 9 3 3 6 6 6 11 0 6-5 10-13 10Z"/>
                        <circle cx="14.5" cy="24" r="2.3" fill="#FCFAF4"/>
                        <circle cx="20" cy="21" r="2.3" fill="#FCFAF4"/>
                        <circle cx="25.5" cy="24" r="2.3" fill="#FCFAF4"/>
                        <path d="M20 26c-3 0-5 2-5 4 0 2 2 3 5 3s5-1 5-3c0-2-2-4-5-4Z" fill="#FCFAF4"/>
                    </svg>
                    <span class="mt-1.5 text-[9.5px] font-semibold text-satwa-muted uppercase tracking-widest">SatwaTrace</span>
                </div>
            @else
                <!-- Custom SatwaTrace Logo Placeholder when no photo is provided -->
                <div class="w-full h-44 sm:h-28 sm:w-32 rounded-xl bg-satwa-sand/70 border border-satwa-line flex flex-col items-center justify-center p-3 text-satwa-forest/70">
                    <svg class="h-9 w-9 text-satwa-forest/35" viewBox="0 0 40 40" fill="currentColor" aria-hidden="true">
                        <path d="M20 36c-8 0-13-5-13-12 0-5 3-8 5-11 1-2 1-5 0-8 4 1 7 4 7 8 1-3 3-6 6-7-1 4 0 7 2 9 3 3 6 6 6 11 0 6-5 10-13 10Z"/>
                        <circle cx="14.5" cy="24" r="2.3" fill="#FCFAF4"/>
                        <circle cx="20" cy="21" r="2.3" fill="#FCFAF4"/>
                        <circle cx="25.5" cy="24" r="2.3" fill="#FCFAF4"/>
                        <path d="M20 26c-3 0-5 2-5 4 0 2 2 3 5 3s5-1 5-3c0-2-2-4-5-4Z" fill="#FCFAF4"/>
                    </svg>
                    <span class="mt-1.5 text-[9.5px] font-semibold text-satwa-muted uppercase tracking-widest">SatwaTrace</span>
                </div>
            @endif

            <div class="w-full mt-2 text-center">
                <span class="text-[11px] font-normal text-satwa-muted block">{{ $timeLabel }}</span>
            </div>
        </div>

        <!-- Info & Data with Clamped Lines for Predictable Uniform Size -->
        <div class="flex min-w-0 flex-1 flex-col justify-between mt-3 sm:mt-0">
            <div>
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 pr-2">
                        <h3 class="font-heading text-lg font-semibold leading-snug text-satwa-forest line-clamp-1" title="{{ $title }}">
                            {{ $title }}
                        </h3>

                        <p class="mt-1 flex items-center gap-x-1.5 text-xs text-satwa-muted line-clamp-1" title="{{ $districtLabel }}">
                            <svg class="h-3.5 w-3.5 text-satwa-forest shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 22s8-6 8-12a8 8 0 1 0-16 0c0 6 8 12 8 12Zm0-9a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                            </svg>
                            <span class="font-medium text-satwa-forest truncate">{{ $districtLabel }}</span>
                        </p>
                    </div>

                    <!-- Share Button (far right) -->
                    <div class="shrink-0">
                        <button type="button" class="icon-btn" aria-label="Bagikan laporan {{ $title }}" title="Bagikan laporan" onclick="event.stopPropagation(); shareReport({{ $id }})">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="18" cy="5" r="2.5"/>
                                <circle cx="6" cy="12" r="2.5"/>
                                <circle cx="18" cy="19" r="2.5"/>
                                <path d="m8.2 10.8 7.6-4.6M8.2 13.2l7.6 4.6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Description Clamped to 2 lines -->
                <p class="mt-2 text-xs leading-relaxed text-satwa-muted line-clamp-2" title="{{ $description }}">{{ $description }}</p>
            </div>

            <!-- Bottom Row: Species & Reward -->
            <div class="mt-3.5 pt-2.5 border-t border-satwa-line flex items-center justify-between gap-3 text-xs">
                <span class="text-satwa-muted truncate">
                    Spesies: <span class="text-satwa-forest font-medium capitalize">{{ $species }}</span>
                </span>

                <div class="inline-flex items-center gap-1.5 shrink-0">
                    <span class="text-[11px] text-satwa-muted">Imbalan:</span>
                    <span class="font-semibold text-satwa-terracotta truncate max-w-[130px]" title="{{ $reward }}">
                        {{ $reward }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</article>
