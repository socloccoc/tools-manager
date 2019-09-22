@php($id = strtr($name,["[" => "_","]" => "_"]))
<div class="form-group">
    <label class="control-label">{{$title}}</label>
    <input class="hide" name="{{$name}}" id="{{$id}}" type="text" value="{{$value}}">
    @php($preview = $value?$value:'/image/no_image.png')
    <div class="control-label">
        <img id="preview_{{$id}}" src="{{$preview}}"
             style="width: {{$width ? $width : '100%'}}">
        <div class="form-group" style="margin-top: 10px">
            <button type="button" class="btn btn-primary filemanager_single" data-input="{{$id}}"
                    data-preview="preview_{{$id}}">Chọn hình
            </button>
        </div>

    </div>
</div>
