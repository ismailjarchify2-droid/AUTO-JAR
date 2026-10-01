<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $keys = [
            'company_name', 'company_tagline', 'phone', 'phone_display', 'mobile', 'mobile_display',
            'whatsapp', 'whatsapp_display', 'email', 'address', 'city', 'hours', 'meta_description',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key, '');
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:120'],
            'company_tagline' => ['nullable', 'string', 'max:200'],
            'phone' => ['nullable', 'string', 'max:20'],
            'phone_display' => ['nullable', 'string', 'max:30'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'mobile_display' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'whatsapp_display' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'address' => ['nullable', 'string', 'max:200'],
            'city' => ['nullable', 'string', 'max:80'],
            'hours' => ['nullable', 'string', 'max:120'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Paramètres enregistrés.');
    }
}
