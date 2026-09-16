<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ListModel;


class CheckOwner
{

public function handle(Request $request, Closure $next)
{

    // mengambil user yang sedang login
    $userId = auth()->id();


    // mengambil id list dari URL
    $listId = $request->route('id');


    // mencari list berdasarkan id
    $list = ListModel::find($listId);


    // jika list tidak ditemukan
    if(!$list)
    {
        abort(404);
    }


    // cek apakah user adalah pemilik list
    if($list->owner_id != $userId)
    {
        abort(403, 'Tidak memiliki akses');
    }


    return $next($request);

}

}