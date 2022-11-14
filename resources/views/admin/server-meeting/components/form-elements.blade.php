<div class="form-group row align-items-center" :class="{'has-danger': errors.has('server_id'), 'has-success': fields.server_id && fields.server_id.valid }">
    <label for="server_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.server-meeting.columns.server_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.server_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('server_id'), 'form-control-success': fields.server_id && fields.server_id.valid}" id="server_id" name="server_id" placeholder="{{ trans('admin.server-meeting.columns.server_id') }}">
        <div v-if="errors.has('server_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('server_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('meeting_id'), 'has-success': fields.meeting_id && fields.meeting_id.valid }">
    <label for="meeting_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.server-meeting.columns.meeting_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.meeting_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('meeting_id'), 'form-control-success': fields.meeting_id && fields.meeting_id.valid}" id="meeting_id" name="meeting_id" placeholder="{{ trans('admin.server-meeting.columns.meeting_id') }}">
        <div v-if="errors.has('meeting_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('meeting_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('meeting_name'), 'has-success': fields.meeting_name && fields.meeting_name.valid }">
    <label for="meeting_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.server-meeting.columns.meeting_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.meeting_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('meeting_name'), 'form-control-success': fields.meeting_name && fields.meeting_name.valid}" id="meeting_name" name="meeting_name" placeholder="{{ trans('admin.server-meeting.columns.meeting_name') }}">
        <div v-if="errors.has('meeting_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('meeting_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.server-meeting.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.server-meeting.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('start_time'), 'has-success': fields.start_time && fields.start_time.valid }">
    <label for="start_time" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.server-meeting.columns.start_time') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.start_time" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('start_time'), 'form-control-success': fields.start_time && fields.start_time.valid}" id="start_time" name="start_time" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('start_time')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('start_time') }}</div>
    </div>
</div>


