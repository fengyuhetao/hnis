var FormEditable = function(){
    var initEditables = function() {
        // 禁用编辑功能
        $.fn.editable.defaults.disabled = true;
        //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $.fn.editable.defaults.url = url;
        $.fn.editable.defaults.ajaxOptions = {
            type: 'put',
            dataType: 'json'
        };
        $.fn.editable.defaults.params = function(params) {
            params._token = token;
            params[params.name]= params.value;
            return params;
        };
        $.fn.editable.defaults.success = function(response, newValue) {
            // 如果code值为0，修改失败
            if(response.code == 0) {
                return response.result;
            }
        };
        //editables element samples 
        $('#admin_name').editable({
            type: 'text',
            title: '请输入真实姓名',
            validate: function(value) {
                if($.trim(value) == '') {
                    return '该字段不能为空';
                }

                if(value.length > 30) {
                    return '用户名过长';
                }
            },
            error: function(response, newValue) {
                // 422表明验证未通过
                if(response.status === 422) {
                    var result = JSON.parse(response.responseText);
                    result = result['admin_username'][0];
                    return result['string'];
                } else {
                    return response.responseText;
                }
            }
        });

        $('#admin_sex').editable({
            inputclass: 'form-control',
            source: [{
                value: "男",
                text: '男'
            }, {
                value: "女",
                text: '女'
            }],
            display: function(value, sourceData) {
                var colors = {
                        "": "gray",
                        1: "green",
                        2: "blue"
                    },
                    elem = $.grep(sourceData, function(o) {
                        return o.value == value;
                    });

                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            },
            validate: function(value) {
                if($.trim(value) == '') {
                    return '你尚未选择';
                }
            },
            error: function(response, newValue) {
                // 422表明验证未通过
                if(response.status === 422) {
                    var result = JSON.parse(response.responseText);
                    result = result['admin_sex'][0];
                    return result;
                } else {
                    return response.responseText;
                }
            }
        });

        $('#admin_username').editable({
            type: 'text',
            title: '请输入账号',
            validate: function(value) {
                if($.trim(value) == '') {
                    return '该字段不能为空';
                }

                if(value.length > 30) {
                    return '账号过长';
                }
            },
            error: function(response, newValue) {
                // 422表明验证未通过
                if(response.status === 422) {
                    var result = JSON.parse(response.responseText);
                    result = result['admin_username'][0];
                    return result['string'];
                } else {
                    return response.responseText;
                }
            }
        });

        $('#admin_email').editable({
            type: 'text',
            title: '请输入邮箱',
            validate: function(value) {
                if($.trim(value) == '') {
                    return '该字段不能为空';
                }

                var myReg = /^[-._A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
                if(!myReg.test($.trim(value))) {
                    return "邮箱格式不正确";
                }
            },
            error: function(response, newValue) {
                // 422表明验证未通过
                if(response.status === 422) {
                    var result = JSON.parse(response.responseText);
                    result = result['admin_email'][0];
                    return result;
                } else {
                    return response.responseText;
                }
            }
        });

        $('#admin_tel').editable({
            type: 'text',
            title: '请输入电话号码',
            validate: function(value) {
                if($.trim(value) == '') {
                    return '该字段不能为空';
                }

                var myReg = /^1[34578][0-9]{9}$/;
                if(!myReg.test($.trim(value))) {
                    return '电话号码格式不正确';
                }
            },
            error: function(response, newValue) {
                // 422表明验证未通过
                if(response.status === 422) {
                    var result = JSON.parse(response.responseText);
                    result = result['admin_tel'][0];
                    return result;
                } else {
                    return response.responseText;
                }
            }
        });

        $('#admin_is_use').editable({
            inputclass: 'form-control',
            source: [{
                value: 1,
                text: '启用'
            }, {
                value: 0,
                text: '禁用'
            }],
            display: function(value, sourceData) {
                var colors = {
                        "": "gray",
                        1: "green",
                        2: "blue"
                    },
                    elem = $.grep(sourceData, function(o) {
                        return o.value == value;
                    });

                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            },
            validate: function(value) {
                if($.trim(value) == '') {
                    return '你尚未选择';
                }
            },
            error: function(response, newValue) {
                // 422表明验证未通过
                if(response.status === 422) {
                    var result = JSON.parse(response.responseText);
                    result = result['admin_is_use'][0];
                    return result;
                } else {
                    return response.responseText;
                }
            }
        });
    };

    return {
        //main function to initiate the module
        init: function() {
            // init editable elements
            initEditables();

            // init editable toggler
            $('#enable').click(function() {
                $('#admin .editable').editable('toggleDisabled');
                $('#hidden_button').toggle();
            });
        }

    };

}();

// jQuery(document).ready(function() {
//     FormEditable.init();
// });