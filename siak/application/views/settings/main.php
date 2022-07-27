<style type="text/css">
  .zoomContainer{ z-index: 9999;}
  .zoomWindow{ z-index: 9999;}
</style>
<script type="text/javascript">
$(document).ready(function() {
  /* Setup jQuery datepicker ui */
  $('#SettingFyStart').datepicker({
    dateFormat: $("#SettingDateFormat").val().split('|')[1],  /* Read the Javascript date format value */
    numberOfMonths: 1,
    onClose: function(selectedDate) {
      $("#SettingFyEnd").datepicker("option", "minDate", selectedDate);
    }
  });
  $('#SettingFyEnd').datepicker({
    dateFormat: $("#SettingDateFormat").val().split('|')[1],  /* Read the Javascript date format value */
    numberOfMonths: 1,
    onClose: function(selectedDate) {
      $("#SettingFyStart").datepicker("option", "maxDate", selectedDate);
    }
  });

  $("#SettingDateFormat").change(function() {
    /* Read the Javascript date format value */
    dateFormat = $(this).val().split('|')[1];
    $("#SettingFyStart").datepicker("option", "dateFormat", dateFormat);
    $("#SettingFyEnd").datepicker("option", "dateFormat", dateFormat);
  });
});
</script>
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"><?= lang('settings_views_main_label_account_settings'); ?></h3>
    </div>
    <!-- /.box-header -->
    <?= form_open(); ?>
      <div class="box-body">
        <?php  
        $data = array(
          'class' => 'form-control',
        ); 
        ?>
        <div class="row">
          <div class="col-xs-4">
            <div class="form-group">
              <?php  
              $data['name'] = 'name';
              $data['value'] = set_value('name', $this->mAccountSettings->name);
              echo form_label(lang('settings_views_main_label_company_name'), 'name');
              echo form_input($data);
              ?>
            </div>
            <div class="form-group">
              <?php  
              $data['name'] = 'address';
              $data['value'] = set_value('address', $this->mAccountSettings->address);
              echo form_label(lang('settings_views_main_label_address'), 'address');
              echo form_input($data);
              ?>
            </div>
            <div class="form-group">
              <?php  
              $data['name'] = 'email';
              $data['value'] = set_value('email', $this->mAccountSettings->email);
              echo form_label(lang('settings_views_main_label_email'), 'email');
              echo form_input($data);
              ?>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <?php  
              $data['name'] = 'currency_symbol';
              $data['value'] = set_value('currency_symbol', $this->mAccountSettings->currency_symbol);
              echo form_label(lang('settings_views_main_label_currency_symbol'), 'currency_symbol');
              echo form_input($data);
              ?>
            </div>
            <div class="form-group">
              <?php
              $currency_format = array(
                '##,###.##' => '##,###.##',
                '##,##.##' => '##,##.##',
                '###,###.##' => '###,###.##',
              );
              echo form_label(lang('settings_views_main_label_currency_format'), 'currency_format');
              echo form_dropdown('currency_format', $currency_format, set_value('currency_format', $this->mAccountSettings->currency_format) ,array('class'=>'form-control'));
              ?>
            </div>
            <div class="form-group">
              <?php
              $date_format = array(
                'd-M-Y|dd-M-yy|dd-MMM-yyyy' => lang('date_format_option_1'),
                'M-d-Y|M-dd-yy|MMM-dd-yyyy' => lang('date_format_option_2'),
                'Y-M-d|yy-M-dd|yyyy-MMM-dd' => lang('date_format_option_3'),
              );
              echo form_label(lang('settings_views_main_label_date_format'), 'date_format');
              echo form_dropdown('date_format', $date_format, set_value('date_format', $this->mAccountSettings->date_format) ,array('class'=>'form-control', 'id'=>'SettingDateFormat'));
              ?>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <?php 
              $data['name'] = 'fy_start';
              $data['value'] = set_value('fy_start', $this->functionscore->dateFromSql($this->mAccountSettings->fy_start));
              $data['id'] = 'SettingFyStart';
              echo form_label(lang('settings_views_main_label_financial_year_start'), 'fy_start');
              echo form_input($data);
              ?>
            </div>
            <div class="form-group">
              <?php 
              $data['name'] = 'fy_end';
              $data['value'] = set_value('fy_end', $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
              $data['id'] = 'SettingFyEnd';
              echo form_label(lang('settings_views_main_label_financial_year_end'), 'fy_end');
              echo form_input($data);
              ?>
            </div>
            <div class="form-group" style="margin-top: 30px;">
              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#logo" style="width: 100%;"><?= lang('settings_views_main_label_update_logo'); ?></button>
            </div>
          </div>
        </div>  
      </div>
      <div class="box-footer">
        <div class="form-group">
          <?php
          echo form_submit('submit', lang('submit'), array('class'=> 'btn btn-success  pull-right'));
          ?>
        </div>
      </div>
    <?= form_close(); ?>
  </div>
</section>
<!-- /.content -->

<div class="modal fade" tabindex="-1" role="dialog" id="logo" aria-labelledby="updateLogo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= lang('settings_views_main_modal_title'); ?></h4>
      </div>
      <?php $attributes = array('id' => 'updateLogo');
          echo form_open_multipart('' ,$attributes); ?>
        <div class="modal-body">
          <div class="msg">
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-left: 20px;">
                  <label><?= lang('settings_views_main_modal_label_select_image'); ?></label>
                  <input type="file" name="companylogoupdate" id="companylogoupdate">
              </div>  
              <div style="margin-top: 20px; text-align: center;">
                <img id="previewImage" src="" style="max-width: 100%; height: auto;" />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('settings_views_main_modal_btn_close'); ?></button>
          <button type="submit" name="uploadimage" class="btn btn-primary"><?= lang('settings_views_main_modal_btn_upload'); ?></button>
        </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#companylogoupdate").change(function(){
    readURL(this);
});

$('#updateLogo').submit(function(event){  
  event.preventDefault();
  var label = '<?= $_SESSION['active_account']->label; ?>';
  var data = new FormData();
  jQuery.each(jQuery('#companylogoupdate')[0].files, function(i, file) {
    data.append('companylogoupdate', file);
  });
  jQuery.ajax({  
    url:"<?= base_url(); ?>account_settings/updateLogo/"+label,  
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    type: 'POST',
    success:function(data){
      var msg = '';
      if(data){
        if (data.status == 'success') {
          msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><?= lang('strong_success_label'); ?>'+ data.msg +'</div><br>';
        }else{
          msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><?= lang('strong_error_label'); ?>'+ data.msg +'</div><br>';
        }      
      }
      $('.msg').html(msg);
      $('#logo').animate({ scrollTop: 0 }, 'fast');
    }  
  });  
});
</script>