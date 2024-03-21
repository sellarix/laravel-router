<?php

declare(strict_types=1);

namespace Sellarix\Router\Exceptions;


use Exception;
use Illuminate\Support\Facades\Log;

class UrlExistsException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::debug('An integrity constraint violation occurred.');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'error' => 'Url already exists. Please choose a different one.'
        ], 500);
    }
}
