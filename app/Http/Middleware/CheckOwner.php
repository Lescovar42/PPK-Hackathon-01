<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;

class CheckOwner
{
    public function handle(Request $request, Closure $next)
    {
        // mengambil user yang sedang login
        $userId = auth()->id();

        // mengambil id list/project dari URL
        $listId = $request->route('id') ?? $request->route('project');

        // mencari list berdasarkan id
        $list = Project::find($listId);

        // jika list tidak ditemukan
        if (! $list) {
            abort(404);
        }

        // cek apakah user adalah pemilik list
        if ($list->owner_id != $userId) {
            abort(403, 'Tidak memiliki akses');
        }

        return $next($request);
    }
}
