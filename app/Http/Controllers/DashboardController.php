<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'totalSuppliers' => Supplier::count(),
            'recentSuppliers' => Supplier::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats
        ]);
    }
}
