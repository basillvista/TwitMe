<?php

namespace App\Http\Controllers;

use App\Helpers\PostHelper;
use App\Http\Requests\updateUserRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function createProfile(int $id): View{
        $user=$this->profileService->getUserById($id);

        $userTweets=Post::with('user')
            ->where('posts.user_id', $id)
            ->get();

        $userTweets=PostHelper::addUserImageToPost($userTweets);

        return view('profile.profileImproved', compact( 'userTweets','user'));
    }

    public function createProfileTweets(int $id): View{
        $user=$this->profileService->getUserById($id);

        $userTweets = $this->profileService->getUserTweetsById($id);

        return view('profile.profileImproved', compact( 'userTweets','user'));
    }

    public function createProfileLikes(int $id): View{
        $user = $this->profileService->getUserById($id);

        $posts = $this->profileService->getLikedPostsById($id);

        return view('profile.profileLikes', compact('posts', 'user'));
    }

    public function createProfileTweetsReplies(int $id): View{
        $user=$this->profileService->getUserById($id);

        $userTweets = $this->profileService->getUserTweetsRepliesById($id);

        return view('profile.tweetsReplies', compact('userTweets', 'user'));
    }

    public function createProfileMedia(int $id): View{
        $user=$this->profileService->getUserById($id);

        $tweets = $this->profileService->getUserMediaTweetsById($id);

        return view('profile.profileMedia', compact('user','tweets'));
    }

    public function createProfileEdit(int $id): View{
        $user=$this->profileService->getUserById($id);

        return view('profile.profileEdit', compact('user'));
    }

    public function createProfileFollowing(int $id): View{
        $user_id ='follower_user_id';

        $following = $this->profileService->getFollowers($id,$user_id);

        return view('following', compact('following'));
    }

    public function createProfileFollowers(int $id): View{
        $user_id = 'user_id';

        $followers = $this->profileService->getFollowers($id,$user_id);

        return view('followers', compact('followers'));
    }

    public function updateUser(updateUserRequest $request): RedirectResponse{
        $this->profileService->updateUser($request);

        return redirect()->route('create.profile', ['id'=>Auth()->user()->id]);
    }

    public function deletePicture(): RedirectResponse{
        $user=User::findOrFail(Auth()->user()->id);

        $user->update(['user_image_path'=>NULL]);

        return redirect()->route('create.profile', ['id'=>Auth()->user()->id]);
    }


}
