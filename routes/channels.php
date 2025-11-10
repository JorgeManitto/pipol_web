<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Canal de notificaciones privadas
|--------------------------------------------------------------------------
|
| Cada usuario escucha su propio canal privado: App.Models.User.{id}
| Por eso verificamos que el usuario autenticado sea el mismo que el del canal.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
