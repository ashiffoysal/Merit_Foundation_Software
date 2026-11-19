<?php

namespace App\Http\Controllers\Backend\Academic\Concerns;

use Illuminate\Http\Request;

trait RespondsToAjax
{
    /** JSON for AJAX forms, redirect + flash for normal posts. */
    protected function done(Request $request, string $message, ?string $redirect = null, array $extra = [])
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message, 'redirect' => $redirect] + $extra);
        }

        return ($redirect ? redirect($redirect) : back())->with('success', $message)->with($extra);
    }

    protected function fail(Request $request, string $message, int $status = 422)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return back()->with('error', $message);
    }

    /** Full page on first load, only the table partial when the filters/pagination call via AJAX. */
    protected function listing(Request $request, string $page, string $partial, array $data)
    {
        return view($request->ajax() ? $partial : $page, $data);
    }

    /**
     * Every word must match one of the columns – so "Ali Khan" finds first_name=Ali, last_name=Khan.
     * Works the same on MySQL and SQLite.
     */
    protected function searchWords($query, ?string $term, array $columns, ?\Closure $extra = null)
    {
        foreach (preg_split('/\s+/', trim((string) $term), -1, PREG_SPLIT_NO_EMPTY) as $word) {
            $like = '%' . addcslashes($word, '%_\\') . '%';
            $query->where(function ($q) use ($columns, $like, $extra) {
                foreach ($columns as $c) {
                    $q->orWhere($c, 'like', $like);
                }
                if ($extra) {
                    $extra($q, $like);
                }
            });
        }

        return $query;
    }
}
