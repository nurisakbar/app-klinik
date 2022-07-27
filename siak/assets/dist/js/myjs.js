$(document).ready(function() {
    $('input[name="reset"]').click(function(e) {
        location = location.href;
    });

    $('select.select').not(".skip").select2({width:'100%'});

});

function price_input_C(x) {
    var v = x.split('__');

    if (v[1] === 'C') {
        return v[0];
    } else {
        return '-'
    }
}

function price_input_D(x) {
    var v = x.split('__');

    if (v[1] === 'D') {
        return v[0];
    } else {
        return '-'
    }
}

function clearLocalStorage() {
    bootbox.confirm(lang.r_u_sure, function (result) {
        if (result) {
            localStorage.clear();
            // location.reload(true);
            location = location.href;
        }
    }); 
}

// var ids = null;

// function getIDs() {
// 	ids = [];
// 	$('.checktd:checked').each(function() {
// 		ids.push(this.value);
// 	});
// }

// function row_status(x) {
//     if(x == null) {
//         return '';
//     } else if(x == 'pending') {
//         return '<div class="text-center" style="cursor:pointer;"><span class="row_status label label-warning">'+lang[x]+'</span></div>';
//     } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
//         return '<div class="text-center" style="cursor:pointer;"><span class="row_status label label-success">'+lang[x]+'</span></div>';
//     } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
//         return '<div class="text-center" style="cursor:pointer;"><span class="row_status label label-info">'+lang[x]+'</span></div>';
//     } else if(x == 'due' || x == 'returned') {
//         return '<div class="text-center" style="cursor:pointer;"><span class="row_status label label-danger">'+lang[x]+'</span></div>';
//     } else {
//         return '<div class="text-center" style="cursor:pointer;"><span class="row_status label label-default">'+x+'</span></div>';
//     }
// }
// function is_valid_discount(mixed_var) {
//     return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
// }
// function check_add_item_val() {
//     $('#add_item').bind('keypress', function (e) {
//         if (e.keyCode == 13 || e.keyCode == 9) {
//             e.preventDefault();
//             $(this).autocomplete("search");
//         }
//     });
// }

// function printDiv(page_title) {
//     var divToPrint=document.getElementById('print');
//     var newWin=window.open('','Print-Window');
//     newWin.document.open();
//     newWin.document.write('<html><head><title>' + page_title + '</title>');
//     newWin.document.write('<link rel="stylesheet" type="text/css" href="'+site.base_url+'assets/dist/css/print.css" />');
//     newWin.document.write('</head><body onload="window.print()"><style>.no-print{display: none;}</style>');
//     newWin.document.write(divToPrint.innerHTML);
//     newWin.document.write('</body></html>');
//     newWin.document.close();
// }

// function is_numeric(mixed_var) {
//     var whitespace =
//     " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
//     return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
//         1)) && mixed_var !== '' && !isNaN(mixed_var);
// }


