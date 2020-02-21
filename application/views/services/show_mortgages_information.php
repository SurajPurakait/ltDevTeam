<?php
$assigned_to = staff_info_by_id($referred_staff['referred_to']);
$requested_by = staff_info_by_id($referred_staff['referred_by']);

if ($mortgages_info['what_is_property_for'] == '1') {
	$what_is_property_for = 'Primary Residence';
} elseif ($mortgages_info['what_is_property_for'] == '2') {
	$what_is_property_for = 'Vacation or Secondary Home';
} elseif ($mortgages_info['what_is_property_for'] == '3') {
	$what_is_property_for = 'Investment Property';
}
?>
<div class="wrapper wrapper-content">
	<div class="ibox-content m-b-md m-t-15">
		<div class="row p-5 m-1 bg-warning">
			<div class="col-md-6">
				<p><b>Lead Type : </b><?= $mortgages_info['type_of_contact_name']; ?></p>
				<p><b>Lead Name : </b><?= $lead_details['first_name'].' '.$lead_details['last_name']; ?></p>
				<p><b>Lead Email : </b><?= $lead_details['email']; ?></p>
			</div>
			<div class="col-md-6 text-right">
				<div class="client-details">
					<p><b>Date :</b> <?= date('m-d-Y',strtotime($lead_details['referred_date'])); ?></p>
					<p><b>Assigned To :</b> <?= $assigned_to['first_name'].' '.$assigned_to['last_name']; ?></p>
					<p><b>Requested by :</b> <?= $requested_by['first_name'].' '.$requested_by['last_name']; ?></p>
				</div>
			</div>
		</div>
		<hr />
		<div class="table-responsive">
			<h3 class="m-b-25">Mortgages And Lending Information</h3>
			<table class="table table-striped table-bordered p-b-0 w-100">
				<tr>
					<td>Mortagage Status</td>
					<td><?= $mortgages_info['mortgage_status']; ?></td>
				</tr>
				<tr>
					<td>Type of Mortgage</td>
					<td><?= $mortgages_info['type_of_mortgage_name']; ?></td>
				</tr>
				<tr>
					<td>Purchase Price</td>
					<td><?= '$ ' . $mortgages_info['purchase_price']; ?></td>
				</tr>
				<tr>
					<td>What is Property For</td>
					<td>
						<?= $what_is_property_for; ?>
					</td>
				</tr>
				<tr>
					<td class="p-0">
						<table class="table table-bordered p-b-0 w-100 m-b-0">
							<tr>
								<td width="100px" class="text-center" style="vertical-align: middle;background: #e7eaec;">
									<b>Realtor</b>
								</td>
								<td>
									<table class="table table-hover table-bordered w-100 m-b-0">
										<tr>
											<td>
												Realtor Name
											</td>
										</tr>
										<tr>
											<td>
												Realtor Email
											</td>
										</tr>
										<tr>
											<td>
												Realtor Phone
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td class="p-0">
						<table class="table table-bordered p-b-0 w-100 m-b-0">
							<tr>
								<!-- <td width="100px" class="text-center" style="vertical-align: middle;background: #e7eaec;">
									<b><?//= ($mortgages_info['realtor'] == '1') ? 'Yes' : 'No'; ?></b>
								</td> -->
								<td>
									<table class="table table-hover table-bordered w-100 m-b-0">
										<tr>
											<td>
												<?= ($mortgages_info['realtor_name'] == '') ? 'N/A' : $mortgages_info['realtor_name']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?= ($mortgages_info['realtor_email'] == '') ? 'N/A' : $mortgages_info['realtor_email']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?= ($mortgages_info['realtor_phone'] == '') ? 'N/A' : $mortgages_info['realtor_phone']; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>