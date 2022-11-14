import AppForm from '../app-components/Form/AppForm';

Vue.component('server-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                base_url:  '' ,
                sec_secret:  '' ,
                weight:  '' ,
                enabled:  false ,
                
            }
        }
    }

});