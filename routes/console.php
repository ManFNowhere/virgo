<?php

use App\Models\Subscription;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Schedule::call(function () {
    $data = Movie::all();
        foreach ($data as $d) {
            $movie[] = substr($d['movie'],15);
            $trailer[] = substr($d['trailer'],17); 
        }

        $dirVideo = 'public/video/';
        $storageVideo = Storage::allFiles($dirVideo);
        foreach ($storageVideo as $file) {
            if(!in_array(substr($file,strlen($dirVideo)), $movie)){
                Storage::delete($dirVideo.substr($file,strlen($dirVideo)));
            }
        }

        $dirTrailer = 'public/trailer/';
        $storageTrailer = Storage::allFiles($dirTrailer);
        foreach ($storageTrailer as $file) {
            $ts[] = substr($file,strlen($dirTrailer));
            if(!in_array(substr($file,strlen($dirTrailer)), $trailer)){
                Storage::delete($dirTrailer.substr($file,strlen($dirTrailer)));
            }
        }      
})->everyFifteenSeconds();



Schedule::call(function () {
    $user = User::all();

    foreach ($user as $d) {
        if(empty($d['email_verified_at'])){
            $deleteUser = User::find($d['id']);
            $deleteUser->delete();
        }
    }
    
})->daily();


Schedule::call(function(){
    $currentTime = Carbon::now();
    // Fetch active subscriptions where end date is before current time
    $subscriptions = Subscription::whereNotNull('ends_at')
        ->where('stripe_status', 'active')
        ->where('ends_at', '<', $currentTime)
        ->get();
    foreach($subscriptions as $subscription){
        // Find user by subscription's user_id and update role to 0
        $user = User::findOrFail($subscription->user_id);
        $user->update(['role' => 0]);
    }
})->everySecond();
