@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.server.actions.edit', ['name' => $server->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <server-form
                :action="'{{ $server->resource_url }}'"
                :data="{{ $server->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.server.actions.edit', ['name' => $server->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.server.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </server-form>

        </div>
    
</div>

@endsection