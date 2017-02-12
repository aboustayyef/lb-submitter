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
                <p :class="{'control':true, 'is-loading': urlButtonIsLoading }">
                    <input name="Submit" v-validate="'url'" @keyup="updateButton" :class="{'input':true, 'is-danger': errors.has('Submit')}" v-model="url" type="text" :disabled="urlButtonIsLoading" :placeholder="urlButtonIsLoading? 'Loading Details' : 'Enter URL here'">
                    <span class="help is-danger" v-if="errors.has('Submit')">@{{ errors.first('Submit') }}</span>
                </p>
                <button v-if="!urlButtonIsLoading" id="submit1" @click="getUrlDetails" :class="{'button is-primary' : true , 'is-disabled' : errors.has('Submit') || url== '' || url == null}" v-text="urlButtonText" ></button>
                
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

                        <label class="label">Twitter Username (without the @)</label>
                        <p :class="{'control':true, 'is-loading': twitterIsLoading}">
                            <input v-validate="'required|alpha_dash'" :class="{ 'input':true, 'is-danger': errors.has('Twitter Username') || twitterError }" name="Twitter Username" v-model="twitterUsername" type="text" @blur="getTwitterDetails">
                            <span class="help is-danger" v-if="errors.has('Twitter Username')">@{{ errors.first('Twitter Username') }}</span>
                        </p>

                        <label class="label">Blog Title</label>
                        <p class="control">
                            <input v-validate="'required|max:50'" :class="{ 'input':true, 'is-danger': errors.has('Blog Title') }" name="Blog Title" v-model="blogTitle" type="text">
                            <span class="help is-danger" v-if="errors.has('Blog Title')">@{{ errors.first('Blog Title') }}</span>
                        </p>

                        <label class="label">Unique Blog Username</label>
                        <p class="control">
                            <input name="Unique Blog Username" v-validate="'required|min:5|alpha_num'" :class="{ 'input':true, 'is-danger': errors.has('Unique Blog Username') }" v-model="blogUniqueWord" type="text">
                            <span class="help is-danger" v-if="errors.has('Unique Blog Username')">@{{ errors.first('Unique Blog Username') }}</span>
                        </p>

                        <label class="label">Blog Description</label>
                        <p class="control">
                          <input name="Blog Description" v-validate="'required|min:10|max:100'" :class="{ 'input':true, 'is-danger': errors.has('Blog Description') }" v-model="blogDescription" type="text">
                          <span class="help is-danger" v-if="errors.has('Blog Description')">@{{ errors.first('Blog Description') }} </span>
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
                        <figure class="image is-128x128 has-space-under">
                            <img :src="twitterImageUrl">
                        </figure>
                        <div class="box">
                            <h3 class="title is-4">
                                Your Blog's Feed (RSS)
                            </h3>
                            <p class="control has-addons">
                              <input name="RSS" v-validate="'required|url'" :class=" { 'input':true, 'is-expanded':true, 'is-danger': errors.has('RSS')}" v-model="blogRss" type="text" @blur="getRssContent">
                              <a class="button is-info">
                                Update
                              </a>
                            </p>
                              <span class="help is-danger" v-if="errors.has('RSS')">@{{errors.first('RSS')}}</span>

                            <div v-if="blogRssIsLoading">
                                <button class="button is-primary is-loading">&nbsp;</button> Loading your RSS content
                            </div>
                            <ul>
                                <li v-for="post in blogPosts">
                                     <a :href="post.url" >@{{post.title}}</a>
                                </li>
                            </ul>
                        </div>
                    </div> <!-- Second column -->
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>
