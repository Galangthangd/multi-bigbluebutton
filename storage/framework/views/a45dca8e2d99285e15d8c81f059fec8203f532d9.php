<div class="form-group row align-items-center" :class="{'has-danger': errors.has('base_url'), 'has-success': fields.base_url && fields.base_url.valid }">
    <label for="base_url" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"><?php echo e(trans('admin.server.columns.base_url')); ?></label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.base_url" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('base_url'), 'form-control-success': fields.base_url && fields.base_url.valid}" id="base_url" name="base_url" placeholder="<?php echo e(trans('admin.server.columns.base_url')); ?>">
        <div v-if="errors.has('base_url')" class="form-control-feedback form-text" v-cloak>{{ errors.first('base_url') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sec_secret'), 'has-success': fields.sec_secret && fields.sec_secret.valid }">
    <label for="sec_secret" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"><?php echo e(trans('admin.server.columns.sec_secret')); ?></label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sec_secret" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sec_secret'), 'form-control-success': fields.sec_secret && fields.sec_secret.valid}" id="sec_secret" name="sec_secret" placeholder="<?php echo e(trans('admin.server.columns.sec_secret')); ?>">
        <div v-if="errors.has('sec_secret')" class="form-control-feedback form-text" v-cloak>{{ errors.first('sec_secret') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('weight'), 'has-success': fields.weight && fields.weight.valid }">
    <label for="weight" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"><?php echo e(trans('admin.server.columns.weight')); ?></label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.weight" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('weight'), 'form-control-success': fields.weight && fields.weight.valid}" id="weight" name="weight" placeholder="<?php echo e(trans('admin.server.columns.weight')); ?>">
        <div v-if="errors.has('weight')" class="form-control-feedback form-text" v-cloak>{{ errors.first('weight') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('enabled'), 'has-success': fields.enabled && fields.enabled.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="enabled" type="checkbox" v-model="form.enabled" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element">
        <label class="form-check-label" for="enabled">
            <?php echo e(trans('admin.server.columns.enabled')); ?>

        </label>
        <input type="hidden" name="enabled" :value="form.enabled">
        <div v-if="errors.has('enabled')" class="form-control-feedback form-text" v-cloak>{{ errors.first('enabled') }}</div>
    </div>
</div>


<?php /**PATH D:\xampp\htdocs\bbb-lb\resources\views/admin/server/components/form-elements.blade.php ENDPATH**/ ?>