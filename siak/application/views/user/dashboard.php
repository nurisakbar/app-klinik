<!-- Main content -->
<section class="content">
    <?php
        /* Check if BC Math Library is present */
        if (!extension_loaded('bcmath')) {
            echo '<div><div role="alert" class="alert alert-danger">'. lang('user_views_dashboard_error_alert_php_bc_math_lib_missing') .'</div></div>';
        }
    ?>
    <!-- small box -->
    <div class="row">
        <div class="col-xs-5">
            <div class="box box-widget">
                <div class="box-body no-padding">
                    <table class="table table-bordered table-condensed-custom">
                        <tbody>
                            <tr>
                                <td class="col-md-6">
                                    <?php echo lang('user_views_dashboard_label_company_name'); ?>:
                                </td>
                                <td class="col-md-6">
                                    <strong><?php echo ($this->mAccountSettings->name); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-6">
                                    <?php echo lang('user_views_dashboard_label_fiscal_year'); ?>:
                                </td>
                                <td class="col-md-6">
                                    <strong><?php echo $this->functionscore->dateFromSql($this->mAccountSettings->fy_start) . ' - ' . $this->functionscore->dateFromSql($this->mAccountSettings->fy_end); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-6">
                                    <?php echo lang('user_views_dashboard_label_email'); ?>:
                                </td>
                                <td class="col-md-6">
                                    <strong><?php echo ($this->mAccountSettings->email); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-6">
                                    <?php echo lang('user_views_dashboard_company_role'); ?>:
                                </td>
                                <td class="col-md-6">
                                    <strong><?= ($this->ion_auth->get_users_groups()->row()->description); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-6">
                                    <?php echo lang('user_views_dashboard_label_status'); ?>:
                                </td>
                                <td class="col-md-6">
                                    <?= ($this->mAccountSettings->account_locked == 0) ? '<span class="badge bg-green">'.lang('user_views_dashboard_label_unlocked').'</span>' : '<span class="badge bg-red">'.lang('user_views_dashboard_label_locked').'</span>'; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box box-widget" style="max-height: 229px;">
                <div class="box-header" style="padding-bottom: 0px !important;">
                    <h1 class="box-title" align="center" style="display: block;"><?= lang('user_views_dashboard_bc_summary'); ?></h1>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-bordered table-condensed" id="bank_table">
                        <thead>
                            <tr>
                                <th style="display: none;"></th>
                                <th style="display: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($ledgers as $ledger) {
                                    echo '<tr id='.$ledger['code'].'>';
                                    echo '<td>' . $ledger['name'] . '</td>';
                                    echo '<td>' . $this->functionscore->toCurrency($ledger['balance']['dc'], $ledger['balance']['amount']) . '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="box box-success box-solid">
                <div class="box-body" style="display: block;">
                    <div id="balance_summary" style="height: 335px;"></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="box box-success box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-solid box-success no-margin">
                        <div class="box-body">
                            <div class="text-center" style="position: relative; color: black;">
                                <h1 id="net_worth"></h1>
                                <hr>
                                <h3><strong><?= lang('net_worth'); ?></strong></h3>
                                <div style="margin-top: 60px;">
                                    <table>
                                        <tr>
                                            <td id="today_income"></td>
                                            <td><strong><?= lang('today_income') ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td id="today_expense"></td>
                                            <td><strong><?= lang('today_expense') ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td id="month_income"></td>
                                            <td><strong><?= lang('month_income') ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td id="month_expense"></td>
                                            <td><strong><?= lang('month_expense') ?></strong></td>
                                        </tr>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                      </div>
                </div>
                <div class="col-md-8">
                    <div id="cashflow_chart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="box box-success box-solid">
        <div class="box-body" style="display: block;">
            <div id="d_chart" style="height: 350px;"></div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->