// $.extend(
//     true,
//     $.fn.dataTable.defaults,
//     {
//         sDom:"<'row'<'col-md-6 text-left'l><'col-md-6 text-right'f>r>t<'row'<'col-md-6 text-left'i><'col-md-6 text-right'p>>",
//         sPaginationType:"bootstrap",
//         "fnDrawCallback":function() {
//             $(".tip").tooltip({html: true});
//             $(".popnote").popover();
//             $('.checkbox').iCheck({
//                 checkboxClass:'icheckbox_square-green',
//                 radioClass:'iradio_square-green',
//                 increaseArea:'20%'
//             });
//             $("input").addClass('input-xs');
//             $("select").addClass('select input-xs');
//             $(".select").select2();
//         }
//     }
// );
// $.extend(
//     $.fn.dataTableExt.oStdClasses,
//     {
//         sWrapper:"dataTables_wrapper form-inline"
//     }
// );
// $.fn.dataTableExt.oApi.fnPagingInfo=function(a) {
//     return {
//         iStart:a._iDisplayStart,
//         iEnd:a.fnDisplayEnd(),
//         iLength:a._iDisplayLength,
//         iTotal:a.fnRecordsTotal(),
//         iFilteredTotal:a.fnRecordsDisplay(),
//         iPage:a._iDisplayLength===-1?0:Math.ceil(a._iDisplayStart/a._iDisplayLength),
//         iTotalPages:a._iDisplayLength===-1?0:Math.ceil(a.fnRecordsDisplay()/a._iDisplayLength)
//     }
// };
// $.extend(
//     $.fn.dataTableExt.oPagination, {
//         bootstrap: {
//             fnInit:function(e,b,d) {
//                 var a=e.oLanguage.oPaginate;
//                 var f=function(g) {
//                     g.preventDefault();
//                     if(e.oApi._fnPageChange(e,g.data.action)) {
//                         d(e)
//                     }
//                 };
//                 $(b).append('<ul class="pagination pagination-sm"><li class="prev disabled"><a href="#"> '+a.sPrevious+'</a></li><li class="next disabled"><a href="#">'+a.sNext+" </a></li></ul>");
//                 var c=$("a",b);
//                 $(c[0]).bind("click.DT", {
//                     action:"previous"
//                 },f);
//                 $(c[1]).bind("click.DT", {
//                     action:"next"
//                 },f)
//             },
//             fnUpdate:function(c,k) {
//                 var l=5;
//                 var e=c.oInstance.fnPagingInfo();
//                 var h=c.aanFeatures.p;
//                 var g,m,f,d,a,n,b=Math.floor(l/2);
//                 if(e.iTotalPages<l) {
//                     a=1;n=e.iTotalPages
//                 } else {
//                     if(e.iPage<=b) {
//                         a=1;
//                         n=l
//                     } else {
//                         if(e.iPage>=(e.iTotalPages-b)) {
//                             a=e.iTotalPages-l+1;
//                             n=e.iTotalPages
//                         } else {
//                             a=e.iPage-b+1;
//                             n=a+l-1
//                         }
//                     }
//                 }
//                 for(g=0,m=h.length;g<m;g++) {
//                     $("li:gt(0)",h[g]).filter(":not(:last)").remove();
//                     for(f=a;f<=n;f++) {
//                         d=(f==e.iPage+1)?'class="active"':"";
//                         $("<li "+d+'><a href="#">'+f+"</a></li>").insertBefore($("li:last",h[g])[0]).bind("click", function(i) {
//                             i.preventDefault();
//                             c._iDisplayStart=(parseInt($("a",this).text(),10)-1)*e.iLength;
//                             k(c)
//                         })
//                     }
//                     if(e.iPage===0) {
//                         $("li:first",h[g]).addClass("disabled");
//                     } else {
//                         $("li:first",h[g]).removeClass("disabled");
//                     }
//                     if(e.iPage===e.iTotalPages-1||e.iTotalPages===0) {
//                         $("li:last",h[g]).addClass("disabled");
//                     } else {
//                         $("li:last",h[g]).removeClass("disabled");
//                     }
//                 }
//             }
//         }
//     }
// );
// if($.fn.DataTable.TableTools) {
//     $.extend(
//         true,
//         $.fn.DataTable.TableTools.classes,
//         {
//             container:"btn-group",
//             buttons: {
//                 normal:"btn btn-sm btn-primary",
//                 disabled:"disabled"
//             },
//             collection: {
//                 container:"DTTT_dropdown dropdown-menu",
//                 buttons:{
//                     normal:"",
//                     disabled:"disabled"
//                 }
//             },
//             print: {
//                 info:"DTTT_print_info modal"
//             },
//             select: {
//                 row:"active"
//             }
//         }
//     );
//     $.extend(
//         true,
//         $.fn.DataTable.TableTools.DEFAULTS.oTags,
//         {
//             collection: {
//                 container:"ul",
//                 button:"li",
//                 liner:"a"
//             }
//         }
//     )
// };

