<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('news:fetch')->everyThreeHours()->withoutOverlapping();

Schedule::command('github:sync')->daily()->withoutOverlapping();

Schedule::call(fn () => \App\Models\PageView::where("created_at", "<", now()->subDays(180))->delete())->daily();
