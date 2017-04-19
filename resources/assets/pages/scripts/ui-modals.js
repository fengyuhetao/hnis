var UIModals = function () {

    var handleModals = function () {
        $('#long').on('hidden.bs.modal', function () {
            // 刷新整个页面
            location.href = location.href;
        })
    }

    return {
        //main function to initiate the module
        init: function () {
            handleModals();
        }

    };

}();

jQuery(document).ready(function() {    
   UIModals.init();
});