<br>
<div id="container" class="container">
  <div class="row-fluid">
    <div class="col-12">
      <div class="row">
        <div class="col-9">
          <h2><?php echo $title;?></h2>
        </div>
        <div class="col-3">
          <button type="button" class="btn btn-primary float-right" id="createBrand">
            <i class="mdi mdi-plus-circle"></i>&nbsp;Create brand
          </button>
        </div>
      </div>
    </div><br>
    <?php echo $flashPartialView;?>
    <div class="alert alert-info" style="display: none;">

    </div>
    <table id="brand" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" width="100%">
     <thead>
      <tr>
       <th>ID</th>
       <th>Brands</th>
       <th>Models</th>
     </tr>
   </thead>
   <tbody id="brand_row">

   </tbody>
 </table>
</div>
</div>
<div class="row-fluid">
 <div class="col-12">&nbsp;</div>
</div>

<!-- create -->
<div id="frmConfirmCreate" class="modal hide fade" tabindex="-1" role="dialog">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title">Create Brand</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form action="" id="frm-create">
     <div class="form-inline">
      <label for="">Brand: </label> &nbsp;<input type="text" name="brand" class="form-control">
    </div>
  </form>
</div>
<div class="modal-footer">
  <a href="#" class="btn btn-primary" id="saveBrand">OK</a>
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>
</div>
</div>
</div>
<!-- delete  -->
<div id="frmConfirmDelete" class="modal hide fade" tabindex="-1" role="dialog">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title">Confirmation</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <p>Are you sure that you want to delete this brand?</p>
  </div>
  <div class="modal-footer">
    <a class="btn btn-primary" data-dismiss="modal" id="delete-comfirm" >Yes</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
  </div>
</div>
</div>
</div>
<!-- edit -->
<div id="frmConfirmEdit" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_edit">
          <div class="form-inline">

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary create" id="update">OK</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- link bootstrap4 and javaScipt -->
<link href="<?php echo base_url();?>assets/DataTable/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
 $(document).ready(function() {
  var t = $('#brand').DataTable();
  showAllBrand();
  
   // showAllBrand function get brand data to table 
   function showAllBrand()
   {
    $("#brand_row").html('<tr><td class="text-center text-info" colspan="10"><i class="mdi mdi-cached mdi-spin mdi-24px"></i>Loading... </td></tr>');
    $.ajax({
     type: 'ajax',
     url: '<?php echo base_url();?>/brand/showAllBrand',
     async: true,
     dataType: 'json',
     success: function(data){
      t.clear().draw();
      var n =1;
      var i;
      for(i=0; i<data.length; i++){
       t.row.add( [
        n+'&nbsp;<a href="#" class="item-edit" dataid="'+data[i].idbrand+'"><i class="mdi mdi-pencil" data-toggle="tooltip" title="Edit brand"></i></a>'+
        '<a href="#" class="item-delete text-danger" dataid="'+data[i].idbrand+'"><i class="mdi mdi-delete" data-toggle="tooltip" title="Delete brand"></i></a>',
        data[i].brand,'<a href="<?php echo base_url(); ?>models/index/'+data[i].idbrand+'" title=""><i class="mdi mdi-format-list-bulleted" data-toggle="tooltip" title="View all models"></i></a> '+ data[i].ModelCount+
        ' model (s)'

             // '<a  title="List models"><i class="mdi mdi-format-list-bulleted"></i>'+ 3 model(s)+'</a>'
             ] ).draw( false );
       n++;
     }
   },
   error: function(){
     alert('Could not get Data from Database');
   }
 });
  }

       // create
       $("#createBrand").click( function(){
        $('#frmConfirmCreate').modal('show').on('shown.bs.modal', function(){
          $('input[name=brand]').focus();
        });
      });
         // create brand by using ajax
         $('#saveBrand').on('click', function(){
          var brand = $('input[name=brand]');
          // var address = $('textarea[name=txtAddress]');
          var result = '';
          if(brand.val()==''){
            brand.parent().parent().addClass('has-error');
          }else{
            brand.parent().parent().removeClass('has-error');
            result +='1';
          }
          if(result=='1'){
           $.ajax({
             url: "<?php echo base_url() ?>brand/create_brand",
             type: "POST",
             data: $('#frm-create').serialize(),
             dataType: 'json',
             success: function(data){
               if(data.status){
                $('#frm-create')[0].reset();
                $('#frmConfirmCreate').modal('hide');
                $('.alert-info').html('Brand was created  successfully').fadeIn().delay(6000).fadeOut('slow');
                showAllBrand();

              }
            },
            error: function(){
             alert('Error can not create...');
           }
         });
         }
       });

         // delete brand by ajax
         $('#brand_row').on('click', '.item-delete', function(){
           var id = $(this).attr('dataid');
           $('#frmConfirmDelete').data('id', id).modal('show');
         });
         // comfirm delete button
         $("#delete-comfirm").on('click',function(){
           var id = $('#frmConfirmDelete').data('id');     
           $.ajax({
             url: "<?php echo base_url() ?>brand/deleteBrand",
             type: "POST",
             data: {idbrand: id},
             dataType: "json",
             success: function(data){
                 // alert('Owner deleted successfully....');
                 $('#frmConfirmDelete').modal('hide');
                 $('.alert-info').html('Brand was deleted  successfully').fadeIn().delay(6000).fadeOut('slow');
                 showAllBrand();
               },
               error: function(){
                 alert("Error delete!! this brand have relationship with another field...");
               }
             });
         });

         // update brand modal pop up by ajax
         $('#brand_row').on('click', '.item-edit', function(){
           var id = $(this).attr('dataid');
           $.ajax({
             type: 'POST',
             data: {idbrand: id},
             url: '<?php echo base_url();?>/brand/showEditBrand',
             async: true,
             dataType: 'json',
             success: function(data){
               $('#frm_edit').html(data);
               // $('#frmConfirmEdit').modal('show');
               $('#frmConfirmEdit').modal('show').on('shown.bs.modal', function(){
                $('input[name=brand_update]').focus();
              });
             },
             error: function(){
               alert('Could not get any data from Database');
             }
           });
         });
         // save update button 
         $("#update").click(function(){
          var id = $('#frmConfirmEdit').data('id');
          var brand = $('input[name=brand_update]');
          var result = '';
          if(brand.val()==''){
            brand.parent().parent().addClass('has-error');
          }else{
            brand.parent().parent().removeClass('has-error');
            result +='1';
          }
          if(result=='1'){
           $.ajax({
             url: "<?php echo base_url()?>brand/update",
             type: "POST",
             data: $('#frm_edit').serialize(),
             dataType: 'json',
             success: function(data){
               if(data.status){
                 $('#frm_edit')[0].reset();
                 $('#frmConfirmEdit').modal('hide');
                 $('.alert-info').html('Brand was updated  successfully').fadeIn().delay(6000).fadeOut('slow');
                 showAllBrand();
               }
             },
             error: function(){
               alert("Error edit this brand have relationship with another field...");
               $('#frmConfirmEdit').modal('hide');
             }
           });
         }
       });

       });


     </script>