<?php
if($this->session->flashdata('pesan'))
    echo "<script>alert('".$this->session->flashdata('pesan')."');</script>";

if($this->session->flashdata('upload'))
    echo "<script>alert('".$this->session->flashdata('upload')."');</script>";
if (isset($_POST['edit'])) {
    $_POST['edit'] =$_POST['edit'];
    $_POST['id'] = $_POST['id'];
    redirect('admin/Blog_write');
}
                     
?>
<link href="<?=admin_asset();?>css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<div class="box">
    <div class="box-header" style="padding:10px 0 0 10px">
        <a id="multi_del" class="btn btn-default btn-flat" 
            onclick="alert('Maaf fungsi ini belum befungsi\nSilahkan menggunakan tombol di samping data');">Delete
        </a>
        <a href="<?=base_url();?>admin/data_tanaman/write" class="btn btn-default btn-flat">Tambah data baru</a>
    </div><!-- /.box-header -->
    
    <div class="box-body table-responsive">
        <form method="post"  action="<?=base_admin();?>Tanaman_write">
        <table id="DataTanaman" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Tanaman</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $no=0;
                foreach($data as $d){ 

            ?>
                <tr>
                    <td><?=++$no;?></td>
                    <td><?=$d['nama'];?></td>
                    <td><?=$d['kategori'];?></td>
                    <td><?php
                        if ($d['deskripsi']) {
                            echo "Sudah ada.....";
                        }
                    ?></td>
                    <td>
                        <?php 
                            if($d['pic1'] != '') echo $d['pic1'];
                            if($d['pic2'] != '') echo $d['pic2'];
                            if ($d['pic1']==''&& $d['pic2']=='') {
                                echo "Gambar belum ada";
                            }
                        ?> 
                    </td>
                    <td>
                        <a class="view btn btn-warning btn-sm" href="<?=base_url().'home/'.$d['kategori'] .'/'.$d['id'];?>" target="blank">View</a>
                        <a  class="edit btn btn-info btn-sm"  num="<?=$d['id'];?>" >Edit</a>
                        <a  class="delete btn btn-danger btn-sm" num="<?=$d['id'];?>" >Delete</a>
                    </td>
                </tr>   
            <?php } ?>
      
            
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nama Tanaman</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th></th>
            </tfoot>
        </table>
        
        </form>	
    </div><!-- /.box-body -->
</div>
<!-- 
    <form id="edit_form" method="POST" action="" style="">
        <input name="id" value="" type="text" >
        <input name="edit" type="submit">
    </form> -->
<style>
    #edit_form{display: none}
    #edit_form.pop{display: block; position: fixed; top: 0; width: 100%; height: 100%; background: white; left: 0; z-index: 999999}
</style>
<script src="<?=admin_asset();?>js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?=admin_asset();?>js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
            $(function() {
                $("#DataTanaman").dataTable();
                $("tr:odd").addClass('odd');
                $("tr:even").addClass('even');

                // Click buttons
                var view = $('a.view'),
                    edit = $('a.edit'),
                    del= $('a.delete');
                view.click(function(){
                    
                });

                del.click(function(){
                    var id = $(this).attr('num');
                    $.post('<?=base_admin();?>Tanaman_write', 
                        {delete: "delete", id: id},
                        function(data){alert('Data telah terhapus\n'+data); location.reload();}
                        );
                });

                edit.click(function(){
                    var id = $(this).attr('num');

                    $.post('<?=base_admin();?>Tanaman_write', 
                        {edit: "edit", id: id},
                            function(data){
                                window.location = "<?=base_admin();?>data_tanaman/write";
                            }
                        );
                });

            });
</script>