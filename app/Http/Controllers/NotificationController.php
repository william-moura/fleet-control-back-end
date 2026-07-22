<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function unread(Request $request)
    {        
        $user = $request->user() ?? auth()->user();        
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }
        $notifications = $user->unreadNotifications;
        return response()->json($notifications);
    }

    public function markAsRead(Request $request, $id)
    {
        $admin = $request->user() ?? auth()->user();

        if (!$admin) {
            return response()->json(['message' => 'Não autorizado'], 401);
        }

        // Busca a notificação pertencente a este admin específico
        $notification = $admin->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true, 'message' => 'Notificação marcada como lida.']);
        }

        return response()->json(['message' => 'Notificação não encontrada.'], 404);
    }
}
