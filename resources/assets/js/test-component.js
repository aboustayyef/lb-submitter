import lbSubmitter from './lbSubmitter';

// register
Vue.component('test-component', {
  template: '<div>A custom component! {{this.url}}</div>',
  data: function(){
  	return lbSubmitter;
  }
});