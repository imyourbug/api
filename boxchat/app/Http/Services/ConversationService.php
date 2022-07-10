<?php

namespace App\Http\Services;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\ConversationSetting;

class ConversationService
{
    public function getAllConversations()
    {
        $conversations = Conversation::with('messages')->with('conversations')->get();
        $members = array();
        foreach ($conversations as $con) {
            foreach ($con->conversations as $c) {
                $members[] = $c->user;
            }
        }

        $data = array();
        $data['members'] = $members;

        //  dd($members);
        return response()->json([
            'conversations' => $this->conversationService->getAllConversations(),
            'data' => $data,
        ]);
    }
    public function getDataConversation($request)
    {
        $con = Conversation::where('id', $request->conversation_id)
            ->with('messages')->with('conversations')
            ->first();
        if ($con) {
            $messages = ConversationMessage::where('id_conversation', $request->conversation_id)
                ->orderByDesc('id')->limit($request->limit)->get();
            $data_mess = array();
            foreach ($messages as $mess) {
                $data_mess[] = [
                    'messsageID' => $mess->id_message,
                    'messageContent' => $mess->message->content,
                    'ins_time' => $mess->created_at->format('d-m-Y H:i:s'),
                    'sender_ID' => $mess->message->user->id,
                ];
            }
            $data_member = array();
            foreach ($con->conversations as $c) {
                $data_member[] = $c->user;
            }
            return response()->json([
                'success' => true,
                'messages' => $data_mess,
                'conversation_id' => $con->id,
                'conversation_name' => $con->name,
                'members' => $data_member,
            ]);
        }
        return response()->json([
            'success' => false,
            'messages' => 'Cuộc trò chuyện không tồn tại'
        ]);
    }

    public function destroy($request)
    {
        try {
            $con = Conversation::where('id', $request->conversation_id)->first();
            if ($con)
                $con->delete();
            else return response()->json([
                'success' => false,
                'message' => 'Không tồn tại cuộc trò chuyện'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            '_id' => $request->conversation_id
        ]);
    }
    public function changeConversationName($request)
    {
        try {
            $con = Conversation::where('id', $request->conversation_id)->first();
            if ($con)
                $con->update([
                    'name' => $request->conversation_name
                ]);
            else return response()->json([
                'success' => false,
                'message' => 'Không tồn tại cuộc trò chuyện'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'conversation_id' => $request->conversation_id,
            'conversation_name' => $request->conversation_name
        ]);
    }
    public function create($request)
    {
        // dd($request->all());
        try {
            $data = array();
            $list_user = $request->list_user;
            // dd($list_user);
            $con = Conversation::create([
                'name' => $request->conversation_name,
                'description' => ''
            ]);

            foreach ($list_user as $id_user) {
                if (!$this->checkExistsConversation($id_user, $con->id)) {
                    $data[] = [
                        'id_user' => (int) $id_user,
                        'id_conversation' => (int) $con->id,
                        'status' => 0,
                        'created_at' => date('Y-m-d h:i:s', time()),
                        'updated_at' => date('Y-m-d h:i:s', time())
                    ];
                }
            }

            if (count($data) > 0) {
                ConversationSetting::insert($data);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $list_user_success = [];
        foreach ($data as $d) {
            $list_user_success[] = $d['id_user'];
        }
        return response()->json([
            'success' => true,
            'message' => 'Tạo cuộc trò chuyện thành công',
            'conversation_id' => $con->id,
            'list_user_success' => $list_user_success
        ]);
    }
    public function checkExistsConversation($id_member, $id_con)
    {
        $con = ConversationSetting::where('id_user', $id_member)
            ->where('id_conversation', $id_con)->first();
        if ($con) return true;
        return false;
    }

    public function getConversationById($id)
    {
        return Conversation::where('id', $id)->first();
    }
}
