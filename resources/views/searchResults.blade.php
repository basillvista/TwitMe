<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TwittMe</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font1-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous"
    />
</head>
<body>
<!-- sidebar starts -->
<div class="sidebar">
    <i class="fab fa-twitter"></i>
    <div class="sidebarOption active">
        <span class="material-icons"> home </span>
        <h2><a href="{{ route('index')}}">Home</a></h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> search </span>
        <h2>Explore</h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> notifications_none </span>
        <h2>Notifications</h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> mail_outline </span>
        <h2>Messages</h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> bookmark_border </span>
        <h2>Bookmarks</h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> list_alt </span>
        <h2>Lists</h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> perm_identity </span>
        <h2><a href="{{ route('create.profile', ['id'=>Auth()->user()->id]) }}">Profile</a></h2>
    </div>

    <div class="sidebarOption">
        <span class="material-icons"> more_horiz </span>
        <div class="dropdown_content">
            <h2>More</h2>
            <div class="sidebarOption-dropdown">
                <div class="sidebarOption">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        <input type="submit" name="logout" class="">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- sidebar ends -->

<!-- feed starts -->

<div class="feed">
    <div class="feed__header">
        <h2>Home</h2>
    </div>

    <!-- tweetbox starts -->
    <div class="tweetBox">
        <form action="{{ route('store.tweet') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="tweetbox__input">
                    <div class="profile-picture">
                        <img src="{{asset($path)}}" width="48px" height="48px">
                    </div>
                <input type="text" name="body" placeholder="What's happening?" />
            </div>

            <div class="media">
                <label for="file-upload" class="custom-file-upload">
                    <img class="custom-file-upload" src="{{asset('images/R.jpg')}}"
                         height="20px" width="20px">
                    <input type="file" name="tweetMedia" class="custom-file-upload">
                </label>
            </div>
            <button type="submit" name="tweetSubmit" class="tweetBox__tweetButton">Tweet</button>
        </form>
    </div>

    <!-- tweetbox ends -->
    {{--   posts start --}}
    @foreach($results as $result)
        <div class="post">
            <div class="post__avatar">
                @if($result->user_image_path === NULL)
                    <div class="profile-picture">
                        <img
                            src="https://i.pinimg.com/originals/a6/58/32/a65832155622ac173337874f02b218fb.png"
                            alt=""
                            width="48px" height="48px"
                        />
                    </div>
                @else
                    <div class="profile-picture">
                        <img src="{{asset($result->user_image_path)}}" width="48px" height="48px">
                    </div>
                @endif
            </div>
            <div class="post__body">
                <div class="post__header">
                    <div class="post__headerText">
                        <h3>
                            @inject('username','App\Http\Helpers\FindUsername')
                            <div><a href="{{ route('create.profile', ['id'=>$result->user_id]) }}">{{$username->findUsername($result->user_id)}}</a></div>
                            <span class="post__headerSpecial"
                            ><span class="material-icons post__badge"> verified </span><div>@ {{$username->findUsername($result->user_id)}}</div>
</span
>
                        </h3>
                    </div>
                    <a href="{{ route('show.single', ['postId'=>$result->id]) }}">
                        <div class="post__headerDescription">
                            <p>{{ $result->body }}</p>
                        </div>
                </div>
                <img
                    src="/images/{{$result->image_path}}"
                    alt=""
                />
                <div class="post__footer">
                    <span class="material-icons"> repeat </span>
                    <a href="{{ route('like.tweet', ['postId'=>$result->id]) }}"><span class="material-icons"> favorite_border </span></a>
                    @inject('count','App\Http\Helpers\CountLikes')
                    <div>{{$count->countLikesOnTweets($result->id)}}</div>
                    <span class="material-icons"> publish </span>
                </div>
                </a>
            </div>
        </div>
    @endforeach
</div>
<!-- feed ends -->

