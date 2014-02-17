<?php
$ajax  = admin_url('admin-ajax.php');
?>
<style>
.updating {
    background-color: #FFE0FF;
    border-color: #E6DB55;
    border-radius: 3px 3px 3px 3px;
    border-style: solid;
    border-width: 1px;
    margin: 5px 15px 2px;
    padding: 0 0.6em;
    display: block;
}
</style>
<form action="<?php echo $ajax; ?>" method="post" class="form-table" target="example-response" enctype="multipart/form-data">
<input type="hidden" name="action" value="formsubmit"/>
<h2><?php _e('Upload Data'); ?></h2>
<div id="example-response"></div>
<table cellpadding="5" cellspacing="5" class="widefat">

<tr><td><?php _e('Select Content Type'); ?></td>
<td>
<select name="contet_type" required>
<option value="">Select Content Type</option>
<?php
$post_types = get_post_types( '', 'names' ); 
foreach ( $post_types as $post_type ) {
if($post_type=='attachment' || $post_type=='revision' || $post_type=='nav_menu_item' )
continue;
?>
<option value="<?php echo $post_type; ?>"><?php echo ucfirst($post_type); ?></option>
<?php } ?>
</select>
</td></tr>
<tr><td><?php _e('Upload Csv'); ?></td>
<td><input type="file" name="csv_file" required></td>
</tr>
<tr><td></td><td> <input type="submit" value="Upload"/></td></tr>
</table>
</form>
