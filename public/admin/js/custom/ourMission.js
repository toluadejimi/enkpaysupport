(function ($) {
    "use strict";
    $('#ourMissionDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#news-list-route').val(),
        language: {
            paginate: {
                previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
            },
            searchPlaceholder: "Search",
            search: ""
        },
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
        columns: [
            {"data": "title", "name": "title"},
            {"data": "image", "name": "image", searchable: false, responsivePriority: 1},
            {"data": "action", searchable: false, responsivePriority: 2},
        ]
    });
    $(document).on('click', '.removeOurMission', function () {
        $(this).closest('.ourMissionChild').remove();
    });
    window.addOurMissionPoint = addOurMissionPoint;
    function addOurMissionPoint(el) {
        "use strict";
        let html = $('#ourMissionHtml').html();
        $(el).closest('form').find('.ourMissionParent').append(addShowFromOurMission());
    }
    window.addShowFromOurMission = addShowFromOurMission;
    function addShowFromOurMission() {
        return `<div id="ourMissionHtml">
                <div class="col-12 d-flex mb-10 ourMissionChild">
                    <textarea class="form-control me-2" name="description_point[]" rows="2"></textarea>
                        <button type="button" class="removeOurMission text-danger">
                            <i class="iconify" data-icon="gala:remove"></i>
                        </button>
                </div>
            </div>`;
    }

})(jQuery);

