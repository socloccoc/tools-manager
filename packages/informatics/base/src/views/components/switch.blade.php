<div class="form-group">
    {{ Form::label(null,$title) }}
    <div class="checkbox checkbox-switch" style="margin-top: 0px;margin-bottom: 25px;">
        <input class="hide" name="{{$name}}" value="0">
        {{ Form::checkbox($name, $value, $checked ,array_merge(['class' => 'switch', 'id'=>$name, 'data-on-color'=>"success", 'data-off-color'=>"default", 'data-on-text'=>"On", 'data-off-text'=>"Off"], (array) $attributes)) }}
    </div>
</div>