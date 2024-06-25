

function ShowFieldValidError(formId, fieldsErrItems) {
    _arr = fieldsErrItems;
    var msg = '';
    $.each(fieldsErrItems, function (seq, obj) {
        msg += obj + "\n";
    });
    $('[name=' + Object.keys(fieldsErrItems)[0] + ']').focus().blur();

    var validator = $('#' + formId).validate();
    validator.showErrors(fieldsErrItems);
    swal("錯誤", msg, 'warning');
}

function ShowDataTablePageInfo(DataTablesId, DataTablesLibFolderPath, filterFrmEleId, tbEleId, getRowCountUrl, tbOrderBy, tbAjaxUrl, tbColumns, tbDelRowUrl, CallbackFunc) {
    
    $.extend( DataTable.ext.classes, {
        sLengthSelect: "custom-select custom-select-sm form-control-sm"
    } );

    if ($.fn.DataTable.isDataTable("#" + tbEleId)) {
        //$("#" + tbEleId).DataTable().clear().draw();
        $("#" + tbEleId).DataTable().destroy();
        //$('#' + tbEleId).empty();
    }

    var totalLength = 0;
    $.ajax({
        url: getRowCountUrl,
        "data": $("#" + filterFrmEleId).serializeArray().reduce(function (item, x) { item[x.name] = x.value; return item; }, {}),
        type: "post",
        dataType: "json",
        async: false,
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 999) {
                swal({
                    title: "錯誤",
                    text: 'Status Code:' + jqXHR.status + "\n" + stripHtml(jqXHR.responseText),
                    type: "error",
                    confirmButtonText: "確認",
                },
                    function () {
                    });
            }
            else {
                swal("錯誤", jqXHR.Message + ', Status Code:' + jqXHR.status, 'error');
            }
            totalLength = -1;
        },
        success: function (data) {
            //console.log(data);
            if (data.result == 1) {
                totalLength = data.row_count;
            }
            else {
                totalLength = -1;
                if (data.fields_err_msg != null && Object.keys(data.fields_err_msg).length > 0) {
                    ShowFieldValidError(filterFrmEleId, data.fields_err_msg)
                } else {
                    swal("錯誤", data.msg, 'error');
                }
            }
            if ($("#" + filterFrmEleId).find('#total_length').length == 0) {
                $("#" + filterFrmEleId).append('<input type="hidden" name="total_length" id="total_length" value="" />');
            }
            $("#" + filterFrmEleId).find('#total_length').val(totalLength);
        }
    });

    if (totalLength != -1) {
        dataTableObj = $('#' + tbEleId).dataTable({
            // bAutoWidth: false,
            // dom: '<"row"<"col-lg-6"f><"col-sm-6 text-right"l>>' +
            //     '<"table-responsive"t>' +
            //     '<"row"<"col-sm-6"i><"col-sm-6"p>>',
            // //dom: '<l><"table-responsive"t>p',
            // language: {
            //     "paginate": {
            //         "previous": "<i class='fas fa-chevron-left'></i>",
            //         "next": "<i class='fas fa-chevron-right'></i>"
            //     },
            //     "lengthMenu": "顯示_MENU_筆",
            //     "info": "顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆",
            //     "emptyTable": "很抱歉！查無資料",
            //     "loadingRecords": "資料讀取中…",
            //     "infoEmpty": ""
            // },
            lengthChange: true,
            autoWidth: false,
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
                },
                topEnd: 'pageLength',
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            language: {
                url: DataTablesLibFolderPath + 'i18n/zh-HANT.json',
            },
            searching: false,
            // fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
            //     $('.dataTables_filter').before($('#toolbar'));
            //     $('.dataTables_filter').remove();
            // },
            order: tbOrderBy,
            createdRow: function (row, data, dataIndex) {
                //console.log(data);
                //$(row).addClass('clickable-row').attr('data-href', '@Url.Action("Modify")/' + data.NO);
            },
            processing: true,
            serverSide: true,
            stateSave: true,
            stateSaveCallback: function(settings,data) {
                localStorage.setItem(DataTablesId + '_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                console.log('load ' + DataTablesId + '_' + settings.sInstance);
                return JSON.parse( localStorage.getItem(DataTablesId + '_' + settings.sInstance ) )
            },
            ajax: {
                "url": tbAjaxUrl,
                "type": "POST",
                "data": $("#" + filterFrmEleId).serializeArray().reduce(function (item, x) { item[x.name] = x.value; return item; }, {}),
                "error": function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            },
            columns: tbColumns,
            initComplete: function (settings, json) {
            },
            drawCallback: function (settings) {
                $("#data_list").off("click");
                $("#data_list").on("click", "a.delete", function (e) { DeleteDataListItem(e, $(this).data("name"), tbDelRowUrl + '/' + $(this).data("id"), "", dataTableObj); });
                $('#data_list input').each(function () {
                    $(this).closest('td').css('padding-top', '0').css('padding-bottom', '0').css('vertical-align', 'middle');
                });

                if (CallbackFunc != undefined && CallbackFunc != null) {
                    CallbackFunc();
                }
            }
        });
    }
}