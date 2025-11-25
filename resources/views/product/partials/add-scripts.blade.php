<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-tagsinput.js') }}" type="text/javascript"></script>

<script>
    // Unit Form Reset Handler
    $('#unit_form').on('reset', function () {
        $('#unit_id').val(0);
        $('#product_color').val('');
        $('#dropdown-selected span').text('Select');
        $('#unitreset').addClass('d-none');
    });

    // DOM Ready - Validation Functions
    $(document).ready(function () {
        // Function to validate a single input-unit pair
        function validateUnit(inputId, unitId, errorId) {
            const inputVal = $(`#${inputId}`).val().trim();
            const unitVal = $(`#${unitId}`).val();
            const errorField = $(`#${errorId}`);

            if (inputVal && !unitVal) {
                $(`#${unitId}`).addClass('is-invalid');
                errorField.show();
                return false;
            } else {
                $(`#${unitId}`).removeClass('is-invalid');
                errorField.hide();
                return true;
            }
        }

        // Real-time validation on input change
        $('#height, #width, #weight').on('input', function () {
            const inputId = this.id;
            const unitId = `${inputId}_unit`;
            const errorId = `${inputId}-unit-error`;
            validateUnit(inputId, unitId, errorId);
        });

        // Real-time validation on unit change
        $('#height_unit, #width_unit, #weight_unit').on('change', function () {
            const unitId = this.id;
            const inputId = unitId.replace('_unit', '');
            const errorId = `${inputId}-unit-error`;
            validateUnit(inputId, unitId, errorId);
        });

        // Basic Form Submission Validation
        $('#basic_form').submit(function (e) {
            var form1 = $(this);
            var isValid = true;

            // Reset previous validation states
            form1.find('.is-invalid').removeClass('is-invalid');
            form1.find('.invalid-feedback').hide();

            // Validate height
            if (!validateUnit('height', 'height_unit', 'height-unit-error')) {
                isValid = false;
            }

            // Validate width
            if (!validateUnit('width', 'width_unit', 'width-unit-error')) {
                isValid = false;
            }

            // Validate weight
            if (!validateUnit('weight', 'weight_unit', 'weight-unit-error')) {
                isValid = false;
            }

            // Standard form validation for required fields
            form1.find(':input').each(function () {
                if (!$(this)[0].checkValidity()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            // Proceed with AJAX submission
            e.preventDefault();
            var data = $(this).serialize() + "&pid=" + $("#project_id").val() + "&subcategory_id=" + $("#category_id").val();

            $.ajax({
                url: '{{ route("storebasicdetails") }}',
                type: "POST",
                data: data,
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $("#project_id").val(res["product_id"]);
                    $('[data-bs-target="#navs-justified-messages"]').prop('disabled', false).click();
                    $('.price_detail_alert.bg-label-success').removeClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 2000);
                }
            }).fail(function () {
                // Handle failure
            });
        });
    });

    // Custom Dropdown for Colors
    document.addEventListener('DOMContentLoaded', () => {
        const customDropdown = document.getElementById('custom-dropdown');
        const selected = document.getElementById('dropdown-selected');
        const optionsContainer = document.getElementById('dropdown-options');
        const selectElement = document.getElementById('product_color');

        // Example dynamic data
        const data = [
            @foreach($UnitColor as $_color)
                { value: '{{$_color->m_color_id}}', text: '{{$_color->color_name}}', color: '{{$_color->color_code}}' },
            @endforeach
        ];

        // Function to toggle the dropdown visibility
        selected.addEventListener('click', (event) => {
            optionsContainer.classList.toggle('visible');
            event.stopPropagation(); // Prevent the click event from bubbling up
        });

        // Function to hide the dropdown when clicking outside
        document.addEventListener('click', () => {
            optionsContainer.classList.remove('visible');
        });

        // Function to hide the dropdown on scroll
        window.addEventListener('scroll', () => {
            optionsContainer.classList.remove('visible');
        });

        // Function to add options to the dropdown and the hidden select element
        data.forEach(item => {
            const option = document.createElement('div');
            option.classList.add('dropdown-option');
            option.dataset.value = item.value;

            const colorBox = document.createElement('div');
            colorBox.classList.add('color-show');
            colorBox.style.background = item.color;

            const optionText = document.createElement('span');
            optionText.textContent = item.text;

            option.appendChild(colorBox);
            option.appendChild(optionText);

            option.addEventListener('click', () => {
                selected.innerHTML = `<span>${colorBox.outerHTML} ${item.text}</span><div>&#9662;</div>`;
                selectElement.value = item.value; // Update the hidden select element's value
                optionsContainer.style.display = 'none';
            });

            optionsContainer.appendChild(option);

            // Add the corresponding option to the hidden select element
            const selectOption = document.createElement('option');
            selectOption.value = item.value;
            selectOption.textContent = item.text;
            selectElement.appendChild(selectOption);
        });
    });

    // Initialize Tagsinput and Meta Data
    var productKeyPoint = {!! json_encode($productkeypoint) !!};
    var keys = productKeyPoint.map(function (item) {
        return item.key;
    });
    $('#keypoint').val(keys);

    // Meta title
    var metatitle = {!! json_encode($metatitle) !!};
    var metatitle = metatitle.map(function (item) {
        return item.title;
    });
    $('#metatitle').val(metatitle);

    // Meta Description
    var metadescription = {!! json_encode($metadescription) !!};
    var metadescription = metadescription.map(function (item) {
        return item.description;
    });
    $('#metadescription').val(metadescription);

    // Tagsinput Initialization
    let ta;
    var pid = 0;
    $('#keypoint').tagsinput({
        trimValue: true,
        confirmKeys: [13, 44],
        focusClass: 'my-focus-class'
    });

    // Basic Form Submit Handler
    $('#basic_form').submit(function (e) {
        var form1 = $(this);
        form1.find(':input').each(function () {
            if (!$(this)[0].checkValidity()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!form1[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            let self = $(this);
            e.preventDefault(); // prevent default submit behavior
            self.prop('disabled', true);
            var data = $(this).serialize() + "&pid=" + $("#project_id").val() + "&subcategory_id=" + $("#category_id").val(); // get form data

            $.ajax({
                url: '{{ route("storebasicdetails") }}',
                type: "POST",
                data: data,
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $("#project_id").val(res["product_id"]);
                    $('[data-bs-target="#navs-justified-messages"]').prop('disabled', false).click();
                    $('.price_detail_alert.bg-label-success').removeClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 2000);
                }
            }).fail(function () {});
        }
    });

    // Price Form Submit Handler
    $('#price_form').submit(function (e) {
        var form1 = $(this);
        form1.find(':input').each(function () {
            if (!$(this)[0].checkValidity()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!form1[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            let self = $(this);
            e.preventDefault();
            self.prop('disabled', true);
            var data = $(this).serialize() + "&pid=" + $("#project_id").val();

            $.ajax({
                url: '{{ route("pricebasicdetails") }}',
                type: "POST",
                data: data,
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    $('[data-bs-target="#navs-justified-messages"]').prop('disabled', false).click();
                    $('.price_detail_alert.bg-label-success').removeClass("d-none");
                    $('.val-message').removeClass('d-none');
                    setTimeout(function () {
                        $('.val-message').addClass('d-none');
                    }, 2000);
                    unitList();
                }
            }).fail(function () {});
        }
    });

    // Unit Form Submit Handler
    $('#unit_form').submit(function (e) {
        console.log(ta);
        var form1 = $(this);
        form1.find(':input').each(function () {
            if (!$(this)[0].checkValidity()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!form1[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            let self = $(this);
            e.preventDefault();
            self.prop('disabled', true);
            var data = $(this).serialize() + "&pid=" + $("#project_id").val() + "&uid=" + $("#unit_id").val();
            console.log(data);
            $.ajax({
                url: '{{ route("storeUnitdetails") }}',
                type: "POST",
                data: data,
                dataType: 'json',
            }).done(function (res) {
                if (res["error_code"] == 200) {
                    sno = 0;
                    unitList();
                    try {
                        ta.ajax.reload();
                    } catch (r) { }
                    $('[data-bs-target="#navs-justified-image"]').prop('disabled', false);
                    $('.unit_detail_alert.bg-label-success').removeClass("d-none");
                    $('.unit_detail_alert.bg-label-danger').addClass("d-none");
                }
            }).fail(function () {});
        }
    });

    // Document Ready - Unit List Initialization
    $(document).ready(function () {
        pid = $("#project_id").val();
        unitList();
    });

    // Unit List Function
    function unitList() {
        sno = 0;
        ta = $("#unitlist_table").DataTable({
            ajax: {
                url: '{{ route("getUnitList") }}',
                method: 'POST',
                data: {
                    'pid': $("#project_id").val(),
                    _token: '{{ csrf_token() }}'
                },
            },
            columns: [
                {
                    className: "text-center",
                    'render': function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: "size_name" },
                {
                    className: "text-center",
                    'render': function (data, type, row) {
                        return `<span class="color-show-price">₹ ${row['unit_price']}</span>`;
                    }
                },
                {
                    className: "text-center",
                    'render': function (data, type, row) {
                        return `<span class="color-show-mrp-price"> ${row['mrp_price'] ? '₹ ' + row['mrp_price'] : ''}</span>`;
                    }
                },
                { data: "material_name" },
                { data: "design_name" },
                {
                    className: "text-center",
                    'render': function (data, type, row) {
                        return `<span class="color-show" style="background:${row['color_code']}"></span>${row['color_name']}`;
                    }
                },
                {
                    className: "text-end w-20",
                    'render': function (data, type, row) {
                        return ` 
                            <button type="button" class="copy_data btn btn-icon btn-outline-warning" onclick="copyData(${row['m_size_id']},${row['unit_price']},${row['mrp_price']},${row['m_material_id']},${row['m_design_id']},${row['m_color_id']})" > <i class='bx bx-copy-alt'></i> </button>
                            <button type="button" data-qty="${row['stock']}" data-mrp-price="${row['mrp_price']}" data-price="${row['unit_price']}" data-material="${row['m_material_id']}" data-design="${row['m_design_id']}"  data-color="${row['m_color_id']}"  data-size="${row['m_size_id']}" data-id="${row['product_unit_id']}" data-colorname="${row['color_name']}" class=" update_data btn mx-2  btn-icon btn-outline-primary">
                            <span class="tf-icons bx bx-pencil"></span>
                          </button><button type="button"   data-id="${row['product_unit_id']}" class="btn delete unitdelete btn-icon btn-outline-danger">
                            <span class="tf-icons bx bxs-trash"></span>
                          </button>`;
                    }
                },
            ],
            language: {
                sLengthMenu: "_MENU_",
                search: "",
                searchPlaceholder: "Search Matrial"
            },
            "lengthChange": false,
            "pageLength": 10,
            "searching": false,
            destroy: true
        });
    }

    // Image Upload Handler
    $(document).on("change", ".product_upload", function () {
        var file = this.files[0];
        if (!file) {
            return;
        }
        var content = $(this).data('content');
        var process_bar = $(`.${content} .progress-bar`);
        process_bar.html('0%').css('width', '0%');

        var formData = new FormData();
        formData.append('product_images', file);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('imageunit', $(this).data('imageunit'));
        formData.append('imagecount', $(this).data('imagecount'));
        formData.append('pid', $("#project_id").val());

        $.ajax({
            url: '{{ route("uploadImages") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        process_bar.html(percentComplete.toFixed(2) + '%').width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function (data) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $(`.${content} img`).attr('src', e.target.result).removeClass('d-none').css('background', '#e1eff5');
                }
                reader.readAsDataURL(file);
                process_bar.html('0%').css('width', '0%');
                $(`.${content} .image-delete`).removeClass('d-none');
                $('[data-bs-target="#navs-justified-keypoint"]').prop('disabled', false);
                $('[data-bs-target="#navs-justified-meta-title"]').prop('disabled', false);
                $('[data-bs-target="#navs-justified-meta-description"]').prop('disabled', false);
                $('.image_detail_alert.bg-label-success').removeClass("d-none");
                $('.image_detail_alert.bg-label-danger').addClass("d-none");
                $('.val-message').removeClass('d-none');
                setTimeout(function () {
                    $('.val-message').addClass('d-none');
                }, 2000);
            }
        });
    });

    // Image Tab Click Handler
    var product_url = '{{asset('uploads/products')}}';
    $(document).on("click", '[data-bs-target="#navs-justified-image"]', function () {
        $.ajax({
            url: '{{ route("getProductImage") }}',
            type: "POST",
            data: {
                'pid': $("#project_id").val(),
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
        }).done(function (res) {
            if (res["error_code"] == 200) {
                $("#image-view-content").html('');
                $.each(res["images"], function (index, image) {
                    var _res = `
                          <a class=" flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <h6>${image.color_name} <span class="color-show" style="background:${image.color_code}"></span></h6>
                                </div>
                                <div class="row" >`;
                    for (var i = 1; i < 6; i++) {
                        _res += `   <div class="col-md-2 mx-2" >
                                            <div  class="image-content img-con-${i}-${image.m_color_id}" >
                                                <span class="${(image['web_image_' + i] != null) ? '' : 'd-none'} image-delete" data-imageunit="${image.product_image_id}" data-imagecount="${i}"  data-content="img-con-${i}-${image.m_color_id}"><i class='bx bxs-trash'></i></span>
                                                <input accept=".png, .jpg, .jpeg" data-imageunit="${image.product_image_id}" data-imagecount="${i}"  class="product_upload" type="file" data-content="img-con-${i}-${image.m_color_id}" id="product_upload_${image.m_color_id}_${i}" style="display: none" >
                                                <img class="${(image['web_image_' + i] != null) ? '' : 'd-none'}" style="${(image['web_image_' + i] != null) ? 'background:#e1eff5' : ''}" src="${(image['web_image_' + i] != null) ? (product_url + '/' + image['web_image_' + i]) : ''}">
                                                <label for="product_upload_${image.m_color_id}_${i}"><i class='bx bx-plus'></i> Add Image </label>
                                                <div class="progress w-100 ">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        0%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                    }
                    _res += ` <div class="mt-3 mb-2 d-none">
                                    <label>Video Link</label>
                                    <input class="form-control video-url" data-pro-image-id="${image.product_image_id}"  type="text" name="web_video" value="${image.web_video ? image.web_video : ''}">
                                    </div>
                                    <form id="upload-video" enctype="multipart/form-data">
                                    <div class="mt-3 mb-3">
                                    <label>Upload Video</label>
                                    <input class="form-control video-file" id="video-file" data-pro-image-id="${image.product_image_id}"  type="file" name="web_video" value="${image.web_video ? image.web_video : ''}">
                                    </div>
                                    <div style="position:relative;width: fit-content;" class="${image.web_video ? '' : 'd-none'}">
                                    <div class="sm-del-btn" id="delete-video" data-imageunit="${image.product_image_id}" >
                                    <i class='bx bxs-trash'></i>
                                    </div>
                                    <video width="320" height="240" autoplay controls>
                                          <source src="{{asset('uploads/products/videos') . '/'}}${image.web_video ? image.web_video : ''}" type="video/mp4">
                                    </video>
                                    </div>
                                    </form>
                               </div></a>`;
                    $("#image-view-content").append(_res);
                });
            } else {
                $("#image-view-content").html('<h3>No Unit List</h3>')
            }
        }).fail(function () {});
    });

    // Image Delete Handler
    $(document).on("click", ".image-delete", function () {
        var content = $(this).data('content');
        $.ajax({
            url: '{{ route("deleteProductImages") }}',
            type: "POST",
            data: {
                'pid': $("#project_id").val(),
                _token: '{{ csrf_token() }}',
                imageunit: $(this).data('imageunit'),
                imagecount: $(this).data('imagecount')
            },
            dataType: 'json',
        }).done(function (res) {
            if (res["error_code"] == 200) {
                var process_bar = $(`.${content} .progress-bar`);
                process_bar.html('0%').css('width', '0%');
                $(`.${content} img`).addClass('d-none');
                $(`.${content} .image-delete`).addClass('d-none');
            }
        }).fail(function () {});
    });

    // Keypoint Change Handler
    $(document).on("change", "#keypoint", function () {
        $.ajax({
            url: '{{ route("saveWordProduct") }}',
            type: "POST",
            data: {
                'pid': $("#project_id").val(),
                _token: '{{ csrf_token() }}',
                keypoint: $("#keypoint").val(),
            },
            dataType: 'json',
        }).done(function (res) {
            if (res["error_code"] == 200) {
                $('.key_detail_alert.bg-label-success').removeClass("d-none");
                $('.key_detail_alert.bg-label-danger').addClass("d-none");
                $('.val-message').removeClass('d-none');
                setTimeout(function () {
                    $('.val-message').addClass('d-none');
                }, 3000);
            }
        }).fail(function () {});
    });

    // Meta Title Input Handler
    $(document).on("input", "#metatitle", function () {
        $.ajax({
            url: '{{ route("savemetatitle") }}',
            type: "POST",
            data: {
                'pid': $("#project_id").val(),
                _token: '{{ csrf_token() }}',
                input: $("#metatitle").val(),
            },
            dataType: 'json',
        }).done(function (res) {
            if (res["error_code"] == 200) {
                $('.meta_title').removeClass("d-none");
                $('.val-message').removeClass('d-none');
                setTimeout(function () {
                    $('.val-message').addClass('d-none');
                }, 2000);
            }
        }).fail(function () {});
    });

    // Meta Description Input Handler
    $(document).on("input", "#metadescription", function () {
        $.ajax({
            url: '{{ route("savemetadescription") }}',
            type: "POST",
            data: {
                'pid': $("#project_id").val(),
                _token: '{{ csrf_token() }}',
                input: $("#metadescription").val(),
            },
            dataType: 'json',
        }).done(function (res) {
            if (res["error_code"] == 200) {
                $('.meta_desc').removeClass("d-none");
                $('.val-message').removeClass('d-none');
                setTimeout(function () {
                    $('.val-message').addClass('d-none');
                }, 3000);
            }
        }).fail(function () {});
    });

    // Unit Delete Handler
    $(document).on('click', '.unitdelete', function () {
        sno = 0;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("deleteUnitList") }}',
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        uid: $(this).data('id'),
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response['error_code'] == 200)
                            ta.ajax.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting item:', error);
                    }
                });
            }
        });
    });

    // Update Data Handler
    $(document).on('click', '.update_data', function () {
        var colorValue = $(this).data('color');
        var selectElement = document.getElementById('product_color');
        selectElement.value = colorValue;
        var event = new Event('change');
        selectElement.dispatchEvent(event);

        $('#dropdown-selected span').text($(this).data('colorname'));
        $('#product_color').val(colorValue).trigger("change");

        $('#product_material').val($(this).data('material')).trigger("change");
        $('#product_design').val($(this).data('design')).trigger("change");
        $('#product_size').val($(this).data('size')).trigger("change");
        $('#unit_id').val($(this).data('id'));
        console.log($(this).data('qty'), $(this).data());
        $('#product_stock').val($(this).data('qty'));
        $('#unitreset').removeClass('d-none');
        $('#unit_price').val($(this).data('price'));
        $('#mrp_price').val($(this).data('mrp-price'));
    });

    // Copy Data Function
    function copyData(size = '', unit_price = '', mrp = '', type = '', design = '', color = '') {
        $('#product_size').val(size);
        $('#unit_price').val(unit_price);
        $('#mrp_price').val(mrp);
        $('#product_material').val(type);
        $('#product_design').val(design);

        $('#product_color').val(color).trigger("change");
        const selectedText = $('#product_color option[value="' + color + '"]').text() || 'Select';
        $('#dropdown-selected span').text(selectedText);
    }

    // Video File Change Handler
    $(document).on('change', '.video-file', function () {
        var formData = new FormData();
        var file = $('.video-file').prop('files')[0];
        formData.append('web_video', file);
        formData.append('image_id', $(this).data('pro-image-id'));
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("uploadvideo") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response['error_code'] == 200)
                    $('[data-bs-target="#navs-justified-image"]').click();
                $('.val-message').removeClass('d-none');
                setTimeout(function () {
                    $('.val-message').addClass('d-none');
                }, 2000);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Delete Video Handler
    $(document).on("click", "#delete-video", function () {
        var unit_id = $(this).data('imageunit');
        $.ajax({
            url: '{{ route("deletevideo") }}',
            type: "POST",
            data: {
                'pid': $("#project_id").val(),
                _token: '{{ csrf_token() }}',
                imageunit: unit_id,
            },
            dataType: 'json',
        }).done(function (res) {
            if (res["error_code"] == 200) {
                $('[data-bs-target="#navs-justified-image"]').click();
            }
        }).fail(function () {});
    });

    // Video URL Change Handler
    $(document).on('change', '.video-url', function () {
        console.log('img id : ' + $(this).data('pro-image-id'));

        $.ajax({
            url: '{{ route("uploadImages") }}',
            method: 'POST',
            data: {
                image_id: $(this).data('pro-image-id'),
                video_url: $(this).val(),
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response['error_code'] == 200)
                    ta.ajax.reload();
                $('.val-message').removeClass('d-none');
                setTimeout(function () {
                    $('.val-message').addClass('d-none');
                }, 2000);
            },
            error: function (error) {
                console.error('Error deleting item:', error);
            }
        });
    });

    // Customize Toggle Handler
    document.addEventListener('DOMContentLoaded', function () {
        const customizeYes = document.getElementById('customize_yes');
        const customizeNo = document.getElementById('customize_no');
        const custDescriptionField = document.getElementById('cust_description_field');
        const customizeOptionsField = document.getElementById('customize_options_field');

        // Function to toggle visibility
        function toggleCustomFields() {
            if (customizeYes.checked) {
                customizeOptionsField.style.display = 'block';
                custDescriptionField.style.display = 'block';
            } else {
                customizeOptionsField.style.display = 'none';
                custDescriptionField.style.display = 'none';
            }
        }

        // Add event listeners
        customizeYes.addEventListener('change', toggleCustomFields);
        customizeNo.addEventListener('change', toggleCustomFields);

        // Initialize on page load
        toggleCustomFields();
    });
</script>