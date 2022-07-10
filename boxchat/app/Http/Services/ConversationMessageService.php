<?php

namespace App\Http\Services;

use App\Models\ConversationMessage;

class ConversationMessageService
{
    public function getMessagesByIdConversation($request)
    {
        try {
            $conver_messages =
                ConversationMessage::where('id_conversation', $request->conversation_id)
                ->with('conversation')->with('message')
                ->orderByDesc('id')->limit($request->limit)->get();
            $data = [];
            if (count($conver_messages) > 0) {
                foreach ($conver_messages as $con_mes) {
                    $data[] = [
                        'content' => $con_mes->message->content,
                        'sender' => [
                            'id' => $con_mes->message->user->id,
                            'name' => $con_mes->message->user->name
                        ],
                        'createAt' => $con_mes->created_at->format('d-m-Y H:i:s')
                    ];
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown error'
            ]);
        }
        return response()->json([
            'success' => true,
            'conversation_id' => $request->conversation_id,
            'data' => $data
        ]);
    }
}
