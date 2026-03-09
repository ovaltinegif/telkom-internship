<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'admin')->first();
auth()->login($user);

$users = App\Models\User::paginate(10);
$html = view('admin.users.index', compact('users'))->render();
file_put_contents('rendered.html', $html);
echo "Length: " . strlen($html) . "\n";
