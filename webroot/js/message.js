/**
 * Copyright (c) DevString Online Solution
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) DevString
 * @author        DevString
 * @link          http://www.cakestrap.com
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

var Message = {
    Buttons : {
        Yes:function(text) {
            var button = this._Button('btn-danger btn-message', text, 'Yes');
            $('#message').find('.modal-footer').append(button);
        },
        Cancel:function(text) {
            var button = this._Button('btn-default btn-message', text, 'Cancel');
            $('#message').find('.modal-footer').append(button);
        },
        Close:function(text) {
            var button =  '<button  data-dismiss="modal" type="button" class="btn btn-default" id="ButtonClose">' + text + '</button>';
            $('#message').find('.modal-footer').append(button);
        },
        _Button:function(btn, text, id) {
            return '<button type="button" class="btn ' + btn + '" id="'+ id +'">' + text + '</button>';
        }
    },
    Action: {
        Alert:function(config) {
            this.Set(config);
            $('#message').modal({backdrop: 'dynamic'}).show();
        },
        Confirm:function(config) {
            this.Set(config);
            $('#message').modal({backdrop: 'static'}).show();
        },
        Set:function(config) {
            var $message = $('#message');
            var $modalHeader = $message.find('.modal-header');
            $message.find('.modal-title').text(config.title);
            $message.find('.modal-body').text(config.text);
            $message.find('.modal-footer').empty();
            $modalHeader.removeClass().addClass('modal-header');
            if(config.type != undefined) {
                $modalHeader.addClass(config.type);
            }

            $.each(config.button, function(n, t) {
                if(n === 'Yes') return Message.Buttons.Yes(t);
                if(n === 'Cancel') return Message.Buttons.Cancel(t);
                if(n === 'Close') return Message.Buttons.Close(t);
            })
        }
    }
};
