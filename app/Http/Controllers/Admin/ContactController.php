<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest('created_at')->get();
        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contact)
    {
        // Mark as read automatically on open
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'reply_note' => 'required|string',
        ]);

        $contact->update(['status' => 'replied']);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Pesan berhasil ditandai sebagai sudah dibalas.');
    }
}
