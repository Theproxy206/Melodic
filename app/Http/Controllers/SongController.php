<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Royalty; // Asegúrate de que el modelo exista y se llame así
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{
    /**
     * Almacena una nueva canción.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'album_id'   => 'required|exists:albums,album_id',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:10240',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $audioPath = $request->file('audio_file')->store('songs/audio', 'public');

        $imagePath = null;
        if ($request->hasFile('cover_file')) {
            $imagePath = $request->file('cover_file')->store('songs/images', 'public');
        }

        Song::create([
            'name'       => $request->name,
            'album_id'   => $request->album_id,
            'file_path'  => $audioPath,
            'image_path' => $imagePath,
            'plays'      => 0,
        ]);

        return redirect()->route('dashboard.artist')
            ->with('success', '¡Canción subida con éxito!');
    }

    /**
     * Registra una reproducción y genera la regalía.
     *
     * @param Request $request
     * @param Song $song
     * @return JsonResponse
     */
    public function registerPlay(Request $request, Song $song)
    {
        DB::transaction(function () use ($song) {

            $song->increment('plays');

            $paymentPerPlay = 0.15;

            $artist = $song->album->artist;
            $recipientId = $artist->label ? $artist->label : $artist->user_id;

            $royalty = Royalty::firstOrCreate(
                ['recipient_id' => $recipientId],
                ['amount' => 0]
            );

            $royalty->amount += $paymentPerPlay;
            $royalty->save();
        });

        return response()->json(['success' => true, 'message' => 'Play registrado']);
    }
}
