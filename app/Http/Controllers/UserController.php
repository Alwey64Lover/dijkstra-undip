<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected array $routes = [
        "table" => "users.table",
        "form" => "users.form",
        "action" => "users.action",
    ];

    public function __construct() {
        $this->title = "Users";
        $this->titleSingle = "User";
    }

    public function getValidationRules(string $action, ?string $id = null): array
    {
        return match ($action) {
            'add' => [
                "email"=>"required|unique:users,email,NULL,id,deleted_at,NULL|email:rfc,filter",
                "name"=>"required",
                "password"=>"required|min:8",
            ],
            'edit' => [
                "email"=>"required|unique:users,email,".$id.",id,deleted_at,NULL|email:rfc,filter",
                "name"=>"required",
                "password"=>"nullable|min:8",
            ],
            default => [],
        };
    }

    public function table(): View
    {
        $data["title"] = $this->title;
        $data["routes"] = $this->routes;

        try {
            $data["columns"] = User::latest()->get();

            return view("modules.backend.".$this->routes['table'], $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'table');
            abort(500);
        }

    }

    public function form(string $action, string $id = null): View
    {
        try {
            $data["title"] = ucwords($action)." ".$this->titleSingle;

            $data['formAction'] = [
                'method' => $this->methodAction[$action],
                'route' => route($this->routes['action'], "$action/$id"),
            ];

            $data['backRoute'] = route($this->routes['table']);

            if ($action == 'edit') {
                $data["data"] = User::findOrFail($id);
            }

            $data["elements"] = [
                "name" => [
                    "type" => "text",
                    "id" => "name",
                    "name" => "name",
                    "label" => "Name",
                    "placeholder" => "Name",
                    "required" => "required",
                    "value" => isset($data['data']) ? $data['data']->name : '',
                ],
                "email" => [
                    "type" => "email",
                    "id" => "email",
                    "name" => "email",
                    "label" => "Email",
                    "placeholder" => "Email",
                    "required" => "required",
                    "value" => isset($data['data']) ? $data['data']->email : '',
                ],
                "password"=> [
                    "type" => "password",
                    "id" => "password",
                    "name" => "password",
                    "label" => "Password",
                    "required" => isset($data['data']) ? '' : 'required',
                    "placeholder" => "Password",
                ],
            ];

            return view("modules.backend.".$this->routes['form'], $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), "$action/$id");
            abort(404);
        }
    }

    public function action(Request $request, string $action, string $id = null): RedirectResponse
    {
        $verbAction = $this->verbAction[$action];

        $redirect = redirect()->route($this->routes['table']);

        $request->validate($this->getValidationRules($action, $id));

        DB::beginTransaction();

        try {
            switch ($action) {
                case 'edit':
                case 'add':
                    $data = $request->except("_token", "_method", "password");

                    $newPassword = $request->password;

                    if (filled($newPassword)) {
                        $data["password"] = bcrypt($newPassword);
                    }

                    User::updateOrCreate(["id" => $id], $data);

                    break;
                case 'delete':
                    if ($id == user()->id) {
                        throw new \Exception("You can't delete your own account.");
                    }

                    User::findOrFail($id)->delete();

                    break;
                default:
                    throw new \Exception("Action ".$action." not found.");

                    break;
            }

            DB::commit();

            $redirect = $redirect->with("success", actionMessage("success", $verbAction));
        } catch (\Exception $e) {
            DB::rollBack();

            logError($e, actionMessage("failed", $verbAction), "$action/$id");

            $redirect = $redirect->with("error", actionMessage("failed", $verbAction));
        }

        return $redirect;
    }
}
