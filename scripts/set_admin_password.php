<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'admin@uinsu.ac.id';
$user = User::where('email', $email)->first();
if (!$user) {
    echo "Admin user not found\n";
    exit(1);
}
$user->password = Hash::make('password');
$user->save();
echo "Password for {$email} set to 'password'\n";
