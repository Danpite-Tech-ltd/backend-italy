<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class APIController extends Controller
{

    public function sendBirthdayEmails()
    {
        $today = Carbon::now()->format('m-d'); // month-day format

        // Get users whose birthday matches today
        $users = User::whereMonth('dob', Carbon::now()->month)
            ->whereDay('dob', Carbon::now()->day)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'status' => 'info',
                'message' => 'No birthdays today.'
            ]);
        }

        foreach ($users as $user) {
            Mail::send('emails.birthday_wish', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Happy Birthday!');
            });
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Birthday emails sent successfully.',
            'count' => $users->count()
        ]);
    }

}
