<?php

namespace App\Observers;

use App\Models\Arquivo;
use Illuminate\Support\Facades\Storage;

class ArquivoObserver
{
    /**
     * Handle the Arquivo "created" event.
     */
    public function saving(Arquivo $arquivo): void
    {
        self::setFileAttributes($arquivo);
    }

    /**
     * Handle the Arquivo "updated" event.
     */
    // public function updated(Arquivo $arquivo): void
    // {
    //     self::setFileAttributes($arquivo);
    // }

    /**
     * Handle the Arquivo "deleted" event.
     */
    public function deleted(Arquivo $arquivo): void
    {
        //
    }

    /**
     * Handle the Arquivo "restored" event.
     */
    public function restored(Arquivo $arquivo): void
    {
        //
    }

    /**
     * Handle the Arquivo "force deleted" event.
     */
    public function forceDeleted(Arquivo $arquivo): void
    {
        //
    }

    private static function setFileAttributes(Arquivo $arquivo)
    {
        if ($arquivo->caminho && Storage::disk('local')->exists($arquivo->caminho)) {
            $arquivo->nome = str_replace('speds/', '', $arquivo->caminho);
            $arquivo->extensao = substr($arquivo->nome, strrpos($arquivo->nome, '.') + 1);
        }
    }
}
