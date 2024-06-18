!(function (n) {
    "use strict";

    // Preloader Start
    $(window).on('load', function () {
        $('#preloader-status').fadeOut();
        $('#preloader')
            .delay(350)
            .fadeOut('slow');
        $('body')
            .delay(350)
    });
// Preloader End

    n(function () {

    })


    // upload img area start

    n("#imgInp").change(function (event) {
        const [file] = imgInp.files
        if (file) {
            $("#profile_image").val(URL.createObjectURL(file));
            blah.src = URL.createObjectURL(file)
        }
    });

    // create ticket upload img area start

    n("#fileInput").change(function (event) {
        const [file] = fileInput.files
        if (file) {
            $("#attachment").val(URL.createObjectURL(file));
            createImg.src = URL.createObjectURL(file)
        }
    });

    n(function () {
        const dropZone = $('#dropZone');
        const fileInput = $('#fileInput');

        dropZone.on('dragover', function (e) {
            e.preventDefault();
            dropZone.addClass('highlight');
        });

        dropZone.on('dragleave', function () {
            dropZone.removeClass('highlight');
        });

        dropZone.on('drop', function (e) {
            e.preventDefault();
            dropZone.removeClass('highlight');
            const files = e.originalEvent.dataTransfer.files;
            fileInput[0].files = files;

            // Trigger the change event manually
            fileInput.trigger('change');
        });

        fileInput.on('change', function () {
            const files = fileInput[0].files;
        });
    });


    // create ticket upload img area end

    /*---------------------------------
    summernote JS start
  -----------------------------------*/

    n('#summernote').summernote({
        placeholder: 'Type in your massage...',
        tabsize: 2,
        height: 433,
        toolbar: [
            ['height', ['height']],
            ['insert', ['link', 'picture']],
            ['fontsize', ['fontsize']],
        ]
    });


    /*---------------------------------
        summernote JS end
      -----------------------------------*/

    /*---------------------------------
    summernoteReply JS start
  -----------------------------------*/

    n('.summernoteReply').summernote({
        placeholder: 'Type in your massage...',
        tabsize: 2,
        height: 190,
        toolbar: [
            ['height', ['height']],
            ['insert', ['link', 'picture']],
            ['fontsize', ['fontsize']],
        ]


    });


    /*---------------------------------
        summernoteReply JS end
      -----------------------------------*/


    /*---------------------------------
      Top Menu / Side Menu JS
    -----------------------------------*/
    function s() {
        for (
            var e = document
                    .getElementById("topnav-menu-content")
                    .getElementsByTagName("a"),
                t = 0,
                n = e.length;
            t < n;
            t++
        )
            "nav-item dropdown active" === e[t].parentElement.getAttribute("class") &&
            (e[t].parentElement.classList.remove("active"),
                e[t].nextElementSibling.classList.remove("show"));
    };

    var a;
    n("#side-menu").metisMenu(),
        n("#vertical-menu-btn").on("click", function (e) {
            e.preventDefault(),
                n("body").toggleClass("sidebar-enable"),
                992 <= n(window).width()
                    ? n("body").toggleClass("vertical-collpsed")
                    : n("body").removeClass("vertical-collpsed");
        }),
        n("body,html").click(function (e) {
            var t = n("#vertical-menu-btn");
            t.is(e.target) ||
            0 !== t.has(e.target).length ||
            e.target.closest("div.vertical-menu") ||
            n("body").removeClass("sidebar-enable");
        }),
        n("#sidebar-menu a").each(function () {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e &&
            (n(this).addClass("active"),
                n(this).parent().addClass("mm-active"),
                n(this).parent().parent().addClass("mm-show"),
                n(this).parent().parent().prev().addClass("mm-active"),
                n(this).parent().parent().parent().addClass("mm-active"),
                n(this).parent().parent().parent().parent().addClass("mm-show"),
                n(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("mm-active"));
        }),
        n(".navbar-nav a").each(function () {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e &&
            (n(this).addClass("active"),
                n(this).parent().addClass("active"),
                n(this).parent().parent().addClass("active"),
                n(this).parent().parent().parent().addClass("active"),
                n(this).parent().parent().parent().parent().addClass("active"),
                n(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("active"));
        }),
        n(document).ready(function () {
            var e;
            0 < n("#sidebar-menu").length &&
            0 < n("#sidebar-menu .mm-active .active").length &&
            300 < (e = n("#sidebar-menu .mm-active .active").offset().top) &&
            ((e -= 1000),
                n(".vertical-menu .simplebar-content-wrapper").animate(
                    {scrollTop: e},
                    "slow"
                ));
        });
    /*---------------------------------
      Top Menu / Side Menu JS
    -----------------------------------*/

    /*---------------------------------
      Show/Hide Password/ Toggle Password JS
    -----------------------------------*/
    $(".toggle").on("click", function () {

        if ($(".password").attr("type") == "password") {
            //Change type attribute
            $(".password").attr("type", "text");
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        } else {
            //Change type attribute
            $(".password").attr("type", "password");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash");
        }
    });
    /*---------------------------------
      Show/Hide Password/ Toggle Password JS
    -----------------------------------*/


    // magnificPopup

    n('.test-popup-link').magnificPopup({
        type: 'image',
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        gallery: {
            enabled: true
        },
    });


    // Assignments box list  show

    $("#nav-home-tab").click(function () {
        $("#navHome").addClass("slow");
        $("#noneClick").addClass("noneClick");
        $(this).addClass("active");
    });

    // Assignments box list  off

    $("#noneClick").click(function () {
        $("#navHome").removeClass("slow");
        $("#noneClick").removeClass("noneClick");
        $("#nav-home-tab").removeClass("active");
    });

    // tagging box list  show

    $("#nav-profile-tab").click(function () {
        $("#navprofile").addClass("slow2");
        $("#noneClick").addClass("noneClick");
        $(this).addClass("active");
    });

    // tagging box list  off

    $("#noneClick").click(function () {
        $("#navprofile").removeClass("slow2");
        $("#noneClick").removeClass("noneClick");
        $("#nav-profile-tab").removeClass("active");
    });


    // instant reply box list  show

    $("#instantBtuto").click(function () {
        $("#instanBox").addClass("instantBox");
        $("#instantnoneClick").addClass("noneClick");
    });

    // instant reply box list  off

    $("#instantnoneClick").click(function () {
        $("#instanBox").removeClass("instantBox");
        $("#instantnoneClick").removeClass("noneClick");
    });

    // note-btu reply box list  show

    $("#noteBoxBtuto").click(function () {
        $("#noteBox").addClass("instantBox");
        $("#instantnoneClick").addClass("noneClick");
    });

    // note-btu reply box list  off

    $("#instantnoneClick").click(function () {
        $("#noteBox").removeClass("instantBox");
        $("#instantnoneClick").removeClass("noneClick");
    });


    // Get the all value of the changed checkbox


    $('#allCheck').change(function () {

        var checkedValue = $(this).val();
        if ($(this).is(":checked")) {
            $(".allSelect").prop("checked", true);
        } else {
            $(".allSelect").prop("checked", false);
        }

    });

    // datatablebox js start

    // $(".datatablebox").DataTable({
    //     language: {
    //         paginate: {
    //             next: '<i class="fa-solid fa-angle-right"></i>',
    //             previous: '<i class="fa-solid fa-angle-left"></i>',
    //         },
    //     },
    // });

    // notification categories delete but show

    $(".deleteLayout").click(function () {
        $(this).find('.show-of').toggle('.showActive');

    });

// category Select start agentViewTickets
    $('.categorySelect').select2({
        placeholder: 'Search category'
    });

    // select2 catagories create page
    $('.single-catagories').select2();


    /*------------------------
 Notification edit box list show  off start
--------------------------- */

    n(".iconNotifi").click(function () {
        n(this).find('.editPart').addClass('showeditPart');
        n("#notfioverlay").addClass("overlayClass");
    });

    n("#notfioverlay").click(function () {
        n('.editPart').removeClass('showeditPart');
        n("#notfioverlay").removeClass("overlayClass");
    });

    /*------------------------
 Notification edit box list show  off  end
--------------------------- */

/*-------------------------------
image upload area view review start
---------------------------------*/

jQuery(document).ready(function () {
    ImgUpload();
  });

  function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.ticket-img-input').each(function () {
      $(this).on('change', function (e) {
        imgWrap = $(this).closest('.ticket-upload-box').find('.ticket-upload-img-wrap');
        var maxLength = $(this).attr('data-max_length');

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        var iterator = 0;
        filesArr.forEach(function (f, index) {

          if (!f.type.match('image.*')) {
              if (imgArray.length > maxLength) {
                  return false
              } else {
                  var len = 0;
                  for (var i = 0; i < imgArray.length; i++) {
                      if (imgArray[i] !== undefined) {
                          len++;
                      }
                  }
                  if (len > maxLength) {
                      return false;
                  } else {
                      imgArray.push(f);

                      var reader = new FileReader();
                      reader.onload = function (e) {
                          var html = "<div class='ticket-upload-img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".ticket-upload-img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='ticket-upload-img-close'></div><i class='fa fa-file' style='font-size: 50px; color: #5c636a;'></i> </div></div>";
                          imgWrap.append(html);
                          iterator++;
                      }
                      reader.readAsDataURL(f);
                  }
              }
          }else{
              if (imgArray.length > maxLength) {
                  return false
              } else {
                  var len = 0;
                  for (var i = 0; i < imgArray.length; i++) {
                      if (imgArray[i] !== undefined) {
                          len++;
                      }
                  }
                  if (len > maxLength) {
                      return false;
                  } else {
                      imgArray.push(f);

                      var reader = new FileReader();
                      reader.onload = function (e) {
                          var html = "<div class='ticket-upload-img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".ticket-upload-img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='ticket-upload-img-close'></div></div></div>";
                          imgWrap.append(html);
                          iterator++;
                      }
                      reader.readAsDataURL(f);
                  }
              }
          }


        });
      });
    });

    $('body').on('click', ".ticket-upload-img-close", function (e) {
      var file = $(this).parent().data("file");
      for (var i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
          imgArray.splice(i, 1);
          break;
        }
      }
      $(this).parent().parent().remove();
    });
  }

/*-------------------------------
image upload area view review end
---------------------------------*/



})(jQuery);
