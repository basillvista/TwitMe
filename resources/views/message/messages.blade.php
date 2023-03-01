<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TwittMe</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
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
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    <button type="submit" name="logout" class=""><h2>Log out</h2></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- sidebar ends -->

<!-- feed starts -->

<div class="feed">
    <div class="feed__header">
        <h2>Messages</h2>
    </div>
    <div class="message_header_container">
        <div class="sticky-div">Last Messages</div>
        <div class="sticky-div">Search Users</div>
    </div>
    <div class="messages-section">
{{--        <div class="message">--}}
{{--            <div class="message__header">--}}
{{--                <img src="profile-image.jpg" alt="Profile Image">--}}
{{--                <h3 class="message__username">Username</h3>--}}
{{--                <p class="message__timestamp">Timestamp</p>--}}
{{--            </div>--}}
{{--            <div class="message__content">--}}
{{--                <p>Message content goes here.</p>--}}
{{--            </div>--}}
{{--        </div>--}}

    </div>


</div>


<!-- widgets starts -->
<div class="widgets">
    <div class="chat-window">
        <div class="chat-header">
            <img src="profile-image.jpg" alt="Profile Image">
            <h3 class="chat-username">Username</h3>
        </div>
        <div class="chat-messages">
{{--            <div class="message">--}}
{{--                <img src="profile-image.jpg" alt="Profile Image">--}}
{{--                <div class="message-content">--}}
{{--                    <p>Message content goes here.</p>--}}
{{--                    <p class="message-timestamp">Timestamp</p>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
        <form action="{{ route('store.message') }}" method="POST" class="chat-form">
{{--            <form action="{{ route('store.message') }}" method="POST">--}}
                @csrf
            <input type="text" name="message" placeholder="Type a message...">
            <button type="submit">submit</button>
{{--            </form>--}}
        </form>
    </div>
</div>
<!-- widgets ends -->


</body>
</html>