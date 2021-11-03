<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notifications\MemberNotification;
use Auth;
use Notification;

class NotificationController extends Controller
{
    public function index()
    {
        if(Auth::user()->isAdministrator())
        {
            $user = User::where('role_id', 2)->first();
        } else {
            $user = Auth::user();
        }
        return view('notification.index')
            ->with('notifications', $user->notifications()->limit(20)->get());
    }

    public function delete(Request $request)
    {
        $subject = $request->subject;
        $message = $request->message;
        $users = User::all();
        foreach($users as $user)
        {
            $notifications = $user->notifications()->limit(20)->get();
            foreach($notifications as $record)
            {
                if($record->data['subject'] == $subject && $record->data['message'] == $message)
                {
                    $record->delete();
                    break;
                }
            }
        }
        flash('Notification has been deleted!');
        return redirect(route('notifications'));
    }

    public function getRecent()
    {
        $notifications = Auth::user()->unreadNotifications()->limit(5)->get();
        $notifies = $notifications->map(function($notifications) {
            $notifications->created_diff = $notifications->created_at->diffForHumans();
            return $notifications;
        });
        return response()->json($notifies);
    }

    public function showAddForm()
    {
        if( ! Auth::user()->isAdministrator())
            return back();

        $users = User::all();
        return view('notification.create')->with('users', $users);
    }

    public function addNew(Request $request)
    {
        if( ! Auth::user()->isAdministrator())
            return back();
        
        $subject = $request->subject;
        $message = $request->message;

        $user_type = $request->usertype;

        if($user_type == 'members') {
            $members = User::where('role_id', 2)->
                    where('verified', 1)->get();
        } else if ($user_type == 'admins') {
            $members = User::where('role_id', 1)->
                    where('verified', 1)->get();
        } else {
            $members = User::find($request->recipients);
        }

        Notification::send($members, new MemberNotification($subject, $message));
        flash('New notification has been successfully added!');
        return redirect(route('notifications'));
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if(isset($notification)) {
            $notification->markAsRead();
            return view('notification.show')->with('notification', $notification);
        } else {
            return back();
        }

    }
}
