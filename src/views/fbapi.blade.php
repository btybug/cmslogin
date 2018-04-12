@extends('btybug::layouts.admin')
@section('content')
    {!! Form::model($data,['class' => 'form-horizontal']) !!}
    <fieldset>
        <!-- Form Name -->
        <legend>Cms login Settings</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="client_id">Client ID</label>
            <div class="col-md-4">
                {!! Form::text('client_id',null,['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="client_secret">Client Secret</label>
            <div class="col-md-4">
                {!! Form::text('client_secret',null,['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="callbackurl">Call Back Url</label>
            <div class="col-md-4">
                <input id="callbackurl" type="text" readonly value="{{ url('apiuser-api/callback') }}" class="form-control input-md">
                <span class="help-block">Use this url to create App</span>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-4">
                {!! Form::submit('Save',['class' => 'btn btn-info']) !!}
            </div>
        </div>

    </fieldset>
    {!! Form::close() !!}
@stop


