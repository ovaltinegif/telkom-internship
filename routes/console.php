<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;



\Illuminate\Support\Facades\Schedule::command('app:cleanup-rejected-applicants')->daily();
\Illuminate\Support\Facades\Schedule::command('logbook:cleanup-images')->daily();
\Illuminate\Support\Facades\Schedule::command('app:send-weekly-logbook-digest')->weeklyOn(5, '17:00');
