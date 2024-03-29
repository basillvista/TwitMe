<?php

namespace App\Http\Controllers;

use App\Http\Requests\tweetRequest;
use App\Models\User;
use App\Models\Post;
use App\Models\Retweet;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Services\PostService;

class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function show(Post $post): View
    {
        $post = $this->postService->getPostById($post->id);
        $user = $this->postService->getUserById($post['user_id']);

        $userPath=Auth()->user()->user_image_path;

        $comments = $this->postService->getCommentsById($post->id);

        $post->view_counts++;
        $post->save();

        return view('singleTweet', compact('post', 'comments', 'user', 'userPath'));
    }

    public function likeTweet(Post $post, string $userId): RedirectResponse
    {
        $this->postService->likeTweet($post->id, $userId);

        return redirect()->back();
    }


    public function listPostLikes(Post $post): View
    {
        $listLikedPostUsers = DB::table('likes')
            ->where('post_id', $post->id)
            ->pluck('user_id')
            ->toArray();

        $users = User::whereIn('id', $listLikedPostUsers)->get();

        return view('listPostsLikes', compact('users'));
    }

    public function retweet(Post $post, $request): void
    {
          $id = Auth()->user()->id;
          $retweet = new Retweet();
          $retweet->user_id = $id;
          $retweet->post_id = $post->id;
          $retweet->comment = $request->comment ?? null;
          $retweet->save();

          $post = Post::findOrFail($post->id);
          $post->increment('retweet_count');
    }

    public function storeTweet(TweetRequest $request): RedirectResponse
    {

        try {
            $data = $request->validated();
            $this->postService->createPostData($data);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'There is an error' . $exception->getMessage());
        }
    }

    public function storeTweetReply(TweetRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->postService->createPostData($data, $request['post_id']);

        $user = User::findOrFail($request->user_id);
        $loggedUser = Auth()->user();

        if ($loggedUser->blue_verified == 1 && $user->id !== Auth()->user()->id) {
            $notification = new Notification();
            $notification->sender_id = Auth()->user()->id;
            $notification->receiver_id = $user->id;
            $notification->type = 'App\Models\Post';
            $notification->from_verified = true;
            $notification->comment = ' Replied to your post';
            $notification->save();
        } elseif ($user->id !== Auth()->user()->id) {
            $notification = new Notification();
            $notification->sender_id = Auth()->user()->id;
            $notification->receiver_id = $user->id;
            $notification->type = 'App\Models\Post';
            $notification->comment = ' Replied to your post';
            $notification->save();
        }

        return redirect()->back();
    }

    public function softDelete(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->back();
    }
}
