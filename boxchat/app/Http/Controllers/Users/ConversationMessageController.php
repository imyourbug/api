<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\ConversationMessageService;
use Exception;

class ConversationMessageController extends Controller
{
    protected $conMessageService;
    public function __construct(ConversationMessageService $conMessageService)
    {
        $this->conMessageService = $conMessageService;
    }
    public function index(Request $request)
    {
        return $this->conMessageService->getMessagesByIdConversation($request);
    }
}
