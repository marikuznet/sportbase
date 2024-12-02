<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    private function uploadFile(Request $request, $filenamePrefix)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file provided'], 400);
        }
        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $directory = 'public/settings/';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $filename = $filenamePrefix . '.' . $file->getClientOriginalExtension();
        $file->storeAs($directory, $filename);

        return response()->json(['message' => ucfirst($filenamePrefix) . ' uploaded successfully']);
    }

    public function uploadImageLogo(Request $request)
    {
        return $this->uploadFile($request, 'logo');
    }

    public function uploadImagePrint(Request $request)
    {
        return $this->uploadFile($request, 'print');
    }

    public function uploadImageSignature(Request $request)
    {
        return $this->uploadFile($request, 'signature');
    }

    public function saveSettings(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:100',
            'phones' => 'nullable|array',
            'email' => 'nullable|email|max:255',
            'site' => 'nullable|max:255',
            'description' => 'nullable|string|max:2000',
            'ur_name' => 'nullable|string|max:50',
            'ur_pre' => 'nullable|string|max:50',
            'ur_title' => 'nullable|string|max:100',
            'tin' => 'nullable|string|max:12',
            'numKpp' => 'nullable|string|max:9',
            'bic' => 'nullable|string|max:9',
            'requisites' => 'nullable|string|max:255',
            'kc' => 'nullable|string|max:20',
            'okpo' => 'nullable|string|max:10',
            'okato' => 'nullable|string|max:11',
            'ogrn' => 'nullable|string|max:13',
            'logo' => 'nullable|string|max:255',
            'print' => 'nullable|string|max:255',
            'signature' => 'nullable|string|max:255',
            'fact_address_id' => 'nullable|integer',
            'ur_address_id' => 'nullable|integer',
        ]);

        SettingsDetail::updateOrCreate(
            ['id' => 1],
            $validatedData
        );

        return response()->json(['message' => 'Settings saved successfully']);
    }

    public function getSettings()
    {
        $settings = SettingsDetail::query()->firstOrFail();
        if ($settings)
            return response()->json(["settings" => $settings]);
        else return response()->json(["settings" => null]);
    }

}
