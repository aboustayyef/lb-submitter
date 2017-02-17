// app global variable (state)
import lbSubmitter from '../lbSubmitter';

// register
Vue.component('enter-url', {
  template: `
        <div class="section">
            <div class="container">
                <h1 class="title is-1">Submit your blog!</h1>
                <p :class="{'control':true, 'is-loading': urlButtonIsLoading }">
                    <input name="Submit" v-validate="'url'" @keyup="updateButton" :class="{'input':true, 'is-danger': errors.has('Submit')}" v-model="url" type="text" :disabled="urlButtonIsLoading" :placeholder="urlButtonIsLoading? 'Loading Details' : 'Enter URL here'">
                    <span class="help is-danger" v-if="errors.has('Submit')">{{ errors.first('Submit') }}</span>
                </p>
                <button v-if="!urlButtonIsLoading" id="submit1" @click="getUrlDetails" :class="{'button is-primary' : true , 'is-disabled' : errors.has('Submit') || url== '' || url == null}" v-text="urlButtonText" ></button>
                
            </div>
        </div>
    `,
  data: function(){
  	return lbSubmitter;
  },
  methods: {
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
  }
});