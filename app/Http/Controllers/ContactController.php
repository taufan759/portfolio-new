<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'project' => 'required|string|max:4000',
        ]);

        Message::create(['name' => $data['name'], 'email' => $data['email'], 'body' => $data['project']]);

        return response()->json(['ok' => true]);
    }
}
