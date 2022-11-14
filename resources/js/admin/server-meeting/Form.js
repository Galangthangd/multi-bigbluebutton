import AppForm from '../app-components/Form/AppForm';

Vue.component('server-meeting-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                server_id:  '' ,
                meeting_id:  '' ,
                meeting_name:  '' ,
                status:  '' ,
                start_time:  '' ,
                
            }
        }
    }

});