<!-- widgets starts -->
<div class="widgets">
    <div class="widgets__input">
        <form method="POST" action="{{ route('search') }}">
            @csrf
            <span class="material-icons widgets__searchIcon"> search </span>
            <input type="text" placeholder="Search Twitter" name="body" />
        </form>
    </div>

    <div class="widgets__widgetContainer">
        <h2>Trends for you</h2>
        <blockquote class="twitter-tweet">
            <div style="display:block; width:348px; height:82px;">
                <a>Trends to be applied</a><br>
                500ktweets
            </div>


        </blockquote>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>
<!-- widgets ends -->
</body>
</html>





{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8" />--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge" />--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0" />--}}
{{--    <title>TwittMe</title>--}}
{{--    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">--}}
{{--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />--}}
{{--    <link--}}
{{--        rel="stylesheet"--}}
{{--        href="https://cdnjs.cloudflare.com/ajax/libs/font1-awesome/5.15.3/css/all.min.css"--}}
{{--        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="--}}
{{--        crossorigin="anonymous"--}}
{{--    />--}}

{{--</head>--}}
{{--<body>--}}
{{--<!-- sidebar starts -->--}}
{{--<div class="sidebar">--}}
{{--    <i class="fab fa-twitter"></i>--}}
{{--    <div class="sidebarOption active">--}}
{{--        <span class="material-icons"> home </span>--}}
{{--        <h2><a href="{{ route('index')}}">Home</a></h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> search </span>--}}
{{--        <h2>Explore</h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> notifications_none </span>--}}
{{--        <h2>Notifications</h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> mail_outline </span>--}}
{{--        <h2>Messages</h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> bookmark_border </span>--}}
{{--        <h2>Bookmarks</h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> list_alt </span>--}}
{{--        <h2>Lists</h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> perm_identity </span>--}}
{{--        <h2><a href="{{ route('create.profile', ['id'=>Auth()->user()->id]) }}">Profile</a></h2>--}}
{{--    </div>--}}

{{--    <div class="sidebarOption">--}}
{{--        <span class="material-icons"> more_horiz </span>--}}
{{--        <h2>More</h2>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<!-- sidebar ends -->--}}

{{--<!-- feed starts -->--}}

{{--<div class="feed">--}}
{{--    <div class="feed__header">--}}
{{--        <h2>Home</h2>--}}
{{--        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--            @csrf--}}
{{--            <input type="submit" name="logout">--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <!-- tweetbox starts -->--}}

{{--    <div class="tweetBox">--}}
{{--        <form action="{{ route('store.tweet') }}" method="POST" enctype="multipart/form-data">--}}
{{--            @csrf--}}
{{--            <div class="tweetbox__input">--}}
{{--                                <div class="profile-picture">--}}
{{--                                    <img src="{{asset($path)}}" width="48px" height="48px">--}}
{{--                                </div>--}}
{{--                <input type="text" name="body" placeholder="What's happening?" />--}}
{{--            </div>--}}

{{--            <div class="media">--}}
{{--                <label for="file-upload" class="custom-file-upload">--}}
{{--                    <img class="custom-file-upload" src="{{asset('images/R.jpg')}}"--}}
{{--                         height="20px" width="20px">--}}
{{--                    <input type="file" name="tweetMedia" class="custom-file-upload">--}}
{{--                </label>--}}
{{--                <button name="tweetSubmit" class="tweetBox__tweetButton">Tweet</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <div class="tweetBox">--}}
{{--        <form action="{{ route('store.tweet') }}" method="POST" enctype="multipart/form-data">--}}
{{--            @csrf--}}
{{--            <div class="tweetbox__input">--}}
{{--                <div class="profile-picture">--}}
{{--                    <img src="{{asset($path)}}" width="48px" height="48px">--}}
{{--                </div>--}}
{{--                <input type="text" name="body" placeholder="What's happening?" />--}}
{{--            </div>--}}
{{--            <div class="media">--}}
{{--                <label for="file-upload" class="custom-file-upload">--}}
{{--                    <img class="custom-file-upload" src="{{asset('images/R.jpg')}}"--}}
{{--                         height="20px" width="20px">--}}
{{--                    <input type="file" name="tweetMedia" class="custom-file-upload">--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <button name="tweetSubmit" class="tweetBox__tweetButton">Tweet</button>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <!-- tweetbox ends -->--}}
{{--    --}}{{--   posts start --}}
{{--    @foreach($results as $result)--}}
{{--            <div class="post">--}}
{{--                <div class="post__avatar">--}}
{{--                    <a href="#" id="profile-link" >--}}
{{--                            <div class="profile-picture">--}}
{{--                                <img src="{{asset($result->image_path)}}" width="48px" height="48px">--}}
{{--                            </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="post__body">--}}
{{--                    <div class="post__header">--}}
{{--                        <div class="post__headerText">--}}
{{--                            <h3>--}}
{{--                                @inject('username','App\Http\Helpers\FindUsername')--}}
{{--                                <div>{{$username->findUsername($result->user_id)}}</div>--}}
{{--                                <span class="post__headerSpecial"--}}
{{--                                ><span class="material-icons post__badge"> verified </span><div>@ {{$username->findUsername($result->user_id)}}</div>--}}
{{--</span--}}
{{-->--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                        <a href="{{ route('show.single', ['postId'=>$result->id]) }}">--}}
{{--                        <div class="post__headerDescription">--}}
{{--                            <p>{{ $result->body }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <img--}}
{{--                        src="{{asset($result->image_path)}}"--}}
{{--                        alt=""--}}
{{--                    />--}}
{{--                    <div class="post__footer">--}}
{{--                        <span class="material-icons"> repeat </span>--}}
{{--                        <a href="{{ route('like.tweet', ['postId'=>$result->id]) }}"><span class="material-icons"> favorite_border </span></a>--}}
{{--                        @inject('count','App\Http\Helpers\CountLikes')--}}
{{--                        <div>{{$count->countLikesOnTweets($result->id)}}</div>--}}
{{--                        <span class="material-icons"> publish </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--            </div>--}}
{{--    @endforeach--}}
{{--</div>--}}
{{--<!-- feed ends -->--}}

{{--<!-- widgets starts -->--}}
{{--<div class="widgets">--}}
{{--    <div class="widgets__input">--}}
{{--        <form method="POST" action="{{ route('search') }}">--}}
{{--            @csrf--}}
{{--            <span class="material-icons widgets__searchIcon"> search </span>--}}
{{--            <input type="text" placeholder="Search Twitter" name="body" />--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <div class="widgets__widgetContainer">--}}
{{--        <h2>What's happening?</h2>--}}
{{--        <blockquote class="twitter-tweet">--}}
{{--            <p lang="en" dir="ltr">--}}
{{--                Sunsets don&#39;t get much better than this one over--}}
{{--                <a href="https://twitter.com/GrandTetonNPS?ref_src=twsrc%5Etfw">@GrandTetonNPS</a>.--}}
{{--                <a href="https://twitter.com/hashtag/nature?src=hash&amp;ref_src=twsrc%5Etfw"--}}
{{--                >#nature</a--}}
{{--                >--}}
{{--                <a href="https://twitter.com/hashtag/sunset?src=hash&amp;ref_src=twsrc%5Etfw"--}}
{{--                >#sunset</a--}}
{{--                >--}}
{{--                <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a>--}}
{{--            </p>--}}
{{--            &mdash; US Department of the Interior (@Interior)--}}
{{--            <a href="https://twitter.com/Interior/status/463440424141459456?ref_src=twsrc%5Etfw"--}}
{{--            >May 5, 2014</a--}}
{{--            >--}}
{{--        </blockquote>--}}
{{--        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<!-- widgets ends -->--}}
{{--</body>--}}
{{--</html>--}}
