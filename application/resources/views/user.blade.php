<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <h3>Hello {{$name}}</h3>
    <p>Your email {{$email}}</p>
    @if($invited_by)
        <p>You invited by {{$invited_by}}</p>
    @endif
    @if($link)
        <p>Link {{$link}}</p>
    @endif
    @if(!empty($followers))
        <p>You invite:</p>
        <ul>
            @foreach ($followers as $follower)
                <li>{{$follower->name}}</li>
            @endforeach
        </ul>
    @endif
    <form action="/users/{{$id}}/links" method="post">
        <input type="submit" value="generate link"/>
        <input type="hidden" name="method" value="put"/>
    </form>
</div>
</body>
</html>
