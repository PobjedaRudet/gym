<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('kontakt');
    }

    public function send(Request $request)
    {
        // Honeypot polje je sakriveno CSS-om pa ga pravi posjetilac ne vidi.
        // Ako je popunjeno, posiljalac je bot - tiho prekidamo bez slanja mailа.
        if ($request->filled('website')) {
            return back()->with('success', 'Hvala! Vaša poruka je uspješno poslana. Javit ćemo Vam se u najkraćem roku.');
        }

        $validated = $request->validate([
            'ime_prezime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:50'],
            'predmet' => ['required', 'string', 'max:100'],
            'poruka' => ['required', 'string', 'max:5000'],
        ], [
            'ime_prezime.required' => 'Molimo unesite ime i prezime.',
            'email.required' => 'Molimo unesite email adresu.',
            'email.email' => 'Email adresa nije ispravna.',
            'predmet.required' => 'Molimo izaberite predmet.',
            'poruka.required' => 'Molimo unesite poruku.',
        ]);

        try {
            Mail::to('besgfitandfight@hotmail.com')->send(new ContactMessageMail($validated));
        } catch (Exception $e) {
            report($e);

            return back()->withErrors([
                'poruka' => 'Trenutno nije moguće poslati poruku. Pokušajte ponovo kasnije ili nas kontaktirajte direktno na +387 38 941 900.',
            ])->withInput();
        }

        return back()->with('success', 'Hvala! Vaša poruka je uspješno poslana. Javit ćemo Vam se u najkraćem roku.');
    }
}
