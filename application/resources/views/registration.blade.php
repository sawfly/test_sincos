<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <form action="/registration" method="post">
                <input type="text" placeholder="name" name="name" id="name" class="name" /><br />
                <input type="text" placeholder="email" name="email" id="email" class="email" /><br />
                <input type="password" placeholder="password" name="password" id="password" class="password" /><br />
                <input type="password" placeholder="password" name="repassword" id="repassword" class="password"
                /><br />
                <input type="hidden" name="link" value="{{$link}}" />
                <input type="submit" />
                <input type="reset" />
            </form>
        </div>
    </body>
</html>
