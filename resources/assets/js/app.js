
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import categories from './categories';
import VeeValidate from 'vee-validate';

// validation library
Vue.use(VeeValidate);

let app = new Vue({

	el: "#app",
	mounted: function(){
		let a = document.getElementsByClassName('is-hidden');
		Array.from(a).forEach((item) => item.classList.remove('is-hidden'));
	},
	data: {
		url: "", 							// submitted url 
		urlButtonText: 'Submit', 			// Text shown on the url submit button 
		urlButtonIsLoading: false,			// when this value is true, the button shows a loading spinner

		blogDetailsEnabled:false,			// when this value is false, the blog details pannel is hidden			
		blogUniqueWord:"",					// the unique blog username (example: beirutspring)
		blogDomain:"",						// the url of the blog
		blogTitle:"",						// the title of the blog
		blogDescription:"",					// the description of the blog
		blogRss:"",							// the rss feed of the blog
		blogRssIsLoading: false,			// show the spinner of rss loading	
		blogPosts: [],						// the list of posts
		blogUsernameIsUnique: true,			// Checking to see if blog username is unique. true by default to prevent premature errors
		blogUsernameIsLoading: false,		// spinner for when checking for username

		twitterUsername: null,				// Twitter Details: username and Image
		twitterImageUrl: null,				// URL of twitter Image
		twitterIsLoading: false,			// status of twitter loading spinner
		twitterError: false,				// if fetching results in non-existing account

		categories: categories,				// the list of categories, as imported from categories.js file
		checkedCategories:["society"]		// an array of categories checked. by default, has society.
	},
	computed:{
		formHasErrors: function(){
			return this.errors.errors.length > 0 || this.blogPosts.length < 1 || this.checkedCategories.length <1 || this.checkedCategories.length > 2 || ! this.blogUsernameIsUnique;
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
			// this.url = '';

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
				    this.checkUsernameUnique();
				    this.blogDescription = response.data.result.description;
				    this.blogRss = response.data.result.feed;
				    this.twitterUsername = '';
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
				     	this.blogPosts = response.data.finalItems;
				     	this.blogRssIsLoading = false;
			     	} else {
			     		this.blogRssIsLoading = false;
			     		this.blogPosts = [];
			     	}
			     }
		)},

		getTwitterDetails: function(){
			this.twitterIsLoading = true;
			this.twitterImageUrl = null;
			axios.get('/api/twitterDetails?username=' + this.twitterUsername)
			     .then((response) => {
			     	if (response.data.status == 'ok') {
				     	this.twitterImageUrl = response.data.result.profile_image_url.replace('_normal','');
				     	this.twitterError = false;
			     	} else {
			     		this.twitterError = true;	
			     	}
				    this.twitterIsLoading = false;
			     }
		)},

		checkUsernameUnique: function(){
			this.blogUsernameIsLoading = true;
			axios.get('/api/usernameExists?blogId=' + this.blogUniqueWord)
				.then((response) => {
					if (response.data.status == 'ok') {
						if (response.data.result == true) {
							this.blogUsernameIsUnique = false;
						} else {
							this.blogUsernameIsUnique = true;
						}
					} else {
						// nothing for now
					}
					this.blogUsernameIsLoading = false;
				}
		)},

		// makes sure user doesn't select more than two categories
		guardCategoriesMaximum: function(){
			if (this.checkedCategories.length > 2) {
				this.checkedCategories.splice(-1,1);
			}
		},

		 validateBeforeSubmit() {
            
        }
	}
});