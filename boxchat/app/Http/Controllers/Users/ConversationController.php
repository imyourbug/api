<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\ConversationService;

class ConversationController extends Controller
{
    protected $conversationService;
    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }
    # tạm bỏ qua
    public function index()
    {
        return $this->conversationService->getAllConversations();
    }
    #get data conversation by id
    public function data(Request $request)
    {
        return $this->conversationService->getDataConversation($request);
    }
    #create conversation
    public function create(Request $request)
    {
        return $this->conversationService->create($request);
    }
    #change conversation name
    public function update(Request $request)
    {
        return $this->conversationService->changeConversationName($request);
    }
    #destroy conversation by id
    public function destroy(Request $request)
    {
        return $this->conversationService->destroy($request);
    }
}
