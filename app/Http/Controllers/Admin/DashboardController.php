<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'products' => Product::count(),
                'articles' => Article::count(),
                'inquiries_new' => Inquiry::whereNull('read_at')->count(),
                'subscribers' => Subscriber::count(),
            ],
            'latest' => Inquiry::latest()->limit(5)->get(),
        ]);
    }
}
