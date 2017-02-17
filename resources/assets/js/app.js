
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import categories from './categories';
require('./test-component');
import VeeValidate from 'vee-validate';

// validation library
Vue.use(VeeValidate);

// app global data (state)
let lbSubmitter = {
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

	twitterUsername: false,				// Twitter Details: username and Image
	twitterImageUrl: null,				// URL of twitter Image
	twitterIsLoading: false,			// status of twitter loading spinner
	twitterError: false,				// if fetching results in non-existing account

	categories: categories,				// the list of categories, as imported from categories.js file
	checkedCategories:["society"]		// an array of categories checked. by default, has society.
}

let app = new Vue({

	el: "#app",

	data: {
		lbSubmitter: lbSubmitter
	},
	
	methods:{
		
		// listening to key events on url field
		
		updateButton: function(e){
			let key = e.code;
			if (key == 'Enter') {this.getUrlDetails()};
		},

		
		getUrlDetails: function(){
			// show loading spinner
			this.lbSubmitter.urlButtonIsLoading = true;
			// clear search field
			let urlToUse = this.lbSubmitter.url;
			this.lbSubmitter.url = '';
			// hide details panel if previously existed
			this.lbSubmitter.blogDetailsEnabled = false;


			// request data from api

			axios.get('/api/urlDetails?url=' + urlToUse)
			  .then( (response) => {

			    // remove loading spinner
			    this.lbSubmitter.urlButtonIsLoading = false;
			    this.lbSubmitter.urlButtonText = "Refresh";

			    if (response.data.status != 'error') {
				    this.lbSubmitter.blogDetailsEnabled = true;
				    this.lbSubmitter.blogTitle = response.data.result.title;
				    this.lbSubmitter.blogUniqueWord = response.data.result.domain;
				    this.lbSubmitter.blogDescription = response.data.result.description;
				    this.lbSubmitter.blogRss = response.data.result.feed;
				    this.getRssContent();
			    }

			  })
			  .catch(function (error) {
			    console.log(error);
			  });
		},

		getRssContent: function(){
			this.lbSubmitter.blogPosts = [];
			this.lbSubmitter.blogRssIsLoading = true;
			axios.get('/api/feedDetails?url=' + this.lbSubmitter.blogRss)
			     .then((response) => {
			     	if (response.data.status == 'ok') {
				     	this.lbSubmitter.blogPosts = response.data.finalItems;
				     	this.lbSubmitter.blogRssIsLoading = false;
			     	}
			     }
		)},

		getTwitterDetails: function(){
			this.lbSubmitter.twitterIsLoading = true;
			this.lbSubmitter.twitterImageUrl = null;
			axios.get('/api/twitterDetails?username=' + this.lbSubmitter.twitterUsername)
			     .then((response) => {
			     	if (response.data.status == 'ok') {
				     	this.lbSubmitter.twitterImageUrl = response.data.result.profile_image_url.replace('_normal','');
				     	this.lbSubmitter.twitterError = false;
			     	} else {
			     		this.lbSubmitter.twitterError = true;	
			     	}
				    this.lbSubmitter.twitterIsLoading = false;
			     }
		)},

		// makes sure user doesn't select more than two categories
		guardCategoriesMaximum: function(){
			if (this.lbSubmitter.checkedCategories.length > 2) {
				this.lbSubmitter.checkedCategories.splice(-1,1);
			}
		}
	}
});