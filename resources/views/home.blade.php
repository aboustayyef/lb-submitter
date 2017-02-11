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
                <p class="control">
                  <input @keyup="updateButton" class="input" v-model="url" type="text" placeholder="Enter URL here">
                </p>
                <button id="submit1" @click="getUrlDetails" :class="{'button is-primary' : true , 'is-disabled' : url == null || url == '' || !submittedUrlIsUrl, 'is-loading' : urlButtonIsLoading}" v-text="urlButtonText" ></button>
                
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
                        <label class="label">Unique Blog username</label>
                        <p class="control">
                          <input :class="{ 'input':true, 'is-danger': blogUniqueWord == null || blogUniqueWord == '' || uniqueWordContainsIllegalCharacters }" v-model="blogUniqueWord" type="text">
                          <span class="help is-danger" v-if="blogUniqueWord == null || blogUniqueWord == ''">This is a required field</span>
                          <span class="help is-danger" v-if="uniqueWordContainsIllegalCharacters">Can only use letters and numbers</span>
                        </p>
                        <label class="label">Blog Description</label>
                        <p class="control">
                          <input :class="{ 'input':true, 'is-danger': blogDescription == null || blogDescription == ''}" v-model="blogDescription" type="text">
                          <span class="help is-danger" v-if="blogDescription == null || blogDescription == ''">This is a required field</span>
                        </p>

                        <label class="label">Pick Categories (Maximum 2)</label>
                        <p class="control" v-for="category in categories">
                          <label class="checkbox">
                            <input type="checkbox" :value="category.name" @change="guardCategoriesMaximum" v-model="checkedCategories">
                            @{{category.description}}
                          </label>
                        </p>
                        <span class="help is-danger" v-if="checkedCategories.length == 0 ">You need to choose at least one category</span>
                        
           
                    </div>
                    <div class="column">
                        <div class="panel">
                            <p class="panel-heading">
                                Blog RSS
                            </p>
                            <div class="panel-block">
                                <p class="control">
                                  <input :class="{ 'input':true, 'is-danger': blogRss == null || blogRss == '' || ! rssIsURL}" v-model="blogRss" type="text" @blur="getRssContent">
                                  <span class="help is-danger" v-if="blogRss == null || blogRss == ''">This is a required field</span>
                                  <span class="help is-danger" v-if="!rssIsURL">This has to be a URL</span>
                                </p>
                            </div>
                            <div v-if="rssIsURL && blogPosts.length == 0 ">
                                <button class="button is-primary is-loading">&nbsp;</button> Loading your RSS content
                            </div>
                            <div v-for="post in blogPosts">
                                 <a class="panel-block" :href="post.url" >@{{post.title}}</a>
                            </div>
                        </div>
                    </div> <!-- Second column -->
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>
