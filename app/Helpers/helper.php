<?php

use App\Models\User;
use App\Models\AuditTrail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;





if (!function_exists('sendMail')) {
    function sendMail($send_to_name, $send_to_email, $subject, $body)
    {
        try {
            $mail_val = [
                'send_to_name' => $send_to_name,
                'send_to' => $send_to_email,
                'email_from' => env('MAIL_FROM_ADDRESS'),
                'email_from_name' => env('MAIL_FROM_NAME'),
                'subject' => $subject,
            ];

            Mail::send('email.mail', ['body' => $body], function ($send) use ($mail_val) {
                $send->from($mail_val['email_from'], $mail_val['email_from_name']);
                $send->replyto($mail_val['email_from'], $mail_val['email_from_name']);
                $send->to($mail_val['send_to'], $mail_val['send_to_name'])->subject($mail_val['subject']);
            });
            
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // echo "An error occurred while sending the email: " . $e->getMessage();
            return false;
        }
    }
}
if (!function_exists('getUserSidebarMenus')) {
    function getUserSidebarMenus()
    {
        if (Auth::check() && Auth()->user()->role === 1) {
            return Auth::user()->sidebarMenus; // Assuming the relationship is defined
        }
        if (Auth::check() && Auth()->user()->role === 0) {
            return \App\Models\SidebarMenu::all();
        }
        return collect(); // Return an empty collection if not logged in
    }
}
if (!function_exists('record_audit_trail')) {
  
    function record_audit_trail($module, $sourceTable, $sourceId, $action,$shortMessage)
    {
        // Record the action to the audit_trails table
        AuditTrail::create([
            'module' => $module,
            'source_table' => $sourceTable,
            'source_id' => $sourceId,
            'action' => $action,
            'short_message' => $shortMessage, 
            'user_id'=> Auth::id(),
        ]);
    }
}
