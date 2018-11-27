<?php
    return ['Templates' => [
            'Form'=>[
                'Bootstrap' => [
                    'formStart'      => '<form class="form-horizontal" {{attrs}}>',
                    'input'          => '<div class="col-sm-7"><input type="{{type}}" name="{{name}}" {{attrs}} class="form-control" /></div>',
                    'label'          => '<label class="col-sm-3 control-label" {{attrs}}>{{text}}</label>',
                    'inputContainer' => '<div class="form-group {{required}}" form-type="{{type}}">{{content}}</div>',
                    'inputContainerError' => '<div class="form-group {{type}}{{required}} contain-error">{{content}}{{error}}</div>',
                    'inputSubmit'    => '<div><input type="{{type}}"{{attrs}}/></div>',
                    'select'         => '<div class="col-sm-7"><select name="{{name}}"{{attrs}} class="form-control">{{content}}</select></div>',
                    'error'          => '<span class="error col-sm-7 col-sm-offset-4">{{content}}</span>',
                    'textarea'       => '<div class="col-sm-7"><textarea name="{{name}}"{{attrs}} class="form-control">{{value}}</textarea></div>',
                ],
                'Simple' => [
                    'label'          => '<label class="col-sm-3 control-label" {{attrs}}>{{text}}</label>',
                    'inputContainer' => '<div class="simple form-group {{required}}" form-type="{{type}}">{{content}}</div>',
                    'inputContainerError' => '<div class="form-group {{type}}{{required}} contain-error">{{content}}{{error}}</div>',
                    'select'         => '<div class="col-sm-9"><select name="{{name}}"{{attrs}} class="form-control">{{content}}</select></div>'
                ]
            ]
        ]
    ]
?>