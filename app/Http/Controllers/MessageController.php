<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService){
        $this->messageService = $messageService;
    }

    public function index(): View{
        $id = Auth()->user()->id;

        $messages=$this->messageService->getMessagesByUserId($id);

        return view('message.messages', compact('messages'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse{
        $user = $this->messageService->getUserById($request['id']);

        $this->messageService->storeConversationAndMessage($request);

        return redirect()->route('create.chat',['user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createSearchPage(): View{
        return view('message.searchUser');
    }

    public function createChat(User $user): View{
        $id=Auth()->user()->id;

        $messages = $this->messageService->getChatMessagesByUserAndId($id, $user);

        return view('message.chat', compact('user', 'messages'));
    }

    public function search(Request $request): View{
        $users = $this->messageService->getUsersByUsername($request->body);
        return view('message.searchResults', compact('users'));
      }

}
