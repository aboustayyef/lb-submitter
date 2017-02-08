
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

		categories: categories,				// the list of categories, as imported from categories.js file
		checkedCategories:["society"]		// an array of categories checked. by default, has society.
	},

	computed: {

		submittedUrlIsUrl: function(){
			return isUrl(this.url);
		},
		
		rssIsURL: function(){
			return isUrl(this.blogRss);
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
			let theapp = this; // axios enclosure will no longer have access to "this"

			axios.get('/api/urlDetails?url=' + urlToUse)
			  .then(function (response) {

			    // remove loading spinner
			    theapp.urlButtonIsLoading = false;
			    theapp.urlButtonText = "Refresh";

			    if (response.data.status != 'error') {
				    theapp.blogDetailsEnabled = true;
				    theapp.blogTitle = response.data.result.title;
				    theapp.blogUniqueWord = response.data.result.domain;
				    theapp.blogDescription = response.data.result.description;
				    theapp.blogRss = response.data.result.feed;
			    }

			  })
			  .catch(function (error) {
			    console.log(error);
			  });
		},

		// makes sure user doesn't select more than two categories
		guardCategoriesMaximum: function(){
			if (this.checkedCategories.length > 2) {
				this.checkedCategories.splice(-1,1);
			}
		}
	}
});