<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, Controller,ProfileController,MessageController, PostController, Auth\GoogleController};

Auth::routes(['verify' => true]);

Route::prefix('google')->group(function(){
    Route::controller(GoogleController::class)->group(function(){
        Route::get('/redirect', 'redirect')->name('redirect.google');
        Route::get('/callback', 'handleCallback');
        Route::post('/register','registerGoogleUser')->name('register.google.user');
    });
});

Route::middleware('auth')->group(function(){
    Route::get('/', [Controller::class, 'createPage'])->name('index');
    Route::post('/search', [Controller::class, 'search'])->name('search');


   Route::prefix('messages')->group(function(){
       Route::controller(MessageController::class)->group(function(){
           Route::get('/', 'index')->name('create.messages');
           Route::get('/search/user', 'createSearchPage')->name('create.searchUsers');
           Route::post('/search', 'search')->name('search.user');
           Route::post('/store', 'store')->name('store.message');
           Route::get('/{user}/chat', 'createChat')->name('create.chat');
       });
   });

    Route::controller(PostController::class)->group(function (){
        Route::get('/singleTweet/{postId}', 'show')->name('show.single');
        Route::get('/likeTweet/{postId}', 'likeTweet')->name('like.tweet');
        Route::post('/tweet', 'storeTweet')->name('store.tweet');
        Route::post('/tweet/reply','storeTweetReply')->name('store.tweet.reply');
    });

    Route::prefix('profile')->group(function (){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/followers/{id}', 'createProfileFollowers')->name('create.profileFollowers');
            Route::get('/following/{id}', 'createProfileFollowing')->name('create.profileFollowing');
            Route::get('/tweets/{id}', 'createProfileTweets')->name('create.profileTweets');
            Route::get('/likes/{id}', 'createProfileLikes')->name('create.profileLikes');
            Route::get('/media/{id}', 'createProfileMedia')->name('create.profileMedia');
            Route::get('/{id}', 'createProfile')->name('create.profile');
            Route::get('/tweetsReplies/{id}',  'createProfileTweetsReplies')->name('create.profileReplies');
            Route::post('/update/user', 'updateUser')->name('update.user');
            Route::get('/edit/{id}', 'createProfileEdit')->name('create.profileEdit');
            Route::get('/delete/profile/picture', 'deletePicture')->name('delete.picture');
        });
    });

    Route::controller(UserController::class)->group(function(){
        Route::post('/follow', 'follow')->name('follow.user');
    });

    Route::get('/blockUser/{user}', [\App\Http\Controllers\BlockUserController::class, 'blockUser'])->name('block.user');

    Route::get('/explore', [Controller::class, 'explore'])->name('show.explore');

});
