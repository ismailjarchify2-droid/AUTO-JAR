<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\PartRequest;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products' => Product::query()->count(),
            'available' => Product::query()->where('availability', 'available')->count(),
            'out_of_stock' => Product::query()->where('availability', 'out_of_stock')->count(),
            'requests' => PartRequest::query()->count(),
            'pending_requests' => PartRequest::query()->where('status', 'pending')->count(),
            'messages' => ContactMessage::query()->where('is_read', false)->count(),
        ];

        $recentRequests = PartRequest::query()->latest()->take(5)->get();
        $recentMessages = ContactMessage::query()->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentMessages'));
    }
}