// $('#supplier, #rsupplier, .rsupplier').select2({
//     ajax: {
//         url: site.base_url+"people/supplier_suggestions",
//         dataType: 'json',
//         delay: 250,
//         data: function (params) {
//           return {
//             term: params.term, // search term
//             limit: 10
//           };
//         },
//         processResults: function (data, params) {
//             if(data.results != null) {
//                 return { results: data.results };
//             } else {
//                 return { results: [{id: '', text: globalLang.no_match_found}]};
//             }
//         },
//         cache: true
//     },
//     placeholder: globalLang.search_sippliers,
//     minimumInputLength: 1,
// });

// function fld(oObj) {
//     if (oObj != null) {
//         var aDate = oObj.split('-');
//         var bDate = aDate[2].split(' ');
//         year = aDate[0], month = aDate[1], day = bDate[0], time = bDate[1];
//         if (site.dateFormats.js_sdate == 'dd-mm-yyyy')
//             return day + "-" + month + "-" + year + " " + time;
//         else if (site.dateFormats.js_sdate === 'dd/mm/yyyy')
//             return day + "/" + month + "/" + year + " " + time;
//         else if (site.dateFormats.js_sdate == 'dd.mm.yyyy')
//             return day + "." + month + "." + year + " " + time;
//         else if (site.dateFormats.js_sdate == 'mm/dd/yyyy')
//             return month + "/" + day + "/" + year + " " + time;
//         else if (site.dateFormats.js_sdate == 'mm-dd-yyyy')
//             return month + "-" + day + "-" + year + " " + time;
//         else if (site.dateFormats.js_sdate == 'mm.dd.yyyy')
//             return month + "." + day + "." + year + " " + time;
//         else
//             return oObj;
//     } else {
//         return '';
//     }
// }

// function formatQuantity(x) {
//     return (x != null) ? '<div class="text-center">'+formatNumber(x, site.settings.qty_decimals)+'</div>' : '';
// }
// function formatQuantity2(x) {
//     return (x != null) ? formatQuantityNumber(x, site.settings.qty_decimals) : '';
// }
// function formatQuantityNumber(x, d) {
//     if (!d) { d = site.settings.qty_decimals; }
//     return parseFloat(accounting.formatNumber(x, d, '', '.'));
// }
// function attachment(x) {
//     return x == null ? '' : '<div class="text-center"><a href="'+site.base_url+'inventory_settings/download/' + x + '" class="tip" title="'+lang.download+'"><i class="fa fa-file"></i></a></div>';
// }
// function currencyFormat(x, y = null) {
//     if (y == 1) {
//         return '<div class="text-center">'+formatMoney(x != null ? x : 0)+'</div>';
//     }
//     if (x == null) {
//         return formatNumber('0', site.settings.qty_decimals);
//     }
//     value = x.split('-');
//     return '<div class="text-right">'+formatMoney(value[0] != null ? value[0] : 0, value[1])+'</div>';
// }
// function pay_status(x) {
//     if(x == null) {
//         return '';
//     } else if(x == 'pending') {
//         return '<div class="text-center"><span class="payment_status label label-warning">'+lang[x]+'</span></div>';
//     } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
//         return '<div class="text-center"><span class="payment_status label label-success">'+lang[x]+'</span></div>';
//     } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
//         return '<div class="text-center"><span class="payment_status label label-info">'+lang[x]+'</span></div>';
//     } else if(x == 'due' || x == 'returned') {
//         return '<div class="text-center"><span class="payment_status label label-danger">'+lang[x]+'</span></div>';
//     } else {
//         return '<div class="text-center"><span class="payment_status label label-default">'+x+'</span></div>';
//     }
// }
// function decimalFormat(x) {
//     return '<div class="text-center">'+formatNumber(x != null ? x : 0)+'</div>';
// }

// function formatNumber(x, d) {
//     if(!d && d != 0) { d = site.settings.decimals; }
//     // if(site.settings.sac == 1) {
//     //     return formatSA(parseFloat(x).toFixed(d));
//     // }
//     return accounting.formatNumber(x, d, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep);
// }

