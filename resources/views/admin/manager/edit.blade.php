@extends('laran::layouts.admin')

@section('pageTitle', lt('Edit manager'))

@section('content')
    {{ html()->form('POST', route('admin.manager.update', $manager->ID))->acceptsFiles()->open() }}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Name'), 'name')->class('control-label required') }}
                        {{ html()->text('name', old('name', $manager->name))->class('form-control')->placeholder(lt('Name')) }}
                    </div>
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Family'), 'family')->class('control-label required') }}
                        {{ html()->text('family', old('family', $manager->family))->class('form-control')->placeholder(lt('Family')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Image'), 'image')->class('control-label') }}
                        <x-laran::file-uploader name="image" accept="{{ config('laran.storage.types.image.accept') }}"
                         :SID="$manager->imageSID"   />
                    </div>
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Mobile'), 'mobile')->class('control-label required') }}
                        {{ html()->number('mobile', old('mobile', $manager->mobile))->class('form-control')->placeholder(lt('Mobile'))->attributes(['min' => 0]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="card mt-5">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-4">
                {{ html()->label(lt('Current password'), 'currentPassword')->class('control-label') }}
                {{ html()->password('currentPassword', old('currentPassword'))->class('form-control')->placeholder(lt('Current password')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                {{ html()->label(lt('New password'), 'password')->class('control-label') }}
                {{ html()->password('password')->class('form-control')->placeholder(lt('New password')) }}
            </div>
            <div class="col-md-6 mb-4">
                {{ html()->label(lt('New password confirmation'), 'password_confirmation')->class('control-label') }}
                {{ html()->password('password_confirmation')->class('form-control')->placeholder(lt('New password confirmation')) }}
            </div>
        </div>
    </div>
</div>
    <div class="card mt-5">
        <div class="card-body">
            <div class="text-right">
                <div class="gap-2">
                    {{ html()->submit(lt('Submit'))->class('btn btn-primary') }}
                    {{ html()->a(route('admin.manager.list'), lt('Return'))->class('btn btn-secondary') }}
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection
