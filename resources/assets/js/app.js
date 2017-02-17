
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VeeValidate from 'vee-validate';

// App data (state)
import lbSubmitter from './lbSubmitter';
require('./components/enter-url');

// validation library
Vue.use(VeeValidate);

let app = new Vue({

	el: "#app",

	data: {
		lbSubmitter: lbSubmitter
	},
	
	methods:{
		
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