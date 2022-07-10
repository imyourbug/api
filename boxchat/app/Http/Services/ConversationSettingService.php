<?php

namespace App\Http\Services;

use App\Models\Conversation;
use App\Models\ConversationSetting;
use Exception;

class ConversationSettingService
{
    public function join($request)
    {
        try {
            $id_member = auth()->id();
            // dd($id_member, $request->conversation_id, $status);
            if (!$this->checkExistsConversation($id_member, $request->conversation_id)) {
                $con = ConversationSetting::create([
                    'id_user' => $id_member,
                    'id_conversation' => $request->conversation_id,
                    'status' => 0,
                ]);
            } else return response()->json([
                'success' => false,
                'message' => 'Bạn đang là thành viên cuộc trò chuyện'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tham gia cuộc trò chuyện thành công',
            'conversation_id' => $con->id_conversation,
            'conversation_name' => $con->conversation->name
        ]);
    }

    public function leave($request)
    {
        // dd($request->all());
        try {
            $id_member = auth()->id();
            // dd($id_member, $request->conversation_id);
            if ($this->checkExistsConversation($id_member, $request->conversation_id)) {
                ConversationSetting::where('id_user', $id_member)
                    ->where('id_conversation', $request->conversation_id)
                    ->first()->delete();
            } else return response()->json([
                'success' => false,
                'message' => 'Bạn không là thành viên cuộc trò chuyện'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $con = $this->getConversationById($request->conversation_id);
        return response()->json([
            'success' => true,
            'message' => 'Rời cuộc trò chuyện thành công',
            'conversation_id' => $con->id,
            'conversation_name' => $con->name
        ]);
    }

    public function add($request)
    {
        // dd($request->all());

        try {
            $data = array();
            $count  = 0;
            $list_user = $request->list_user;
            // dd($list_user);
            foreach ($list_user as $id_user) {
                if (!$this->checkExistsConversation($id_user, $request->conversation_id)) {
                    $data[] = [
                        'id_user' => (int) $id_user,
                        'id_conversation' => (int) $request->conversation_id,
                        'status' => 0,
                        'created_at' => date('Y-m-d h:i:s', time()),
                        'updated_at' => date('Y-m-d h:i:s', time())
                    ];
                    $count++;
                }
            }
            // dd($data);
            if ($count > 0) {
                ConversationSetting::insert($data);
            } else return response()->json([
                'success' => false,
                'message' => 'Không có thành viên nào được thêm'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $con = $this->getConversationById($request->conversation_id);
        $list_user_success = [];
        foreach ($data as $d) {
            $list_user_success[] = $d['id_user'];
        }
        return response()->json([
            'success' => true,
            'message' => 'Thêm thành viên vào cuộc trò chuyện thành công',
            'conversation_id' => $con->id,
            'conversation_name' => $con->name,
            'list_user_success' => $list_user_success
        ]);
    }
    public function remove($request)
    {
        // dd($request->all());

        try {
            $data = array();
            $count  = 0;
            $list_user = $request->list_user;
            // dd($list_user);
            foreach ($list_user as $id_user) {
                if ($this->checkExistsConversation($id_user, $request->conversation_id)) {
                    $data[] = $id_user;
                    $count++;
                }
            }
            // dd($data);
            if ($count > 0) {
                ConversationSetting::whereIn('id_user', $data)->delete();;
            } else return response()->json([
                'success' => false,
                'message' => 'Không có thành viên nào được xóa'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $con = $this->getConversationById($request->conversation_id);
        return response()->json([
            'success' => true,
            'message' => 'Xóa thành viên khỏi cuộc trò chuyện thành công',
            'conversation_id' => $con->id,
            'conversation_name' => $con->name,
            'list_user_success' => $data
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
