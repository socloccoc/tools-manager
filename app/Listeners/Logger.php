<?php

namespace App\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Illuminate\Http\Request;
use DB;
use Sentinel;

class Logger
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(MessageLogged $event)
    {
        if ($event->level == 'info') {
            DB::table('db_activity_log')->insert(
                array(
                    'activity' => $event->message, // The message will represent the activity that was performed, Like Add/Delete/Update
                    'item_id' => (isset($event->context['ItemID']) ? $event->context['ItemID'] : ''), // Item the activity was performed on
                    'created_at' => date("Y-m-d H:i:s"), // Date and time the activity was performed
                    'updated_at' => date("Y-m-d H:i:s"),
                    'user_created' => (Sentinel::check() ? Sentinel::getUser()->id : 0), // User who performed the activity
                    'user_updated' => (Sentinel::check() ? Sentinel::getUser()->id : 0),
                    'module' => (isset($event->context['Module']) ? $event->context['Module'] : ''), // Which module the activity was performed
                    'created_ip' => @$_SERVER['REMOTE_ADDR'],
                    'updated_ip' => @$_SERVER['REMOTE_ADDR'],
                )
            );
        }
    }

}