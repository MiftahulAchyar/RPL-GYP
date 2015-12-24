<?php
if($this->session->flashdata('pesan')){
    echo "<script>alert('".$this->session->flashdata('pesan')."');</script>";
}
if (isset($_POST['edit'])) {
    $_POST['edit'] =$_POST['edit'];
    $_POST['id'] = $_POST['id'];
    redirect('admin/Blog_write');
}
                     
?>
<link href="<?=admin_asset();?>css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<div class="box">
    <div class="box-header" style="padding:10px 0 0 10px">
        <form method="post" action="<?=base_admin();?>Kategori_write">
            <input type="text" name="kategori" placeholder="Nama kategori..." required>
            <input type="submit" value="Tambah kategori" class="btn btn-primary btn-flat" name="add_kategori">
        </form>
    </div><!-- /.box-header -->
    
    <div class="box-body table-responsive">
        <form method="post"  action="<?=base_admin();?>Blog_write">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data as $d){ ?>
                <tr>
                    <td><?=$d['nama'];?></td>
                    <td>
                        <a id="delete" class="btn btn-danger btn-sm" num="<?=$d['id'];?>" >Delete</a>
                    </td>
                </tr>   
            <?php } ?>
            
            </tbody>
            <tfoot>
                <tr>
                    <th>Nama kategori</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        
        </form>	
    </div><!-- /.box-body -->
</div>
<style>
</style>
<script src="<?=admin_asset();?>js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?=admin_asset();?>js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
            $(function() {
                $("#example2").dataTable();
                $("tr:odd").addClass('odd');
                $("tr:even").addClass('even');

                var del= $('a#delete');
                del.click(function(){
                    var id = $(this).attr('num');
                    if (confirm('Mau menghapus'+id+' ?')) {
	                    $.post('<?=base_admin();?>Kategori_write', 
	                        {delete: "delete", id: id},
	                        	function(data){alert('Kategori '+id+', telah terhapus'); location.reload();}
	                        );	
                    }
                });
            });
</script>