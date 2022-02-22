"use strict";
// Class Definition
let customDataTableWidget = {
    element: jsConstant.NULL,
    listingUrl: jsConstant.NULL,
    deleteUrl: jsConstant.NULL,
    searching: jsConstant.STATUS_FALSE,
    serverSide: jsConstant.STATUS_TRUE,
    processing: jsConstant.STATUS_TRUE,
    columns: [],
    dataTable: jsConstant.NULL,
    search: [],
    checkedRecords: [],
    searchStatus: jsConstant.STATUS_FALSE,
    defaultSortingIndex: jsConstant.STATUS_ZERO,
    defaultSortingOrder: 'desc',
    length: 10,
    paginate: jsConstant.STATUS_TRUE,
    info: jsConstant.STATUS_TRUE,
    skeleton: function () {
        customDataTableWidget.dataTable = $(customDataTableWidget.element).DataTable({
            // "dom": '<"top"i>rt<"bottom"flp>',
            sDom: 'Rfrtlip',
            scrollX: !jsConstant.STATUS_ZERO,
            processing: customDataTableWidget.processing,
            serverSide: customDataTableWidget.serverSide,
            searching: customDataTableWidget.searching,
            fixedHeader: jsConstant.STATUS_TRUE,
            bPaginate: customDataTableWidget.paginate,
            bInfo: customDataTableWidget.info,
            pageLength: customDataTableWidget.length,
            ajax: {
                url: customDataTableWidget.listingUrl,
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: function (d) {
                    if (customDataTableWidget.searchStatus) {
                        $(customDataTableWidget.search).each(function (index, value) {
                            if (value.type == 'select') {
                                d[value.key] = $("select[name='" + value.key + "']").val();
                            } else {
                                d[value.key] = $("input[name='" + value.key + "']").val();
                            }
                        });
                    }
                    return d;
                }
            },
            order: [[customDataTableWidget.defaultSortingIndex, customDataTableWidget.defaultSortingOrder]],
            columns: customDataTableWidget.columns
        });
    },
    checkboxActionEvents: function () {
        //checked all
        $(document).on('click', '#checkbox-all', function () {
            if (this.checked) {
                $(".check-record").each(function () {
                    this.checked = jsConstant.STATUS_TRUE;
                    customDataTableWidget.checkedRecords.push($(this).val());
                    $("#recordRow-" + $(this).val()).attr('checked', jsConstant.STATUS_TRUE);
                    $("#recordRow-" + $(this).val()).css('background', '#E4E6EF');
                });
            } else {
                $(".check-record").each(function () {
                    customDataTableWidget.checkedRecords.splice(jsConstant.STATUS_ZERO, customDataTableWidget.checkedRecords.length)
                    $("#recordRow-" + $(this).val()).attr('checked', jsConstant.STATUS_FALSE);
                    $("#recordRow-" + $(this).val()).css('background', '#FFFFFF');
                    this.checked = jsConstant.STATUS_FALSE;
                });
            }
            customDataTableWidget.hideAndShowActionDropdown(customDataTableWidget.checkedRecords);
        });

        //checked single record based on click
        $(document).on('click', '.check-record', function () {
            let recordId = $(this).val();
            if ($(this).is(":checked")) {
                customDataTableWidget.checkedRecords.push(recordId);
                $("#record-" + recordId).attr('checked', jsConstant.STATUS_TRUE);
                $("#recordRow-" + recordId).css('background', '#E4E6EF');
            } else if ($(this).is(":not(:checked)")) {
                customDataTableWidget.checkedRecords = without(customDataTableWidget.checkedRecords, recordId);
                $("#record-" + recordId).attr('checked', jsConstant.STATUS_FALSE);
                $("#recordRow-" + recordId).css('background', '#FFFFFF');
            }

            customDataTableWidget.hideAndShowActionDropdown(customDataTableWidget.checkedRecords);
        });

        //checked record as it's whenever update the pagination of grid
        customDataTableWidget.dataTable.on('draw.dt', function () {
            $.each(customDataTableWidget.checkedRecords, function (index, value) {
                $(document).find("#record-" + value).attr('checked', jsConstant.STATUS_TRUE);
                $("#recordRow-" + value).css('background', '#E4E6EF');
            });
        });

        $(document).on('click', '.action-type', function () {
            let actionType = $(this).data('value');

            Swal.fire({
                title: "Are you sure?",
                text: actionType == 'delete' ? "You won't be able to revert this!" : "",
                icon: "warning",
                showCancelButton: jsConstant.STATUS_TRUE,
                confirmButtonText: "Yes, " + actionType + " it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: jsConstant.STATUS_TRUE
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: customDataTableWidget.multipleActionUrl,
                        data: {'checked_records': customDataTableWidget.checkedRecords, 'action_type': actionType},
                        success: function (res) {
                            if (res.success) {
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                            customDataTableWidget.reset();
                            customDataTableWidget.dataTable.draw();
                        },
                        error: function (error) {
                            toastr.error(error);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.excel-export', function () {

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: customDataTableWidget.excelExportUrl,
                data: {'checked_records': customDataTableWidget.checkedRecords},
                success: function (res) {
                    if (res) {
                        var a = document.createElement("a");
                        a.download = res.name;
                        a.href = res.file;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    } else {
                        toastr.error(res.message);
                    }
                    customDataTableWidget.reset();
                    customDataTableWidget.dataTable.draw();
                },
                error: function (error) {
                    toastr.error(error);
                }
            });
        });
    },
    commonEvents: function () {
        $("#kt_reset").on("click", function (e) {
            e.preventDefault(),
                $(".datatable-input").each(function () {
                    $(this).val("").selectpicker('refresh');
                })
            customDataTableWidget.searchStatus = jsConstant.STATUS_FALSE;
            customDataTableWidget.dataTable.draw();
        });
        // change events
        $(document).on('change', ".change-action", function () {
            customDataTableWidget.searchStatus = jsConstant.STATUS_TRUE;
            customDataTableWidget.dataTable.draw();
        });
        // keyup events
        $(document).on('keyup', ".change-action", function () {
            customDataTableWidget.searchStatus = jsConstant.STATUS_TRUE;
            customDataTableWidget.dataTable.draw();
        });
        // click events for date range searching
        $(document).on('click', ".applyBtn", function () {
            customDataTableWidget.searchStatus = jsConstant.STATUS_TRUE;
            customDataTableWidget.dataTable.draw();
        });
        //delete action
        $(document).on('click', '.delete-confirmation', function (e) {
            let userId = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this!",
                icon: "warning",
                showCancelButton: jsConstant.STATUS_TRUE,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: jsConstant.STATUS_FALSE
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "DELETE",
                        url: customDataTableWidget.deleteUrl.replace(':id', userId),
                        success: function (res) {
                            if (res.success) {
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                            customDataTableWidget.dataTable.draw();
                        },
                        error: function (error) {
                            toastr.error(error);
                        }
                    });
                }
            });
        });
    },
    reset: function () {
        $(document).find('#checkboxActionDropdown').removeClass("active");
        $(document).find('#checkbox-all').prop('checked', jsConstant.STATUS_FALSE);
        customDataTableWidget.checkedRecords = [];
    },
    hideAndShowActionDropdown: function (checkboxArray) {
        if (checkboxArray.length > jsConstant.STATUS_ZERO) {
            $(document).find('#checkboxActionDropdown').addClass("active");
            $(document).find('#datatableSelectedRecords').html(checkboxArray.length);
        } else {
            $(document).find('#checkboxActionDropdown').removeClass("active");
        }
    },
    init: function () {
        this.skeleton();
        this.checkboxActionEvents();
        this.commonEvents();
    },
    configuration: function (data) {
        if (data) {
            this.element = data.element || jsConstant.NULL;
            this.listingUrl = data.listingUrl || jsConstant.NULL;
            this.deleteUrl = data.deleteUrl || jsConstant.NULL;
            this.checkboxAction = data.checkboxAction || jsConstant.STATUS_FALSE;
            this.multipleActionUrl = data.multipleActionUrl || jsConstant.NULL;
            this.excelExportUrl = data.excelExportUrl || jsConstant.NULL;
            this.columns = data.columns || [];
            this.searching = data.searching || jsConstant.STATUS_FALSE;
            this.serverSide = data.serverSide || jsConstant.STATUS_TRUE;
            this.processing = data.processing || jsConstant.STATUS_TRUE;
            this.search = data.search || [];
            this.defaultSortingIndex = data.defaultSortingIndex || jsConstant.STATUS_ZERO;
            this.defaultSortingOrder = data.defaultSortingOrder || 'DESC';
            this.length = data.length || 10;
        }
        customDataTableWidget.init();
    }
}
