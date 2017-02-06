
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import categories from './categories';

console.log(categories);

let app = new Vue({
	el: "#app",
	data: {
		url: '',
		urlButtonText: 'Submit',
		urlButtonIsLoading: false,
		urlDetails:{},
		blogDetailsEnabled:false,
		blogDomain:"",
		blogTitle:"",
		blogDescription:"",
		blogRss:"",
		categories: categories,
		checkedCategories:["society"]
	},
	
	methods:{
		
		//code to activate submit button and to listen to key events on url field
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