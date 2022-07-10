<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\ConversationSettingService;

class ConversationSettingController extends Controller
{
    protected $conSettingService;
    public function __construct(ConversationSettingService $conSettingService)
    {
        $this->conSettingService = $conSettingService;
    }
    #user join conversation
    public function join(Request $request)
    {
        return $this->conSettingService->join($request);
    }
    #user leave conversation
    public function leave(Request $request)
    {
        return $this->conSettingService->leave($request);
    }
    #add multiple-users to conversation
    public function add(Request $request)
    {
        return $this->conSettingService->add($request);
    }
    #remove multiple-users to conversation
    public function remove(Request $request)
    {
        return $this->conSettingService->remove($request);
    }
}
