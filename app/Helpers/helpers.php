<?php

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Log;

function academicYear(){
    $academicYear = AcademicYear::where('is_active', 1)->first();
    return $academicYear;
}

function academicYearId(): mixed
{
    return academicYear()->id;
}

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

function scoreToGrade($score): string
{
    $grade = '';
    if ($score >= 80) $grade = 'A';
    else if ($score >= 70) $grade = 'B';
    else if ($score >= 60) $grade = 'C';
    else if ($score >= 50) $grade = 'D';
    else $grade = 'E';

    return $grade;
}

function bobot($score): int
{
    $bobot = 0;
    if ($score >= 80) $bobot = 4;
    else if ($score >= 70) $bobot = 3;
    else if ($score >= 60) $bobot = 2;
    else if ($score >= 50) $bobot = 1;

    return $bobot;
}
