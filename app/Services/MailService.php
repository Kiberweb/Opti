<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\FeedBack;
use App\Mail\FeedBack as FeedBackMail;

class MailService
{
    public function mailNotification(FeedBack $feedBack): void
    {
        Mail::to(env('MAIL_FEEDBACK'))->send(new FeedBackMail($feedBack));
    }
}
