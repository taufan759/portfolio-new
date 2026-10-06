<?php

/*
 * Floating music player. Streams are loaded only when a visitor presses play (nothing is downloaded before that).
 * These are free internet-radio streams from SomaFM (https://somafm.com). To use your own tracks instead, put MP3 files
 * in public/audio and point 'url' to e.g. '/audio/lofi.mp3'. Set 'enabled' to false to hide the player.
 */
return [
    'enabled' => true,

    'channels' => [
        ['id' => 'lofi', 'name' => 'Lo-Fi Chill', 'icon' => '☕', 'url' => 'https://ice1.somafm.com/groovesalad-128-mp3'],
        ['id' => 'chillhop', 'name' => 'Chillhop', 'icon' => '🎧', 'url' => 'https://ice1.somafm.com/fluid-128-mp3'],
        ['id' => 'jazz', 'name' => 'Jazz Vibes', 'icon' => '🎷', 'url' => 'https://ice1.somafm.com/sonicuniverse-128-mp3'],
        ['id' => 'focus', 'name' => 'Deep Focus', 'icon' => '🧠', 'url' => 'https://ice1.somafm.com/dronezone-128-mp3'],
    ],
];
