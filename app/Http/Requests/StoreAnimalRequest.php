<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation (sanitization & normalization).
     */
    protected function prepareForValidation(): void
    {
        $city = $this->input('city', 'Surabaya');
        $addressDetail = $this->input('address_detail');
        $district = $this->input('district');

        if (empty($district) && ! empty($addressDetail)) {
            $district = $addressDetail;
        }

        $reward = $this->input('reward_or_fee');
        if (is_string($reward)) {
            $cleanReward = preg_replace('/[^0-9]/', '', $reward);
            if (! empty($cleanReward) && (float) $cleanReward > 0) {
                $reward = 'Rp '.number_format((float) $cleanReward, 0, ',', '.');
            }
        }

        $this->merge([
            'type' => 'lost',
            'reporter_name' => is_string($this->reporter_name) ? trim(strip_tags($this->reporter_name)) : null,
            'title' => is_string($this->title) ? trim(strip_tags($this->title)) : $this->title,
            'city' => is_string($city) ? trim(strip_tags($city)) : 'Surabaya',
            'address_detail' => is_string($addressDetail) ? trim(strip_tags($addressDetail)) : null,
            'district' => is_string($district) ? trim(strip_tags($district)) : $district,
            'contact_phone' => is_string($this->contact_phone) ? trim(strip_tags($this->contact_phone)) : $this->contact_phone,
            'email' => is_string($this->email) ? trim(strip_tags(strtolower($this->email))) : $this->email,
            'description' => is_string($this->description) ? trim(strip_tags($this->description)) : $this->description,
            'identification_code' => is_string($this->identification_code) ? trim(strip_tags($this->identification_code)) : null,
            'reward_or_fee' => is_string($reward) ? trim(strip_tags($reward)) : null,
            'temp_photo_path' => is_string($this->temp_photo_path) ? trim(strip_tags($this->temp_photo_path)) : null,
        ]);
    }

    /**
     * Handle a failed validation attempt by preserving uploaded photo to temp disk.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->hasFile('photo') && $this->file('photo')->isValid()) {
            $tempPath = $this->file('photo')->store('temp', 'public');
            session()->flash('temp_photo_path', $tempPath);
        }

        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string', 'in:lost'],
            'reporter_name' => ['nullable', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:150'],
            'species' => ['required', 'string', 'in:kucing,anjing,burung,reptil,mamalia'],
            'city' => ['nullable', 'string', 'max:100'],
            'address_detail' => ['nullable', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s\-()]{8,25}$/'],
            'email' => ['required', 'email', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'identification_code' => ['nullable', 'string', 'max:100'],
            'reward_or_fee' => ['nullable', 'string', 'max:50'],
            'temp_photo_path' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'reporter_name' => 'nama pelapor',
            'title' => 'nama satwa',
            'species' => 'kategori spesies',
            'city' => 'kota',
            'address_detail' => 'detail lokasi / alamat',
            'district' => 'area atau kecamatan',
            'contact_phone' => 'nomor WhatsApp',
            'email' => 'alamat email',
            'description' => 'deskripsi dan kronologi',
            'identification_code' => 'kode identifikasi',
            'reward_or_fee' => 'nominal imbalan',
            'photo' => 'foto satwa',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $photoError = $this->file('photo')?->getError();
        $uploadReason = match ($photoError) {
            \UPLOAD_ERR_INI_SIZE => 'Ukuran berkas melebihi upload_max_filesize di server.',
            \UPLOAD_ERR_FORM_SIZE => 'Ukuran berkas melebihi batas form.',
            \UPLOAD_ERR_PARTIAL => 'Berkas hanya terunggah sebagian.',
            \UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary upload tidak ditemukan.',
            \UPLOAD_ERR_CANT_WRITE => 'Gagal menulis berkas ke folder temporary disk.',
            default => 'Server tidak dapat memproses berkas foto yang diunggah.',
        };

        return [
            'photo.uploaded' => 'Foto satwa gagal diunggah: '.$uploadReason,
            'photo.max' => 'Ukuran foto satwa tidak boleh lebih dari 5 MB.',
            'photo.image' => 'Berkas harus berupa gambar yang valid (JPG, PNG, atau WebP).',
            'contact_phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format angka standar.',
        ];
    }
}
