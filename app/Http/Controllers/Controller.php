<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function errorBack(string $message = null): RedirectResponse
    {
        if (!$message) {
            $message = __('common.messages.error');
        }

        return back()->with('error', $message);
    }

    protected function logError(\Throwable $throwable)
    {
        Log::error($throwable->getMessage());
        Log::error($throwable->getTraceAsString());
    }

    protected function createSuccessRedirect($route, $param = null): RedirectResponse
    {
        return redirect()->route($route, $param)->with('success', __('common.messages.create_success'));
    }

    protected function updateSuccessRedirect($route, $param = []): RedirectResponse
    {
        return redirect()->route($route, $param)->with('success', __('common.messages.update_success'));
    }

    protected function deleteSuccessRedirect($route, $param = []): RedirectResponse
    {
        return redirect()->route($route, $param)->with('success', __('common.messages.delete_success'));
    }
}
