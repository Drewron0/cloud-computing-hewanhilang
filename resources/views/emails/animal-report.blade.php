@php
    $imageSource = null;
    if (!empty($animal->photo_path)) {
        if (str_starts_with($animal->photo_path, 'http')) {
            $imageSource = $animal->photo_path;
        } else {
            $imageSource = url('storage/' . $animal->photo_path);
        }
    }

    $logoSource = null;
    if (isset($message) && file_exists(public_path('images/logo.png'))) {
        $logoSource = $message->embed(public_path('images/logo.png'));
    } else {
        $logoSource = url('images/logo.png');
    }

    $rewardText = 'Tidak ada';
    if (!empty($animal->reward_or_fee)) {
        $cleanReward = preg_replace('/[^0-9]/', '', $animal->reward_or_fee);
        if (!empty($cleanReward)) {
            $rewardText = 'Rp ' . number_format((float) $cleanReward, 0, ',', '.');
        } else {
            $rewardText = $animal->reward_or_fee;
        }
    }

    $createdTime = ($animal->created_at ?: now())->timezone('Asia/Jakarta');
    $formattedDate = $createdTime->locale('id')->translatedFormat('d F Y');
    $formattedTime = $createdTime->format('H:i') . ' WIB';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Laporan Satwa Hilang: {{ $animal->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Fraunces:opsz,wght@9..144,700&display=swap" rel="stylesheet">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Fraunces:opsz,wght@9..144,700&display=swap');

        body, table, td, p, a {
            font-family: 'DM Sans', 'Google Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        h1, h2, .font-heading {
            font-family: 'Fraunces', 'Baskerville', 'Palatino Linotype', Georgia, serif;
            letter-spacing: -0.02em;
        }

        /* Mobile Responsiveness */
        @media only screen and (max-width: 600px) {
            .wrapper-table {
                padding: 12px 6px !important;
            }
            .card-container {
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 12px !important;
            }
            .card-pad {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .header-logo {
                width: 24px !important;
                height: 24px !important;
            }
            .header-logo-cell {
                width: 24px !important;
                padding-right: 8px !important;
            }
            .header-title {
                font-size: 17px !important;
            }
            .header-subtitle {
                font-size: 10px !important;
            }
            .header-date {
                font-size: 11px !important;
            }
            .header-time {
                font-size: 10px !important;
            }
            .main-heading {
                font-size: 19px !important;
            }
            .photo-wrap {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .field-row {
                display: block !important;
                width: 100% !important;
            }
            .field-label {
                display: block !important;
                width: 100% !important;
                padding: 10px 14px 2px 14px !important;
                font-size: 11px !important;
                color: #60665D !important;
            }
            .field-value {
                display: block !important;
                width: 100% !important;
                padding: 0 14px 10px 14px !important;
                font-size: 14px !important;
                color: #1F3A2C !important;
            }
            .field-divider {
                display: block !important;
                width: 100% !important;
                padding: 0 14px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #FFFFFF; font-family: 'DM Sans', 'Google Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1F3A2C; line-height: 1.6;">

    <!-- Wrapper Canvas: Pure White -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="wrapper-table" style="background-color: #FFFFFF; padding: 32px 16px;">
        <tr>
            <td align="center">

                <!-- Main Card -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="card-container" style="max-width: 580px; width: 100%; background-color: #FCFAF4; border: 1px solid #E6E1D3; border-radius: 16px; overflow: hidden;">
                    
                    <!-- Header with Logo, Brand, and Stacked Date/Time -->
                    <tr>
                        <td class="card-pad" style="padding: 20px 32px 18px 32px; border-bottom: 1px solid #E6E1D3;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td valign="middle" class="header-cell-brand">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td valign="middle" style="padding-right: 10px; width: 32px;" class="header-logo-cell">
                                                    <img src="{{ $logoSource }}" width="32" height="32" alt="SatwaTrace" class="header-logo" style="width: 32px; height: 32px; display: block; border: 0;" />
                                                </td>
                                                <td valign="middle">
                                                    <div class="header-title" style="font-family: 'Fraunces', 'Baskerville', 'Palatino Linotype', Georgia, serif; letter-spacing: -0.02em; font-size: 20px; font-weight: 700; color: #1F3A2C; line-height: 1.1;">
                                                        SatwaTrace
                                                    </div>
                                                    <div class="header-subtitle" style="font-size: 11px; font-weight: 400; color: #60665D; margin-top: 2px;">
                                                        Pencarian Satwa Hilang
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" valign="middle" class="header-cell-time" style="text-align: right;">
                                        <div class="header-date" style="font-size: 12px; font-weight: 400; color: #60665D; line-height: 1.3;">
                                            {{ $formattedDate }}
                                        </div>
                                        <div class="header-time" style="font-size: 11px; font-weight: 400; color: #8C9288; line-height: 1.3; margin-top: 2px;">
                                            {{ $formattedTime }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Opening Message -->
                    <tr>
                        <td class="card-pad" style="padding: 26px 32px 12px 32px;">
                            <h1 class="main-heading" style="margin: 0; font-family: 'Fraunces', 'Baskerville', 'Palatino Linotype', Georgia, serif; letter-spacing: -0.02em; font-size: 22px; font-weight: 700; color: #1F3A2C; line-height: 1.3;">
                                Laporan pencarian {{ $animal->title }} sudah kami terima
                            </h1>
                            <p style="margin: 12px 0 0 0; font-size: 14px; font-weight: 400; color: #60665D; line-height: 1.6;">
                                Halo {{ $animal->reporter_name ?: 'Pelapor' }}, kami ikut prihatin atas hilangnya satwa peliharaan Anda. Informasi yang Anda kirimkan telah tersimpan di sistem SatwaTrace dan dapat dilihat oleh warga di sekitar {{ $animal->city ?? 'Surabaya' }}.
                            </p>
                        </td>
                    </tr>

                    <!-- Photo Section -->
                    @if ($imageSource)
                    <tr>
                        <td class="photo-wrap" style="padding: 12px 32px;">
                            <img src="{{ $imageSource }}" alt="Foto {{ $animal->title }}" style="width: 100%; max-height: 340px; object-fit: cover; border-radius: 10px; border: 1px solid #E6E1D3; display: block;" />
                        </td>
                    </tr>
                    @endif

                    <!-- Data Summary: Stacked with Dividers on Mobile -->
                    <tr>
                        <td class="card-pad" style="padding: 16px 32px 24px 32px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F6F3EA; border: 1px solid #E6E1D3; border-radius: 10px; overflow: hidden;">
                                
                                <!-- Nama Pelapor -->
                                @if (!empty($animal->reporter_name))
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Nama Pelapor
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->reporter_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>
                                @endif

                                <!-- Nama Satwa -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Nama Satwa
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Jenis Spesies -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Jenis Spesies
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ ucfirst($animal->species) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Kota -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Kota
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->city ?? 'Surabaya' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Detail Alamat / Lokasi -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Detail Alamat / Lokasi Terakhir
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->address_detail ?: $animal->district }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Nomor WhatsApp -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Nomor WhatsApp
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->contact_phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Email Pelapor -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Email Pelapor
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Nomor ID / Tanda Khusus -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Nomor ID / Tanda Khusus
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $animal->identification_code ?: 'Tidak ada' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Imbalan -->
                                <tr class="field-row">
                                    <td width="36%" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Imbalan
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C;">
                                        {{ $rewardText }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="field-divider" style="padding: 0 14px; line-height: 1px; font-size: 1px;">
                                        <div style="height: 1px; background-color: #E6E1D3; line-height: 1px; font-size: 1px;">&nbsp;</div>
                                    </td>
                                </tr>

                                <!-- Ciri Fisik & Deskripsi -->
                                <tr class="field-row">
                                    <td width="36%" valign="top" class="field-label" style="padding: 11px 14px; font-size: 12px; font-weight: 400; color: #60665D;">
                                        Ciri Fisik & Deskripsi
                                    </td>
                                    <td class="field-value" style="padding: 11px 14px; font-size: 14px; font-weight: 400; color: #1F3A2C; line-height: 1.5;">
                                        {{ $animal->description }}
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- Friendly Note -->
                    <tr>
                        <td class="card-pad" style="padding: 0 32px 20px 32px;">
                            <p style="margin: 0; font-size: 14px; font-weight: 400; color: #60665D; line-height: 1.6;">
                                Jika ada warga yang mengenali {{ $animal->title }}, mereka dapat langsung menghubungi nomor WhatsApp atau alamat email di atas. Anda juga bisa membagikan informasi ini ke grup warga sekitar tempat tinggal Anda.
                            </p>
                        </td>
                    </tr>

                    <!-- Empathetic Website Link / Action Button -->
                    <tr>
                        <td class="card-pad" style="padding: 0 32px 26px 32px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F6F3EA; border: 1px solid #E6E1D3; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 18px 20px; text-align: center;">
                                        <p style="margin: 0 0 14px 0; font-size: 13px; font-weight: 400; color: #60665D; line-height: 1.5; text-align: center;">
                                            Anda dapat memantau status laporan dan melihat informasi satwa lainnya yang dilaporkan warga melalui portal kami:
                                        </p>
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 0 auto;">
                                            <tr>
                                                <td align="center" style="border-radius: 10px; background-color: #1F3A2C;">
                                                    <a href="{{ config('app.url') }}" target="_blank" style="display: inline-block; padding: 12px 24px; font-family: 'DM Sans', 'Google Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13px; font-weight: 400; color: #FCFAF4; text-decoration: none; border-radius: 10px;">
                                                        Buka Papan Pencarian Satwa
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Centered Footer -->
                    <tr>
                        <td class="card-pad" style="padding: 22px 32px; background-color: #F6F3EA; border-top: 1px solid #E6E1D3; text-align: center;">
                            <p style="margin: 0; font-size: 13px; font-weight: 400; color: #1F3A2C; text-align: center; line-height: 1.5;">
                                Semoga {{ $animal->title }} lekas ditemukan dan kembali berkumpul dengan Anda.
                            </p>
                            <p style="margin: 8px 0 0 0; font-size: 12px; font-weight: 400; color: #60665D; text-align: center;">
                                SatwaTrace - Registrasi dan Pencarian Satwa
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
