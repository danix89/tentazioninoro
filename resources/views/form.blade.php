@section('content')
 
    {!! Form::model($user, [
        'route' => isset($user->id) ? ['user.update', $user->id] : 'user.store', 
        'method' => isset($user->id) ? 'put' : 'post'
        ]) !!}
 
        <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
            {!! Form::label('firstname', 'Firstname') !!}
            {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
            @foreach($errors->get('firstname') as $error)
                <span class="help-block">{{ $error }}</span>
            @endforeach
        </div>
 
        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
 
 
    {!! Form::close() !!}
 
@endsection