// function formatMoney(x, symbol) {
//     if(!symbol) { symbol = mAccountSettings.currency_symbol; } else {
//         $.each(currencies, function() {
//             console.log(this.id);
//             console.log(this.symbol);
//             if (this.id == symbol) {
//                 if (this.symbol) {
//                     symbol = this.symbol;
//                 } else {
//                     symbol = this.code;
//                 }
                
//             }
//         });
//     }
//     // if(site.settings.sac == 1) {
//     //     return (site.settings.display_symbol == 1 ? site.settings.symbol : '') +
//     //         ''+formatSA(parseFloat(x).toFixed(site.settings.decimals)) +
//     //         (site.settings.display_symbol == 2 ? site.settings.symbol : '');
//     // }
//     var fmoney = accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
//     return (site.settings.display_symbol == 1 ? site.settings.symbol : '') +
//         fmoney +
//         (site.settings.display_symbol == 2 ? site.settings.symbol : '');
// }

// function checkbox(x) {
//     return '<div class="text-center"><input type="checkbox" name="val[]" value="' + x + '" class="checkbox multi-select checktd"></div>';
// }

// function img_hl(x) {
// 	var rand =  Math.floor((Math.random() * 1000) + 1);
//     var image_link = (x == null || x == '') ? 'no_image.png' : x;
//     return '<div class="text-center"><a href="' + site.base_url + 'assets/uploads/images/' + image_link + '" data-lightbox="' + image_link + '_' + rand + '"><img src="' + site.base_url + 'assets/uploads/images/thumbs/' + image_link + '" alt="" style="width:30px; height:30px;" /></a></div>';
// }

// function formatSA (x) {
//     x=x.toString();
//     var afterPoint = '';
//     if(x.indexOf('.') > 0)
//        afterPoint = x.substring(x.indexOf('.'),x.length);
//     x = Math.floor(x);
//     x=x.toString();
//     var lastThree = x.substring(x.length-3);
//     var otherNumbers = x.substring(0,x.length-3);
//     if(otherNumbers != '')
//         lastThree = ',' + lastThree;
//     var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

//     return res;
// }
// function unitToBaseQty(qty, unitObj) {
//     switch(unitObj.operator) {
//         case '*':
//             return parseFloat(qty)*parseFloat(unitObj.operation_value);
//             break;
//         case '/':
//             return parseFloat(qty)/parseFloat(unitObj.operation_value);
//             break;
//         case '+':
//             return parseFloat(qty)+parseFloat(unitObj.operation_value);
//             break;
//         case '-':
//             return parseFloat(qty)-parseFloat(unitObj.operation_value);
//             break;
//         default:
//             return parseFloat(qty);
//     }
// }
// function baseToUnitQty(qty, unitObj) {
//     switch(unitObj.operator) {
//         case '*':
//             return parseFloat(qty)/parseFloat(unitObj.operation_value);
//             break;
//         case '/':
//             return parseFloat(qty)*parseFloat(unitObj.operation_value);
//             break;
//         case '+':
//             return parseFloat(qty)-parseFloat(unitObj.operation_value);
//             break;
//         case '-':
//             return parseFloat(qty)+parseFloat(unitObj.operation_value);
//             break;
//         default:
//             return parseFloat(qty);
//     }
// }
// function set_page_focus() {
//     if (site.settings.set_focus == 1) {
//         $('#add_item').attr('tabindex', an);
//         $('[tabindex='+(an-1)+']').focus().select();
//     } else {
//         $('#add_item').attr('tabindex', 1);
//         $('#add_item').focus();
//     }
//     $('.rquantity').bind('keypress', function (e) {
//         if (e.keyCode == 13) {
//             $('#add_item').focus();
//         }
//     });
// }
// function calculateTax(tax, amt, met) {
//     if (tax && tax_rates) {
//         tax_val = 0; tax_rate = '';
//         $.each(tax_rates, function() {
//             if (this.id == tax) {
//                 tax = this;
//                 return false;
//             }
//         });
//         if (tax.type == 1) {
//             if (met == '0') {
//                 tax_val = formatDecimal(((amt) * parseFloat(tax.rate)) / (100 + parseFloat(tax.rate)), 4);
//                 tax_rate = formatDecimal(tax.rate) + '%';
//             } else {
//                 tax_val = formatDecimal(((amt) * parseFloat(tax.rate)) / 100, 4);
//                 tax_rate = formatDecimal(tax.rate) + '%';
//             }
//         } else if (tax.type == 2) {
//             tax_val = parseFloat(tax.rate);
//             tax_rate = formatDecimal(tax.rate);
//         }
//         return [tax_val, tax_rate];
//     }
//     return false;
// }
// function calculateDiscount(val, amt) {
//     if (val.indexOf("%") !== -1) {
//         var pds = val.split("%");
//         return formatDecimal((parseFloat(((amt) * parseFloat(pds[0])) / 100)), 4);
//     }
//     return formatDecimal(val);
// }
// function formatQty(x) {
//     return (x != null) ? formatNumber(x, site.settings.qty_decimals) : '';
// }
// function change_currency(id) {
//     if (id) {
//         $.ajax({
//             type: "post",
//             async: false,
//             url: site.base_url + "sales/getCurrencyByID/" + id,
//             dataType: "json",
//             success: function (data) {
//                 if (data) {
//                     $('#currency_id').val(id);
//                     $('._curr1').html(data.row.code);
//                     $('.currency_code').html(data.row.code);
                    
