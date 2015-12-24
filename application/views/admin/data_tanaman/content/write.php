<head>

<?php 
$article = "The article here..";
$id = $nama = $kategori='';
$token = 'add';
if ($this->session->flashdata('token')=="edit") {
	$token='edit';
	$id = $this->session->flashdata('id');
?>
	<title>Edit Data Tanaman</title>
<?php
}else{
?>
	<title>Input Data Tanaman</title>
<?php
}
if($this->session->flashdata('pesan')){
	echo "<script>alert('".$this->session->flashdata('pesan')."');</script>";
	$nama = $this->session->flashdata('nama');
	$kategori = $this->session->flashdata('kategori');
	$article = $this->session->flashdata('article');
}
?>
	
	<link href="<?=admin_asset();?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="<?=admin_asset();?>js/jquery.min.js"></script>
    <script src="<?=admin_asset();?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
</head>
<script src="<?=admin_asset();?>js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?=admin_asset();?>js/plugins/ckeditor/adapters/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
CKEDITOR.disableAutoInline = true;
	$( document ).ready(function() {
		CKEDITOR.replace( 'editor1', {
			toolbar : [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', 'Print', '-', 'Templates' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
				{ name: 'editing', groups: [ 'find', 'selection' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-'] },
				{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
				'/',
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
				{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
				{ name: 'insert', items: [ '-' ] },
				'/',
				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
				{ name: 'others', items: [ '-' ] },
				{ name: 'about', items: [ 'About' ] }
			]

		});
});
	
</script>
<div class='col-md-12'>
	<div class='box box-warning'>
		<?= form_open_multipart('admin/Tanaman_write');?>
		

		<div class='box-header pad md-5'>
			<div class="form-group" style="margin-top:10px; margin-bottom:0; max-width:768px">
                <label for="Nama">Nama tanaman</label>
                <input type="text"  name="nama" placeholder="Post Title" autocomplete="off" id="Nama" class="form-control" value="<?=$nama;?>" >
            </div>

			<div class="form-group" style="margin-top:10px; margin-bottom:0; max-width:768px">
                <label for="Kategori">Kategori</label>
            	<select class="form-control" id="Kategori" name="kategori">
            		<?php 
            		foreach ($data as $d) {
            			if ($kategori!='' && $kategori==$d['nama']) {
            		?>
							<option value="<?= $d['nama'];?>" selected="selected"><?= $d['nama'];?> </option>	            			
            		<?php
            			}else{
            		?>
            				<option value="<?= $d['nama'];?>" ><?= $d['nama'];?></option>	
            		<?php
            			}
            		}
            		?>
            		
            		
            	</select>
            </div>
            <div class="form-group">
                <label for="Pic1">Gambar 1</label>
                <input id="Pic1" type="file" name="userfile">
            </div>
<!-- 
            <div class="form-group">
                <label for="Pic2">Gambar 2</label>
                <input id="Pic2" type="file" name="pic2">
            </div> -->

            <div class='box-body pad'>
				<input type="submit" name="submit" value="Save" class="btn btn-success">
			</div>
				<input type="hidden" name="status" value="<?= $token;?>" />
				<input type="hidden" name="id" value="<?= $id;?>" />
			<br>
		</div><!-- /.box-header -->
		
		<div class='box-body pad md-5'>
				<textarea id="editor1" name="editor1" rows="10" cols="80">
					<?=$article;?>
				</textarea>       
		</div>
		
		</form>
	</div>
	<!-- /.box -->
</div>