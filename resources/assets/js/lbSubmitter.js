import categories from "./categories";
// app global data (state)
let lbSubmitter = {
  url: "",              // submitted url 
  urlButtonText: 'Submit',      // Text shown on the url submit button 
  urlButtonIsLoading: false,      // when this value is true, the button shows a loading spinner

  blogDetailsEnabled:false,     // when this value is false, the blog details pannel is hidden      
  blogUniqueWord:"",          // the unique blog username (example: beirutspring)
  blogDomain:"",            // the url of the blog
  blogTitle:"",           // the title of the blog
  blogDescription:"",         // the description of the blog
  blogRss:"",             // the rss feed of the blog
  blogRssIsLoading: false,      // show the spinner of rss loading  
  blogPosts: [],            // the list of posts

  twitterUsername: false,       // Twitter Details: username and Image
  twitterImageUrl: null,        // URL of twitter Image
  twitterIsLoading: false,      // status of twitter loading spinner
  twitterError: false,        // if fetching results in non-existing account

  categories: categories,       // the list of categories, as imported from categories.js file
  checkedCategories:["society"]   // an array of categories checked. by default, has society.
}
export default lbSubmitter;