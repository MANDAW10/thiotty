<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return view('admin.contacts.show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $request->validate(['reply_content' => 'required|string']);

        $message->update([
            'reply_content' => $request->reply_content,
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Réponse enregistrée.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Message supprimé.');
    }
}
