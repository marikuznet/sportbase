<?php

namespace App\Http\Controllers;

use App\Events\ChatDelete;
use App\Events\MessageDelete;
use App\Events\MessageSent;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Http\Resources\Profile\UserCollection;
use App\Http\Resources\Profile\UserWithLastMessageCollection;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Doctrine\DBAL\Query;
use http\Exception;
use http\QueryString;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function getMessageFrom($id)
    {
        $messages = Message::whereIn('from', [Auth::id(), $id])
            ->whereIn('to', [Auth::id(), $id])
            ->orderBy('id')
            ->get();

        return new MessageCollection($messages);
    }

    public function getMessageRead($id)
    {
        Auth::user()->messagesProfileTo()->where('from', $id)->update(['read' => true]);
    }

    public function getContacts()
    {
        $users = null;
        if (Auth::user()->role == 2) {
            $users = User::has('infoCompany')
                ->with('infoCompany')
                ->where('role', 3)
                ->where('block', 0)
                ->where('status', 11)
                ->get();
        } elseif (Auth::user()->role == 3) {
            $users = User::has('infoCompany')
                ->with('infoCompany')
                ->where('role', 2)
                ->where('block', 0)
                ->get();
        }

        $this->loadLastMessages($users);
        $this->loadUnreadMessageCounts($users);

        return new UserWithLastMessageCollection($users);
    }

    private function loadLastMessages($users)
    {
        foreach ($users as $user) {
            $message = Message::where(function ($q) use ($user) {
                $q->where('from', Auth::id());
                $q->where('to', $user->id);
            })->orWhere(function ($q) use ($user) {
                $q->where('from', $user->id);
                $q->where('to', Auth::id());
            })->latest()->first();
            $user->message = $message;
        }
    }

    private function loadUnreadMessageCounts($users)
    {
        $users->each(function ($contact) {
            $contactUnread = $contact->messagesProfile()->where('to', Auth::id())->where('read', false)->count();
            $contact->unread = $contactUnread ? $contactUnread : 0;
        });
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'from' => Auth::id(),
            'to' => $request['to'],
            'text' => $request['text'],
            'images' => $request['images'],
        ]);

        event(new MessageSent($message));
        return response()->noContent();
        //return response()->json($message);
    }

    public function deleteMessageFor($id)
    {
        $messagesIdx = Message::query()->where([['from', Auth::id()], ['to', (int)$id]])
            ->orWhere([['from', (int)$id], ['to', Auth::id()]])->get()->pluck('id');

        dump($messagesIdx);
        foreach ($messagesIdx as $id) {
            Message::find($id)->delete();
        }

        return response(null, 200);
    }

    public function uploadImage(Request $request)
    {

        if (!Storage::exists('/public/chats')) {
            Storage::makeDirectory('/public/chats');
        }

        $image = uniqid() . '.jpg';
        $request['image']->storeAs('chats', $image, 'public');

        return $image;
    }

    public function showImage($name)
    {
        try {
            $file = Storage::disk('local')->get("/public/chats/$name");
            return (new Response($file, 200))
                ->header('Content-Type', 'image/jpeg');
        } catch (Exception $e) {
            return "/images/common/icons/general/content-loader.gif";
        } catch (FileNotFoundException $e) {
        }
    }
}
