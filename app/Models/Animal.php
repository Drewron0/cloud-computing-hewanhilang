<?php

namespace App\Models;

use Database\Factories\AnimalFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Animal extends Model
{
    /** @use HasFactory<AnimalFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'reporter_name',
        'title',
        'species',
        'identification_code',
        'reward_or_fee',
        'city',
        'address_detail',
        'district',
        'district_label',
        'radius_km',
        'contact_phone',
        'email',
        'description',
        'photo_path',
        'map_x',
        'map_y',
        'latitude',
        'longitude',
    ];

    /**
     * Get URL for animal photo.
     */
    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): ?string {
                $path = $attributes['photo_path'] ?? null;

                if (! $path) {
                    return null;
                }

                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                    return $path;
                }

                return Storage::url($path);
            },
        );
    }

    /**
     * Get formatted display label for reward.
     */
    protected function rewardLabel(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): string {
                if (! empty($attributes['reward_or_fee'])) {
                    $clean = preg_replace('/[^0-9]/', '', $attributes['reward_or_fee']);
                    if (! empty($clean) && (float) $clean > 0) {
                        return 'Rp '.number_format((float) $clean, 0, ',', '.');
                    }
                    if (str_contains(strtolower($attributes['reward_or_fee']), 'tanpa') || str_contains(strtolower($attributes['reward_or_fee']), 'tidak')) {
                        return 'Tanpa imbalan';
                    }

                    return $attributes['reward_or_fee'];
                }

                return 'Tanpa imbalan';
            },
        );
    }

    /**
     * Get alias for identification code.
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value, array $attributes): string => $attributes['identification_code'] ?? 'Tidak ada',
        );
    }

    /**
     * Get alias for contact phone.
     */
    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value, array $attributes): string => $attributes['contact_phone'] ?? '',
        );
    }

    /**
     * Get human-readable district label.
     */
    protected function districtLabel(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): string {
                $city = $attributes['city'] ?? null;
                $address = $attributes['address_detail'] ?? null;

                if (! empty($address) && ! empty($city)) {
                    return "{$address}, {$city}";
                }

                if (! empty($value)) {
                    return $value;
                }

                $district = $attributes['district'] ?? '';

                return ! empty($district) ? $district : ($city ?? 'Surabaya');
            },
        );
    }

    /**
     * Get human-readable time label.
     */
    protected function timeLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->created_at?->diffForHumans() ?? 'Baru saja',
        );
    }
}
