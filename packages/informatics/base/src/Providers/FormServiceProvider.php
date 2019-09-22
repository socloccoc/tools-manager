<?php


namespace Informatics\Base\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Form::component('cTextEditor', 'base::components.texteditor', ['title', 'id', 'name', 'value', 'height', 'attributes' => []]);
        Form::component('cMenuItem', 'menu::partials.item', ['menu']);
        Form::component('cText', 'base::components.text', ['title', 'name', 'value', 'attributes' => []]);
        Form::component('cSelect', 'base::components.select', ['title', 'name', 'value' => [], 'selected','attributes' => []]);
        Form::component('cSwitch', 'base::components.switch', ['title', 'name', 'value', 'checked','attributes' => []]);
        Form::component('cFileSingle', 'base::components.file_single', ['title', 'name', 'value', 'width', 'height', 'attributes' =>[]]);
    }
}