//                 }
//             }
//         });
//     }
// }

// $(document).ready(function() {
// 	$('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
// 	    checkboxClass: 'icheckbox_square-green',
// 	    radioClass: 'iradio_square-green',
// 	    increaseArea: '20%'
// 	});

//     $('div.dataTables_filter input').addClass('form-control');

//     /* Calculate date range in javascript */
//     startDate = new Date((new Date(mAccountSettings.fy_start).getTime())  + (new Date().getTimezoneOffset() * 60 * 1000));
//     endDate = new Date((new Date(mAccountSettings.fy_end).getTime())  + (new Date().getTimezoneOffset() * 60 * 1000));
    
//     if (site.dateFormats) {
//         var date_time_formats = site.dateFormats.js_ldate.split(' ');
//         var date_format = date_time_formats[0];
//         var time_format = date_time_formats[1];
//     }
    
//     $('.datetime').not('.skip').datetimepicker({
//         dateFormat: date_format,
//         timeFormat: time_format,
//         minDate: startDate,
//         maxDate: endDate,
//         fontAwesome: true,
//         language: 'main',
//         autoclose: 1,
//         todayBtn: 1, 
//         todayHighlight: 1,
//         timeInput: true,
//         minView: 2 
//     });
//     if ($('.datetime').val()) {} else {
//         $('.datetime').datetimepicker('setDate', (new Date()));
//     }

//     $('.date').datepicker({
//         dateFormat: site.dateFormats.js_sdate,
//         minDate: startDate,
//         maxDate: endDate,
//         fontAwesome: true,        
//         language: 'main', 
//         autoclose: 1,
//         todayBtn: 1,
//         todayHighlight: 1,
//         minView: 2 
//     });
//     if ($('.date').val()) {} else {
//         $('.date').datepicker('setDate', (new Date()));
//     }


