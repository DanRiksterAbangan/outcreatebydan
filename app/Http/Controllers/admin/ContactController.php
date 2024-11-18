<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Admin All Contacts
    public function index() {
        $contacts = Contact::orderBy('created_at','DESC')
                        // ->with('subject','name','email','message')
                        ->paginate(10);

        return view('admin.contacts.contacts-list',[
            'contacts' => $contacts,
        ]);
    }

    // Delete Contact
    public function destroyContact(Request $request) {
        $id = $request->id;

        $contact = Contact::find($id);

        if ($contact == null) {
            session()->flash('error','Contact Message Not Found!');
            return response()->json([
                'status' => false,
            ]);
        }

        $contact->delete();
        session()->flash('success','Contact Message Deleted Successfully!');
        return response()->json([
            'status' => true,
        ]);
    }
}
