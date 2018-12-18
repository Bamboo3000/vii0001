<?php namespace Sative\Contact;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Sative\Contact\Components\Form' => 'form'
        ];
    }

    public function registerSettings()
    {
    }
}