//     $('#myModal').on('hidden.bs.modal', function() {
//         $(this).find('.modal-dialog').empty();
//         //$(this).find('#myModalLabel').empty().html('&nbsp;');
//         //$(this).find('.modal-body').empty().text('Loading...');
//         //$(this).find('.modal-footer').empty().html('&nbsp;');
//         $(this).removeData('bs.modal');
//     });
//     $('#myModal2').on('hidden.bs.modal', function () {
//         $(this).find('.modal-dialog').empty();
//         //$(this).find('#myModalLabel').empty().html('&nbsp;');
//         //$(this).find('.modal-body').empty().text('Loading...');
//         //$(this).find('.modal-footer').empty().html('&nbsp;');
//         $(this).removeData('bs.modal');
//         $('#myModal').css('zIndex', '1050');
//         $('#myModal').css('overflow-y', 'scroll');
//     });
//     $('#myModal2').on('show.bs.modal', function () {
//         $('#myModal').css('zIndex', '1040');
//     });
//     $('.modal').on('show.bs.modal', function () {
//         $('#modal-loading').show();
//         $('.blackbg').css('zIndex', '1041');
//         $('.loader').css('zIndex', '1042');
//     }).on('hide.bs.modal', function () {
//         $('#modal-loading').hide();
//         $('.blackbg').css('zIndex', '3');
//         $('.loader').css('zIndex', '4');
//     });
//     $('body').on('click', '.delivery_link td:not(:first-child, :nth-last-child(2), :nth-last-child(3), :last-child)', function() {
//         $('#myModal').modal({remote: site.base_url + 'sales/view_delivery/' + $(this).parent('.delivery_link').attr('id')});
//         $('#myModal').modal('show');
//     });
//     $(document).on('click', '[data-toggle="ajax"]', function(e) {
//         e.preventDefault();
//         var href = $(this).attr('href');
//         $.get(href, function( data ) {
//             $("#myModal").html(data).modal();
//         });
//     });
// });

// $('.gen_slug').change(function(e) {
//     var title = $(this).val();
//     var slug_url = site.base_url+"inventory_settings/slug";
//     $.get(slug_url, {title: title, type: 'brands'}, function (slug) {
//         $('.slug').val(slug).change();
//     });
// });

// $('#random_num').click(function(){
//     $(this).parent('.input-group').children('input').val(generateCardNo(8));
// });

// function formatDecimal(x, d) {
//     if (!d) { d = site.settings.decimals; }
//     return parseFloat(accounting.formatNumber(x, d, '', '.'));
// }

// function formatDecimals(x, d) {
//     if (!d) { d = site.settings.decimals; }
//     return parseFloat(accounting.formatNumber(x, d, '', '.')).toFixed(d);
// }

// function suppliers(ele) {
//     $(ele).select2({
//         ajax: {
//             url: site.base_url+"people/supplier_suggestions",
//             dataType: 'json',
//             delay: 250,
//             data: function (params) {
//               return {
//                 term: params.term, // search term
//                 limit: 10
//               };
//             },
//             processResults: function (data, params) {
//                 if(data.results != null) {
//                     return { results: data.results };
//                 } else {
//                     return { results: [{id: '', text: globalLang.no_match_found}]};
//                 }
//             },
//             cache: true
//         },
//         placeholder: globalLang.search_sippliers,
//         minimumInputLength: 1
//     });
// }

// function generateCardNo(x) {
//     if(!x) {
//         x = 16;
//     }
//     chars = "1234567890";
//     no = "";
//     for (var i=0; i<x; i++) {
//        var rnum = Math.floor(Math.random() * chars.length);
//        no += chars.substring(rnum,rnum+1);
//    }
//    return no;
// }

// function getSlug(title, type) {
//     var slug_url = site.base_url+'inventory_settings/slug';
//     $.get(slug_url, {title: title, type: type}, function (slug) {
//         $('#slug').val(slug).change();
//     });
// }

// $(document).on('ifChecked', '.checkth, .checkft', function(event) {
//     $('.checkth, .checkft').iCheck('check');
//     $('.multi-select').each(function() {
//         $(this).iCheck('check');
//     });
// });

// $(document).on('ifUnchecked', '.checkth, .checkft', function(event) {
//     $('.checkth, .checkft').iCheck('uncheck');
//     $('.multi-select').each(function() {
//         $(this).iCheck('uncheck');
//     });
// });

// $(document).on('ifUnchecked', '.multi-select', function(event) {
//     $('.checkth, .checkft').attr('checked', false);
//     $('.checkth, .checkft').iCheck('update');
// });

