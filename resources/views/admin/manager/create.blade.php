@extends('laran::layouts.admin')

@section('pageTitle', lt('Create manager'))

@section('content')
    {{ html()->form('POST', route('admin.manager.store'))->acceptsFiles()->open() }}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Name'), 'name')->class('control-label required') }}
                        {{ html()->text('name', old('name'))->class('form-control')->placeholder(lt('Name')) }}
                    </div>
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Family'), 'family')->class('control-label required') }}
                        {{ html()->text('family', old('family'))->class('form-control')->placeholder(lt('Family')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Mobile'), 'mobile')->class('control-label required') }}
                        {{ html()->number('mobile', old('mobile'))->class('form-control')->placeholder(lt('Mobile'))->attributes(['min' => 0]) }}
                    </div>
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Password'), 'password')->class('control-label required') }}
                        {{ html()->password('password', old('password'))->class('form-control')->placeholder(lt('Password')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Image'), 'image')->class('control-label') }}
                        <x-laran::file-uploader name="image" accept="{{ config('laran.storage.types.image.accept') }}" />
                    </div>
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
    {{ html()->form('POST')->close() }}
@endsection
