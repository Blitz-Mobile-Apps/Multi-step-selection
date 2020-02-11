<?php 
global $wpdb, $obj;
do_action('lms_scripts');
$results = $wpdb->get_results('
SELECT * FROM '.$wpdb->prefix.'dynamic_form_inquiries ');
?>

<div class="card mb-3">
	<h3 class="card-header">Custom Orders:</h3>
	<div class="card-body">
		<table class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>#</th>
					<th>Name Blend</th>
					<th>Message</th>
					<th>Amount</th>
					<th>Delivery Date</th>
					<th>Transaction ID</th>
					<th>Status</th>
					<th>Billing Details</th>
					<th>Order Details</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($results))  { ?>
				<?php $i =1; foreach ($results as $row_item): ?>
				<tr>
					<td><?php echo $i; $i++; ?></td>
					<td><?php echo $row_item->name_blend; ?></td>
					<td><?php echo $row_item->pers_msg; ?></td>
					<td><?php echo $row_item->amount; ?></td>
					<td><?php echo $row_item->delivery_date; ?></td>
					<td><?php echo $row_item->transaction_id; ?></td>
					<td><?php echo $row_item->status; ?></td>
					<td><a href="<?php echo site_url('/wp-admin/admin-ajax.php?action=booking_billing_detail&id='.$row_item->id); ?>" data-featherlight="ajax" class="btn btn-primary btn-sm">Billing Details</a></td>
					<td><a href="<?php echo site_url('/wp-admin/admin-ajax.php?action=booking_order_details&id='.$row_item->id); ?>" data-featherlight="ajax" class="btn btn-primary btn-sm">Order Details</a></td>
				</tr>
				<?php endforeach ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>