<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Mail\AnimalReportMail;
use App\Models\Animal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnimalController extends Controller
{
    /**
     * Display a listing of animals.
     */
    public function index(): View
    {
        $animals = Animal::latest()->get();

        return view('animals.index', [
            'animals' => $animals,
        ]);
    }

    /**
     * Store a newly created animal registration in storage.
     */
    public function store(StoreAnimalRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('animals', 'public');
        } elseif ($request->filled('temp_photo_path')) {
            $tempPath = $request->input('temp_photo_path');
            if (Storage::disk('public')->exists($tempPath)) {
                $newPath = 'animals/'.basename($tempPath);
                Storage::disk('public')->move($tempPath, $newPath);
                $validated['photo_path'] = $newPath;
            }
        }

        $city = $validated['city'] ?? 'Surabaya';
        $address = $validated['address_detail'] ?? ($validated['district'] ?? '');

        $validated['type'] = 'lost';
        $validated['city'] = $city;
        $validated['address_detail'] = $address;
        $validated['district'] = $address ?: $city;
        $validated['district_label'] = ($address && $address !== $city) ? "{$address}, {$city}" : $city;
        $validated['map_x'] = random_int(20, 80);
        $validated['map_y'] = random_int(20, 80);

        $animal = Animal::create($validated);

        Mail::to($animal->email)->send(new AnimalReportMail($animal));

        return redirect()
            ->route('animals.index')
            ->with('success', 'Laporan berhasil dikirim. Satwa Anda kini tercatat di papan pencarian warga.');
    }
}
