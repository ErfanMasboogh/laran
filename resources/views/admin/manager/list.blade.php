@extends('laran::layouts.datatable')

@section('pageTitle', lt('Managers list'))

@section('button')
    <div>
        {{ html()->a(route('admin.manager.create'), lt('Create manager'))->class('btn btn-flat-primary') }}
    </div>
@endsection

@section('filter')
    <div class="col-md-auto mb-4">
        {{ html()->text('name', request('name'))->class('form-control')->placeholder(lt('Name')) }}
    </div>
    <div class="col-md-auto mb-4">
        {{ html()->text('family', request('family'))->class('form-control')->placeholder(lt('Family')) }}
    </div>
    <div class="col-md-auto mb-4">
        {{ html()->number('mobile', request('mobile'))->class('form-control')->placeholder(lt('Mobile'))->attributes(['min' => 0]) }}
    </div>
@endsection
