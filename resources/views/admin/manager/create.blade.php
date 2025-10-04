@extends('laran::layouts.admin')

@section('pageTitle', lt('Create manager'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Name'), 'name')->class('control-label') }}
                        {{ html()->text('name', old('name'))->class('form-control')->placeholder(lt('Name')) }}
                    </div>
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Family'), 'family')->class('control-label') }}
                        {{ html()->text('family', old('family'))->class('form-control')->placeholder(lt('Family')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Mobile'), 'mobile')->class('control-label') }}
                        {{ html()->number('mobile', old('mobile'))->class('form-control')->placeholder(lt('Mobile'))->attributes(['min' => 0]) }}
                    </div>
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Password'), 'password')->class('control-label') }}
                        {{ html()->password('password', old('password'))->class('form-control')->placeholder(lt('Password')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        {{ html()->label(lt('Image'), 'image')->class('control-label') }}
                        <x-laran::file-uploader name="image" />
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
                    {{ html()->a('#', lt('Return'))->class('btn btn-secondary') }}
                </div>
            </div>
        </div>
    </div>
@endsection
