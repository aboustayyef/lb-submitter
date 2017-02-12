
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import categories from './categories';

// utility function to return true or false if a string is a url
let isUrl = function($st){
	if ($st.match(/^(https?:\/\/)?([\da-z\.-]+\.[a-z\.]{2,6}|[\d\.]+)([\/:?=&#]{1}[\da-z\.-]+)*[\/\?]?$/i)) {
		return true;
	}
	return false;
}

let isAlphaNumeric = function($st){
	if ($st.match(/^([0-9]|[a-z])+([0-9a-z]+)$/i)) {
		return true;
	}
	return false;
};

let app = new Vue({

	el: "#app",

	data: {
		url: '', 							// submitted url 
		urlButtonText: 'Submit', 			// Text shown on the url submit button 
		urlButtonIsLoading: false,			// when this value is true, the button shows a loading spinner

		blogDetailsEnabled:false,			// when this value is false, the blog details pannel is hidden			
		blogUniqueWord:'',					// the unique blog username (example: beirutspring)
		blogDomain:"",						// the url of the blog
		blogTitle:"",						// the title of the blog
		blogDescription:"",					// the description of the blog
		blogRss:"",							// the rss feed of the blog
		blogRssIsLoading: false,			// show the spinner of rss loading	
		blogPosts: [],						// the list of posts

		categories: categories,				// the list of categories, as imported from categories.js file
		checkedCategories:["society"]		// an array of categories checked. by default, has society.
	},

	computed: {

		submittedUrlIsUrl: function(){
			return isUrl(this.url);
		},
		
		rssIsURL: function(){
			return isUrl(this.blogRss);
		},

		uniqueWordContainsIllegalCharacters: function(){
			return ! isAlphaNumeric(this.blogUniqueWord);
		}
	},
	
	methods:{
		
		// listening to key events on url field
		
		updateButton: function(e){
			let key = e.code;
			if (key == 'Enter') {this.getUrlDetails()};
		},

		
		getUrlDetails: function(){
			// show loading spinner
			this.urlButtonIsLoading = true;
			// clear search field
			let urlToUse = this.url;
			this.url = '';

			// hide details panel if previously existed
			this.blogDetailsEnabled = false;


			// request data from api

			axios.get('/api/urlDetails?url=' + urlToUse)
			  .then( (response) => {

			    // remove loading spinner
			    this.urlButtonIsLoading = false;
			    this.urlButtonText = "Refresh";

			    if (response.data.status != 'error') {
				    this.blogDetailsEnabled = true;
				    this.blogTitle = response.data.result.title;
				    this.blogUniqueWord = response.data.result.domain;
				    this.blogDescription = response.data.result.description;
				    this.blogRss = response.data.result.feed;
				    this.getRssContent();
			    }

			  })
			  .catch(function (error) {
			    console.log(error);
			  });
		},

		getRssContent: function(){
			this.blogPosts = [];
			this.blogRssIsLoading = true;
			axios.get('/api/feedDetails?url=' + this.blogRss)
			     .then((response) => {
			     	if (response.data.status == 'ok') {
				     	this.blogRssIsLoading = false;
				     	this.blogPosts = response.data.finalItems;
			     	}
			     }
		)},

		// makes sure user doesn't select more than two categories
		guardCategoriesMaximum: function(){
			if (this.checkedCategories.length > 2) {
				this.checkedCategories.splice(-1,1);
			}
		}
	}
});