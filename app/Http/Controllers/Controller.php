<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $methodAction = [
        'add' => 'POST',
        'edit' => 'PUT',
        'delete' => 'DELETE',
    ];

    protected array $verbAction = [
        'add' => 'added',
        'edit' => 'edited',
        'delete' => 'deleted',
    ];

    protected $title = "";
    protected $titleSingle = "";
}
