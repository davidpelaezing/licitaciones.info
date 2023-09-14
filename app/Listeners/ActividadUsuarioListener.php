<?php

namespace App\Listeners;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ActividadUsuarioListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /** Recupero el usuario Auth::user()*/
        $user = User::where('id', Auth::id())->first();
        /** Registro el tiempo de la actividad */
        $user->update([
            'actividad' => Carbon::now()
        ]);
    }
}
