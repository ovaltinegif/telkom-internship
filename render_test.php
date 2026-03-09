<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use App\Models\User;

$users = User::paginate(10);
$request = Request::create('/admin/users', 'GET');
app()->instance('request', $request);

try {
    $html = View::make('admin.users.index', ['users' => $users])->render();
    file_put_contents('rendered_output.html', $html);
    echo "Rendered successfully. Length: " . strlen($html) . "\n";
}
catch (\Exception $e) {
    echo "Error rendering: " . $e->getMessage() . "\n";
}
