<?php
namespace App\Http\Controllers\Traits;

use Carbon\Carbon;


trait SharedTraits {
    public function formatDate($date = null){
        if ($date === null) {
        return Carbon::now()->format('jS F Y');
    }

    return Carbon::parse($date)->format('jS F Y');
    }
}