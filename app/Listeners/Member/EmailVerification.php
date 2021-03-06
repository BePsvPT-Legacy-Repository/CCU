<?php

namespace App\Listeners\Member;

use App\Events\Member\Register as RegisterEvent;
use App\Ccu\Mail\Register;

class EmailVerification
{
    /**
     * Handle the event.
     *
     * @param RegisterEvent $event
     */
    public function handle(RegisterEvent $event)
    {
        $mail = new Register($event->account);

        $mail->send();
    }
}
