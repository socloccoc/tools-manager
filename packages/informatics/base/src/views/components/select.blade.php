<div class="form-group">
    {{ Form::label($name,$title) }}
    {{ Form::select($name, $value, $selected, array_merge(['class'=>'form-control select2 custom'], (array) $attributes)) }}
</div>