var UITree = function () {
    var refresh = function() {
        $('#tree_3').jstree(true).refresh();
    };

    var contextualMenuSample = function() {

        $("#tree_3").jstree({
            "core" : {
                "themes" : {
                    "responsive": true
                }, 
                // so that create works
                "check_callback" : true,
                'data': {
                    "url" : "privilege/list",
                    "dataType" : "json"     // needed only if you do not supply JSON headers
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
            "state" : { "key" : "demo2" },
            "plugins" : [ "contextmenu", "dnd", "state", "types" ],
            "contextmenu":{
                items : function (o, cb) { // Could be an object directly
                    var menu = {
                        "rename" : {
                            "separator_before"	: false,
                            "separator_after"	: false,
                            "_disabled"			: false, //(this.check("rename_node", data.reference, this.get_parent(data.reference), "")),
                            "label"				: "重命名",
                            /*!
                             "shortcut"			: 113,
                             "shortcut_label"	: 'F2',
                             "icon"				: "glyphicon glyphicon-leaf",
                             */
                            "action"			: function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.edit(obj);
                            }
                        },
                        "remove" : {
                            "separator_before"	: false,
                            "icon"				: false,
                            "separator_after"	: false,
                            "_disabled"			: false, //(this.check("delete_node", data.reference, this.get_parent(data.reference), "")),
                            "label"				: "删除",
                            "action"			: function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                if(inst.is_selected(obj)) {
                                    inst.delete_node(inst.get_selected());
                                }
                                else {
                                    inst.delete_node(obj);
                                }
                            }
                        }
                    };

                    if(o.parents.length < 4) {
                        menu.create = {
                            "separator_before"	: false,
                                "separator_after"	: true,
                                "_disabled"			: false, //(this.check("create_node", data.reference, {}, "last")),
                                "label"				: "创建",
                                "action"			: function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {}, "last", function (new_node) {
                                    setTimeout(function () { inst.edit(new_node); },0);
                                });
                            }
                        };
                    }
                    return menu;
                }
            }
        });


    }

    $("#tree_3").on("select_node.jstree", function(event, data) {
        $.ajax({
            'url' : 'privilege/getPrivilegeById',
            'type': 'get',
            'data': {'pri_id': data.node.id},
            'dataType': 'json',
            success: function(data) {
                $("input[name=pri_name]")[0].value = data.pri_name;
                $("input[name=pri_url]")[0].value = data.pri_url;
                $("input[name=pri_icon]")[0].value = data.pri_icon;
                $("input[name=pri_id]")[0].value = data.pri_id;
            }
        });
    });

    $("#tree_3").on("create_node.jstree", function(node, newNode){
        $.ajax({
            'url' : 'privilege',
            'type': 'post',
            'data': {'pri_name': "New node", 'pri_parent_id': newNode.node.parent, '_token': token},
            'dataType': 'json',
            success: function(data) {
                if(data.code == 1 && data.pri_id) {
                    newNode.node.id = data.pri_id;
                } else {
                    sweetAlert("很遗憾", "添加失败,请刷新后重新尝试!!!", "error");
                }
            },
            error: function(data) {
                sweetAlert("很遗憾", "添加失败,请刷新后重新尝试!!!", "error");
            }
        });
    });

    $("#tree_3").on("rename_node.jstree", function(node, modifyNode){
        $.ajax({
            'url' : 'privilege/' + modifyNode.node.id,
            'type': 'put',
            'data': {'pri_name': modifyNode.text, 'pri_id': modifyNode.node.id, '_token': token},
            'dataType': 'json',
            success: function(data) {
                if(data.code == 1) {
                    sweetAlert("恭喜你", "添加成功", "success");
                } else {
                    sweetAlert("很遗憾", "添加失败", "error");
                }
                UITree.refresh();
            },
            error: function () {
                sweetAlert("很遗憾", "移动失败", "error");
                UITree.refresh();
            }
        });
    });

    $("#tree_3").on("delete_node.jstree", function(node, deleteNode){
        $.ajax({
            'url' : 'privilege/' + deleteNode.node.id,
            'type': 'delete',
            'data': {'_token': token},
            'dataType': 'json',
            success: function(data) {
                if(data.code == 1) {
                    sweetAlert("恭喜你", "删除成功", "success");
                } else {
                    sweetAlert("很遗憾", data.result, "error");
                }
            },
            error : function () {
                sweetAlert("很遗憾", data.result, "error");
            }
        });
    });

    $("#tree_3").on("move_node.jstree", function(node, moveNode) {
        $.ajax({
            'url' : 'privilege/' + moveNode.node.id,
            'type': 'put',
            'data': {'pri_parent_id': moveNode.parent, 'pri_id': moveNode.node.id, '_token': token},
            'dataType': 'json',
            success: function(data) {
                if(data.code == 1) {
                    sweetAlert("恭喜你", "移动成功", "success");
                } else {
                    sweetAlert("很遗憾", "移动失败", "error");
                }
                UITree.refresh();

            },
            error: function() {
                sweetAlert("很遗憾", "移动失败", "error");
                UITree.refresh();
            }
        });
    });


    return {
        //main function to initiate the module
        init: function () {
            contextualMenuSample();
        },
        refresh: function() {
            refresh();
        }

    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {    
       UITree.init();
    });
}