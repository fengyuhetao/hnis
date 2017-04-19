var Lock = function () {

    return {
        //main function to initiate the module
        init: function () {

             $.backstretch(pics, {
		          fade: 1000,
		          duration: 8000
		      });
        }

    };
}();

jQuery(document).ready(function() {
    Lock.init();
});