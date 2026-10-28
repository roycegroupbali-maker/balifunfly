<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Subscriber;

class InquiryController extends Controller
{
    public function index()
    {
        return view('admin.inquiries.index', ['inquiries' => Inquiry::latest()->paginate(20)]);
    }

    public function show(Inquiry $inquiry)
    {
        if (! $inquiry->read_at) {
            $inquiry->update(['read_at' => now()]);
        }

        return view('admin.inquiries.show', ['inquiry' => $inquiry]);
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('ok', 'Pesan dihapus.');
    }

    public function subscribers()
    {
        return view('admin.inquiries.subscribers', ['subscribers' => Subscriber::latest()->paginate(50)]);
    }

    public function destroySubscriber(Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('ok', 'Email dihapus dari daftar.');
    }
}
