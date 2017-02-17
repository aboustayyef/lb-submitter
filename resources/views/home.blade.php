<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Submit your blog</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css">
    </head>
    <body>

    <script type="text/javascript">
        window.Laravel = {csrfToken : '{{csrf_token()}}'};
    </script>

    <div id="app">
        <enter-url v-on:data-ready="getRssContent"></enter-url>
        <blog-details v-on:twitter-field-updated="getTwitterDetails" v-on:rss-field-updated="getRssContent"></blog-details>
        
    </div>
    <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>
