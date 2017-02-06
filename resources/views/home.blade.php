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
        <div class="section">
            <div class="container">
                <h1 class="title is-1">Submit your blog!</h1>
                <label class="label">Enter URL</label>
                <p class="control">
                  <input @keyup="updateButton" class="input" v-model="url" type="text" placeholder="Text input">
                </p>
                <button id="submit1" @click="getUrlDetails" :class="{'button is-primary' : true , 'is-disabled' : url == null || url == '', 'is-loading' : urlButtonIsLoading}" v-text="urlButtonText" ></button>
                
            </div>
        </div>

        <div class="section" v-if="blogDetailsEnabled" style="background-color:#f3f3f3">
            <div class="container">
                <h2 class="title is-2">
                    Information about your blog
                </h2>
                <p>Please fill in the information below before submitting</p>
                <div class="columns">
                    <div class="column"> <!-- First Column -->
                        <label class="label">Blog Title</label>
                        <p class="control">
                          <input :class="{ 'input':true, 'is-danger': blogTitle == null || blogTitle == ''}" v-model="blogTitle" type="text">
                          <span class="help is-danger" v-if="blogTitle == null || blogTitle == ''">This is a required field</span>
                        </p>
                        <label class="label">Blog Description</label>
                        <p class="control">
                          <input :class="{ 'input':true, 'is-danger': blogDescription == null || blogDescription == ''}" v-model="blogDescription" type="text">
                          <span class="help is-danger" v-if="blogDescription == null || blogDescription == ''">This is a required field</span>
                        </p>
                        <label class="label">Blog RSS</label>
                        <p class="control">
                          <input :class="{ 'input':true, 'is-danger': blogRss == null || blogRss == ''}" v-model="blogRss" type="text">
                          <span class="help is-danger" v-if="blogRss == null || blogRss == ''">This is a required field</span>
                        </p>
                        <label class="label">Pick Categories (Maximum 2)</label>
                        <p class="control" v-for="category in categories">
                          <label class="checkbox">
                            <input type="checkbox" :value="category.name" @change="guardCategoriesMaximum" v-model="checkedCategories">
                            @{{category.description}}
                          </label>
                        </p>
                    </div>
                    <div class="column"></div> <!-- Second column -->
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>