<script src="<?= base_url(); ?>assets/plugins/echarts/echarts.min.js"></script>
<script type="text/javascript">
    function formatMoney(x, symbol) {
        if(!symbol) { symbol = mAccountSettings.currency_symbol; }
        var fmoney = accounting.formatMoney(x, symbol, mAccountSettings.decimal_places, mAccountSettings.thousands_sep == 0 ? ' ' : mAccountSettings.thousands_sep, mAccountSettings.decimals_sep, "%s%v");
        return fmoney;
    }

    function currencyFormat(x, y = null) {
        if (y) {
            return '<div class="text-center">'+formatMoney(x != null ? x : 0)+'</div>';
        }
        return '<div class="text-right">'+formatMoney(x != null ? x : 0)+'</div>';
    }

    $(document).ready(function() {
        $('#bank_table').DataTable({
            "sScrollY": "193px",
            "bPaginate": false,
            "bScrollCollapse": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": false,
            "bInfo": false,
            "bAutoWidth": false
        });
    });
    var c_month = '<?= date('F'); ?>';
    var c_year = '<?= date('Y'); ?>';
    var ib_graph_primary_color = '#2196f3';
    var ib_graph_secondary_color = '#eb3c00';

    $.getJSON( "<?= base_url(); ?>dashboard/getIncomeExpenseMonthlyChart/", function( data ) {
        if (!data.net_worth) {
            data.net_worth = parseFloat(0).toFixed(mAccountSettings.decimal_places);
        }
        if (!data.today_income) {
            data.today_income = parseFloat(0).toFixed(mAccountSettings.decimal_places);
        }
        if (!data.today_expense) {
            data.today_expense = parseFloat(0).toFixed(mAccountSettings.decimal_places);
        }
        if (!data.month_income) {
            data.month_income = parseFloat(0).toFixed(mAccountSettings.decimal_places);
        }
        if (!data.month_expense) {
            data.month_expense = parseFloat(0).toFixed(mAccountSettings.decimal_places);
        }
        $('#net_worth').html(currencyFormat(data.net_worth, 1));
        $('#today_income').html(currencyFormat(data.today_income));
        $('#today_expense').html(currencyFormat(data.today_expense));
        $('#month_income').html(currencyFormat(data.month_income));
        $('#month_expense').html(currencyFormat(data.month_expense));

        var c3_opt = {
            title : {
                text: 'Arus Kas',
                subtext: '12 Bulan Terakhir'
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['Pendapatan','Beban']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {
                        show: true,
                        readOnly: false,
                        title : 'Data View',
                        lang: [
                            'Data View',
                            'Batal',
                            'Reset'
                        ]
                    },
                    magicType : {
                        show: true, title : {
                            line : 'Line',
                            bar : 'Bar',
                            stack : 'Stack',
                            tiled : 'Tiled',
                            force: 'Force',
                            chord: 'Chord',
                            pie: 'Pie',
                            funnel: 'Funnel'
                        },
                        type: ['line', 'bar', 'pie', 'stack', 'tiled']
                    },
                    restore : {show: true, title : 'Reset'},
                    saveAsImage : {
                        show: true, 
                        title : 'Save as Image',
                        type : 'png',
                        lang : ['Click to Save']
                    }
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : data.xAxis
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
            {
                name:'Pendapatan',
                type:'line',
                color: [
                    ib_graph_primary_color
                ],
                smooth:true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data:data.Income,
                markPoint : {
                    data : [
                        {type : 'max', name: 'Max'},
                        {type : 'min', name: 'Min'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: 'Rata-Rata'}
                    ]
                }
            },
            {
                name:'Beban',
                type:'line',
                color: [
                    ib_graph_secondary_color
                ],
                smooth:true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data:data.Expense,
                markPoint : {
                    data : [
                        {type : 'max', name: 'Max'},
                        {type : 'min', name: 'Min'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: 'Rata-Rata'}
                    ]
                }
            }
            ]
        };
        var c3_d = echarts.init(document.getElementById('cashflow_chart'));
        c3_d.setOption(c3_opt);
    });

    $.getJSON( "<?= base_url(); ?>dashboard/getIncomeExpenseChart/", function( data ) {
        var c3_opt = {
            title : {
                text: 'Pendapatan Dan Beban' ,
                subtext: c_month + ', ' + c_year
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['Pendapatan','Beban']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {
                        show: true,
                        readOnly: false,
                        title : 'Data View',
                        lang: [
                            'Data View',
                            'Batal',
                            'Reset'
                        ]
                    },
                    magicType : {
                        show: true, title : {
                            line : 'Line',
                            bar : 'Bar',
                            stack : 'Stack',
                            tiled : 'Tiled',
                            force: 'Force',
                            chord: 'Chord',
                            pie: 'Pie',
                            funnel: 'Funnel'
                        },
                        type: ['line', 'bar', 'stack', 'tiled']
                    },
                    restore : {show: true, title : 'Reset'},
                    saveAsImage : {
                        show: true, 
                        title : 'Save as Image',
                        type : 'png',
                        lang : ['Click to Save']
                    }
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : [
                        '01',
                        '02',
                        '03',
                        '04',
                        '05',
                        '06',
                        '07',
                        '08',
                        '09',
                        '10',
                        '11',
                        '12',
                        '13',
                        '14',
                        '15',
                        '16',
                        '17',
                        '18',
                        '19',
                        '20',
                        '21',
                        '22',
                        '23',
                        '24',
                        '25',
                        '26',
                        '27',
                        '28',
                        '29',
                        '30',
                        '31'
                    ]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'Pendapatan',
                    type:'line',
                    color: [
                        ib_graph_primary_color
                    ],
                    smooth:true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data:data.Income,
                    markLine : {
                        data : [
                            {type : 'average', name: 'Rata-Rata'}
                        ]
                    }
                },
                {
                    name:'Beban',
                    type:'line',
                    color: [
                        ib_graph_secondary_color
                    ],
                    smooth:true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data:data.Expense,
                    markLine : {
                        data : [
                            {type : 'average', name: 'Rata-Rata'}
                        ]
                    }
                }
            ]
        };
        var c3_d = echarts.init(document.getElementById('d_chart'));
        c3_d.setOption(c3_opt);
    });
    
    pie_options = {
        title : {
            text: 'Ringkasan Saldo',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['Assets','Liabilities and Owners Equity','Income','Expense']
        },
        series : [
            {
                name: 'Ringkasan Saldo',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:<?php echo $accsummary['assets_total'] ?>, name:'Assets'},
                    {value:<?php echo $accsummary['liabilities_total']; ?>, name:'Liabilities and Owners Equity'},
                    {value:<?php echo $accsummary['income_total']; ?>, name:'Income'},
                    {value:<?php echo $accsummary['expense_total']; ?>, name:'Expense'},
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    var pie = echarts.init(document.getElementById('balance_summary'));
    pie.setOption(pie_options);
</script>