<?php

use Illuminate\Support\Facades\Log;

function routeIsActive($route): string
{
    return request()->routeIs($route) ? 'active' : '';
}

function user(): mixed
{
    return auth()->user();
}

function actionMessage($type, $action): string
{
    if ($type == 'failed') {
        return "Data failed to be $action.";
    }

    return "Data successfully $action.";
}

function logError($exception, $message, $action): void
{
    Log::error($message, ["action" => $action, "error" => $exception->getMessage(), "stack" => $exception->getTraceAsString()]);
}

function arrayOnly(array $array, array $keys): array
{
    return array_intersect_key($array, array_flip($keys));
}

function randomArray(array $array, int $from = 0): mixed
{
    return $array[rand($from, (count($array) - 1))];
}
