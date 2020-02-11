<?php
do_action('lms_scripts');
wp_enqueue_media();
global $wpdb;

$tablename=$wpdb->prefix.'dynamic_form';
$tablename2=$wpdb->prefix.'dynamic_type';

if (isset($_POST['insert'])) {
	unset($_POST['insert']);
	$wpdb->insert( $tablename, $_POST);
}
if (isset($_GET['delete'])) {
	$wpdb->delete( $tablename, [ 'id' => $_GET['delete']] );
}
if (isset($_POST['update'])) {
	unset($_POST['update']);
	$wpdb->update( $tablename, $_POST, array( 'id' => $_GET['id'] ));
}

if (!empty($_GET['get'])) {

	$data  = $wpdb->get_results('
		SELECT 
		a.id,a.title,a.discription,a.benefits,a.img,a.data,a.price,
		b.name as type
		FROM '.$tablename.' AS a
		INNER JOIN `'.$tablename2.'` AS `b` ON ( `b`.`id` = `a`.`type` )
		WHERE a.type = "'.$_GET['get'].'" 
		');

}else{



$data  = $wpdb->get_results('
SELECT 
	a.id,a.title,a.discription,a.benefits,a.img,a.data,a.price,
	b.name as type
	FROM '.$tablename.' AS a
	INNER JOIN `'.$tablename2.'` AS `b` ON ( `b`.`id` = `a`.`type` )
 ');





}

$tablename1=$wpdb->prefix.'dynamic_type';
$typedata = $wpdb->get_results('SELECT * FROM '.$tablename1.' ');

?>
<style>
	tr.table-primary ul li {
display: inline-block;
margin-right: 15px;
}
</style>
<div class="card mb-3 booking-main-form">
	<h3 class="card-header">Form Data</h3>
	<div class="card-body">
		<?php if (empty($_GET['edit'])) { ?>
		<form action="" method="post">
			<input type="hidden" name="insert" value="1">
			<fieldset>
				<legend>Add Data</legend>
				<div class="form-group row">
					<div class="col-md-12">
						<label class="col-form-label">Title</label>
						<input type="text" class="form-control-plaintext" name="title">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="col-form-label">Discription</label>
						<input type="text" class="form-control-plaintext" name="discription">
					</div>
					<div class="col-md-6">
						<label class="col-form-label">benefits</label>
						<input type="text" class="form-control-plaintext" name="benefits">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<br>
						<div class="imgappend"></div>	
						<input type="hidden" class="form-control-plaintext" name="img">
						<a href="javascript:;" class="btn btn-primary choosebtn">Choose Image</a>
					</div>
					<div class="col-md-6">
						<label class="col-form-label">Type</label>
						<select class="form-control" name="type">
							<option value="">Select Type</option>
							<?php if ($typedata): ?>
								<?php foreach ($typedata as $key): ?>
										<option value="<?php echo $key->id;  ?>"><?php echo $key->name;  ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>

						<label class="col-form-label">Price (optional)</label>
						<input type="text" class="form-control-plaintext" name="price">						
					</div>
				</div>
				<br>
				<button type="submit" class="btn btn-primary">Submit</button>
			</fieldset>
		</form>
		<?php }  ?>
		<?php if (isset($_GET['edit'])) {
				$row = $wpdb->get_row('SELECT * FROM '.$tablename.' WHERE id="'.$_GET['id'].'" ');
		?>
		<form action="" method="post">
			<input type="hidden" name="update" value="1">

			<fieldset>
				<legend>Add Data</legend>
				<div class="form-group row">
					<div class="col-md-12">
						<label class="col-form-label">Title</label>
						<input type="text" class="form-control-plaintext" name="title" value="<?php echo $row->title; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="col-form-label">Discription</label>
						<input type="text" class="form-control-plaintext" name="discription" value="<?php echo $row->discription; ?>">
					</div>
					<div class="col-md-6">
						<label class="col-form-label">benefits</label>
						<input type="text" class="form-control-plaintext" name="benefits" value="<?php echo $row->benefits; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<br>
						<?php 
						$thumbnail = wp_get_attachment_image_src($row->img,'medium', true);
						

						?>
						<div class="imgappend">
							<?php echo '<img src="'.$thumbnail[0].'" alt="" height="50" width="50" >'; ?>
						</div>	
						<input type="hidden" class="form-control-plaintext" name="img" value="<?php echo $row->img; ?>">
						<a href="javascript:;" class="btn btn-primary choosebtn">Choose Image</a>
					</div>
					<div class="col-md-6">
						<label class="col-form-label">Type</label>
						<select class="form-control" name="type">
							<option value="<?php echo $row->type; ?>"><?php echo $row->type; ?></option>
							<option value="Size">Size</option>
							<option value="Bases">Bases</option>
							<option value="Fruits & Berries"> Fruits & Berries</option>
							<option value="Flowers">Flowers</option>
							<option value="Roots & Seeds">Roots & Seeds</option>
							<option value="Herbs">Herbs</option>
							<option value="Spices">Spices</option>
							<option value="Chocolate & Natural Sweeteners">Chocolate & Natural Sweeteners</option>
							<option value="Extracts">Extracts</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="col-form-label">Price (optional)</label>
						<input type="text" class="form-control-plaintext" name="price" value="<?= $row->price;  ?>">	
					</div>
				</div>
				<br>
				<button type="submit" class="btn btn-primary">Submit</button>
			</fieldset>


		</form>

		<?php  }  ?>
		
	</div>
</div>

<div class="card mb-3 booking-table">
	<div class="card-body">
		<a href="?page=Dynamic_Form" class="btn btn-primary btn-sm">All</a>
		
		<?php if ($typedata): ?>
			<?php foreach ($typedata as $key): ?>
				<a href="?page=Dynamic_Form&get=<?php echo $key->id;  ?>" class="btn btn-primary btn-sm"><?php echo $key->name;  ?></a>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>


<div class="card mb-3 booking-table">
	<h3 class="card-header">View</h3>
	<div class="card-body">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Title</th>
					<th scope="col">Discription</th>
					<th scope="col">Benefits</th>
					<th scope="col">img</th>
					<td scope="col">Type</td>
					<td scope="col">Price</td>
					<th scope="col">Edit Coupon</th>
					<th scope="col">Delete Coupon</th>
				</tr>
			</thead>
			<tbody>
		

				<?php 
				$i = 1;
				if ($data):
				foreach($data as $row): ?>
				<tr class="table-active">
					<td><?php echo $i; $i++;?></td>
					<td><?php echo $row->title;?></td>
					<td><?php echo $row->discription;?></td>
					<td><?php echo $row->benefits;?></td>
					<td>
						<?php 
							$thumbnail = wp_get_attachment_image_src($row->img,'medium', true);
							echo '<img src="'.$thumbnail[0].'" alt="" height="50" width="50" >';
						 ?>
					</td>
					<td><?php echo $row->type;?></td>
					<td><?php echo $row->price;?></td>
					<td><a href="?page=Dynamic_Form&edit=true&id=<?php echo $row->id; ?>" class="btn btn-primary btn-sm">Edit</td>
					<td><a href="?page=Dynamic_Form&delete=<?php echo $row->id; ?>" class="btn btn-primary btn-sm">Delete</a></td>
				</tr>
				<?php endforeach;?>
				<?php else: ?>
					<tr>
						<td colspan="8" align="center">No Record Found!</td>
					</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<script>// ADD IMAGE LINK
jQuery(document).on('click', '.choosebtn', function( event ){
	event.preventDefault();

	var parent 		= jQuery('.imgappend');
	var inputField 	= jQuery('input[name="img"]');

	// Create a new media frame
	frame = wp.media({
		title: 'Select or Upload Media for Gallery',
		button: {
			text: 'Use this media'
		},
	multiple: false  // Set to true to allow multiple files to be selected
	});


// When an image is selected in the media frame...
frame.on( 'select', function() {

// Get media attachment details from the frame state
var attachment = frame.state().get('selection').first().toJSON();

	console.log(attachment);

// attachment.id; //89
// attachment.title; //osts57yu7em91yaeazvq
// attachment.filename; //osts57yu7em91yaeazvq.jpg
// attachment.url; //http://localhost/testwp/wp-content/uploads/2017/09/osts57yu7em91yaeazvq.jpg
// attachment.link; //http://localhost/testwp/obituary/obituary-for-dorothy-ann-leslie/osts57yu7em91yaeazvq/

inputField.val(attachment.id);
jQuery(parent).html('<img src="'+attachment.url+'" height="100" width="100" />');
});

// Finally, open the modal on click
frame.open();
});

//refrence link
//https://codex.wordpress.org/Javascript_Reference/wp.media
</script>