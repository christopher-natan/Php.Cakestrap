var SideMenu = {
    Event: {
        OnClickMenu: function () {
            $(document).on('click', '.side-menu .panel-heading a', function () {
                var $current = $(this);
                var $sideMenu = $("#sideMenu");
                var isDown = $current.find('i.fa-chevron-down');
                $sideMenu.find("a").find("i.fa-chevron-down").removeClass('fa-chevron-down').addClass('fa-chevron-right');

                if (isDown.length <= 0) {
                    $current.find('i.chevron').removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    $sideMenu.find(".panel-heading").removeClass("active");
                    $current.parent(".panel-heading").addClass("active");
                } else {
                    $current.find('i.chevron').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                }
            });
        }
    }
};

$(document).ready(function () {
    SideMenu.Event.OnClickMenu();
});