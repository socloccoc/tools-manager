<div class="form-group">
    {{ Form::label($name,$title) }}
    {{ Form::text($name, $value, array_merge(['class' => "form-control", 'placeholder'=>'...'], $attributes)) }}
</div>