

(function ($) {
    "use strict";

function previewFile(input) {
    "use strict";
    var preview = input.previousElementSibling;
    var file = input.files[0];
    var reader = new FileReader();

    if(input.files[0].size > 1000000){
        alert("Maximum file size is 1MB!");
    } else {
        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
}
window.previewFile = previewFile;

function previewFile2(input) {
    "use strict";
    var preview = input.closest('.image-wrap').querySelector('img');
    var file = input.files[0];
    var reader = new FileReader();

    if(input.files[0].size > 1000000){
        alert("Maximum file size is 1MB!");
    } else {
        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
}
window.previewFile2 = previewFile2;

function preview815639DimensionsFile(input) {
    "use strict";

    var preview = input.previousElementSibling;
    var file = input.files[0];
    var reader = new FileReader();

    if (file.type !== 'image/png')
    {
        alert("Accepted file is png.");
        return
    }

    var img = new Image();
    img.src = window.URL.createObjectURL( file );
    img.onload = function()
    {
        var width = this.naturalWidth,
            height = this.naturalHeight;

        if (width !== 815){
            preview.src = "";
            input.value = ""
            alert("Need to width is 815!");
            return;
        }

        if (height !== 639){
            preview.src = "";
            input.value = ""
            alert("Need to height is 639!");
            return;
        }

    };

    if(input.files[0].size > 1000000){
        alert("Maximum file size is 1MB!");
    }else {
        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
}
window.preview815639DimensionsFile = preview815639DimensionsFile;

function preview35DimensionsFile(input) {
    "use strict";

    var preview = input.previousElementSibling;
    var file = input.files[0];
    var reader = new FileReader();

    if (file.type !== 'image/png')
    {
        alert("Accepted file is png.");
        return
    }

    var img = new Image();
    img.src = window.URL.createObjectURL( file );
    img.onload = function()
    {
        var width = this.naturalWidth,
            height = this.naturalHeight;

        if (width !== 35){
            preview.src = "";
            input.value = ""
            alert("Need to width is 35!");
            return;
        }

        if (height !== 35){
            preview.src = "";
            input.value = ""
            alert("Need to height is 35!");
            return;
        }

    };

    if(input.files[0].size > 1000000){
        alert("Maximum file size is 1MB!");
    }else {
        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
}
window.preview35DimensionsFile = preview35DimensionsFile;

function preview44DimensionsFile(input) {
    "use strict";

    var preview = input.previousElementSibling;
    var file = input.files[0];
    var reader = new FileReader();

    if (file.type !== 'image/png')
    {
        alert("Accepted file is png.");
        return
    }

    var img = new Image();
    img.src = window.URL.createObjectURL( file );
    img.onload = function()
    {
        var width = this.naturalWidth,
            height = this.naturalHeight;

        if (width !== 44){
            preview.src = "";
            input.value = ""
            alert("Need to width is 44!");
            return;
        }

        if (height !== 44){
            preview.src = "";
            input.value = ""
            alert("Need to height is 44!");
            return;
        }



    };

    if(input.files[0].size > 1000000){
        alert("Maximum file size is 1MB!");
    }else {
        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
}
window.preview44DimensionsFile = preview44DimensionsFile;

function preview312369DimensionFile(input) {
    "use strict";

    var preview = input.previousElementSibling;
    var file = input.files[0];
    var reader = new FileReader();

    if (file.type === 'image/png' || file.type === 'image/jpg' || file.type === 'image/jpeg')
    {
        var img = new Image();

        img.src = window.URL.createObjectURL( file );
        img.onload = function()
        {
            var width = this.naturalWidth,
                height = this.naturalHeight;

            if (width !== 312){
                preview.src = "";
                alert("Need to width is 312!");
                return
            }

            if (height !== 369){
                preview.src = "";
                alert("Need to height is 369!");
                return;
            }

        };

        if(input.files[0].size > 1000000){
            alert("Maximum file size is 1MB!");
        }else {
            reader.onloadend = function() {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    } else {
        alert("Accepted file is jpg/jpeg/png.");
        return
    }


}
window.preview312369DimensionFile = preview312369DimensionFile;

function preview125DimensionFile(input) {
    "use strict";

    var preview = input.previousElementSibling;
    var file = input.files[0];
    var reader = new FileReader();

    if (file.type === 'image/png' || file.type === 'image/jpg' || file.type === 'image/jpeg')
    {
        var img = new Image();

        img.src = window.URL.createObjectURL( file );
        img.onload = function()
        {
            var width = this.naturalWidth,
                height = this.naturalHeight;

            if (width !== 125){
                preview.src = "";
                input.value = ""
                alert("Need to width is 125!");
                return;
            }

            if (height !== 125){
                preview.src = "";
                input.value = ""
                alert("Need to height is 125!");
                return;
            }

        };

        if(input.files[0].size > 1000000){
            alert("Maximum file size is 1MB!");
        }else {
            reader.onloadend = function() {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    } else {
        alert("Accepted file is jpg/jpeg/png.");
        return
    }
}
window.preview125DimensionFile = preview125DimensionFile;
})(jQuery)

