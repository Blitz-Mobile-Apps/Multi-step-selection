<?php
do_action('lms_scripts');
global $wpdb;
$tablename=$wpdb->prefix.'dynamic_type';
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
	$data = $wpdb->get_results('SELECT * FROM '.$tablename.' WHERE type = "'.$_GET['get'].'" ');
}else{
	$data = $wpdb->get_results('SELECT * FROM '.$tablename.' ');
}



?>
<style>
tr.table-primary ul li {
display: inline-block;
margin-right: 15px;
}
</style>
<div class="card mb-3 booking-main-form">
	<h3 class="card-header">Types</h3>
	<div class="card-body">
		<?php if (empty($_GET['edit'])) { ?>
		<form action="" method="post">
			<input type="hidden" name="insert" value="1">
			<fieldset>
				<legend>Add Types</legend>
				<div class="form-group row">
					<div class="col-md-6">
						<label class="col-form-label">Name</label>
						<input type="text" class="form-control-plaintext" name="name">
					</div>
					<div class="col-md-6">
						<label class="col-form-label">Order</label>
						<input type="number" class="form-control-plaintext" name="order">
					</div>
				</div>
				<br>
				<button type="submit" class="btn btn-primary">Submit</button>
			</fieldset>
		</form>
		<?php }  ?>
		<?php if (isset($_GET['edit'])) {
				$row = $wpdb->get_row('SELECT * FROM '.$tablename.' WHERE id="'.urldecode($_GET['id']).'" ');
		?>
		<form action="" method="post">
			<input type="hidden" name="update" value="1">



			<fieldset>
				<legend>Add Types</legend>
				<div class="form-group row">
					<div class="col-md-6">
						<label class="col-form-label">Name</label>
						<input type="text" class="form-control-plaintext" name="name" value="<?php echo $row->name; ?>">
					</div>
					<div class="col-md-6">
						<label class="col-form-label">Order</label>
						<input type="number" class="form-control-plaintext" name="order" value="<?php echo $row->order; ?>">
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
	<h3 class="card-header">View Types</h3>
	<div class="card-body">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Name</th>
					<th scope="col">Order</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 1;
				foreach($data as $row): ?>
				<tr class="table-active">
					<td><?php echo $i; $i++;?></td>
					<td><?php echo $row->name;?></td>
					<td><?php echo $row->order;?></td>
					<td><a href="?page=cs_Types&edit=true&id=<?php echo $row->id; ?>" class="btn btn-primary btn-sm">Edit</td>
					<td><a href="?page=cs_Types&delete=<?php echo $row->id; ?>" class="btn btn-primary btn-sm">Delete</a></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>