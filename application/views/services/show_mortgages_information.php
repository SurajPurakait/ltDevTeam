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

if ($export_type == '') {

?>
	<div class="wrapper wrapper-content">
		<div class="ibox-content m-b-md m-t-15">
			<div class="mortgage_container">
				<div class="row p-5 m-1 bg-warning">
					<div class="col-md-6 m-info">
						<p><b>Type : </b><?= ($mortgages_info['type_of_contact_name'] != '') ? $mortgages_info['type_of_contact_name'] : 'N/A'; ?></p>
						<p><b>Name : </b><?= ($lead_details['first_name'] != '' && $lead_details['last_name'] != '') ? $lead_details['first_name'] . ' ' . $lead_details['last_name'] : 'N/A'; ?></p>
						<p><b>Email : </b><?= ($lead_details['email'] != '') ? $lead_details['email'] : 'N/A'; ?></p>
						<p><b>Phone : </b><?= ($lead_details['phone1'] != '') ? $lead_details['phone1'] : 'N/A'; ?></p>
					</div>
					<div class="col-md-6 text-right m-info">
						<div class="client-details">
							<p><b>Date :</b> <?= date('m-d-Y', strtotime($lead_details['referred_date'])); ?></p>
							<p><b>Assigned To :</b> <?= $assigned_to['first_name'] . ' ' . $assigned_to['last_name']; ?></p>
							<p><b>Submitted by :</b> <?= $requested_by['first_name'] . ' ' . $requested_by['last_name']; ?></p>
						</div>
					</div>
				</div>
				<hr />
				<div class="table-responsive">
					<h3 class="m-b-25 mortgage-heading">Mortgages And Lending Information</h3>
					<table class="table table-striped table-bordered p-b-0 w-100">
						<tr>
							<td style="width: 30%;"><b>Mortagage Status</b></td>
							<td><?= $mortgages_info['mortgage_status']; ?></td>
						</tr>
						<tr>
							<td style="width: 30%;"><b>Type of Mortgage</b></td>
							<td><?= $mortgages_info['type_of_mortgage_name']; ?></td>
						</tr>
						<tr>
							<td style="width: 30%;"><b>Purchase Price</b></td>
							<td><?= '$ ' . $mortgages_info['purchase_price']; ?></td>
						</tr>
						<tr>
							<td style="width: 30%;"><b>What is Property For</b></td>
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
														<b>Realtor Name</b>
													</td>
												</tr>
												<tr>
													<td>
														<b>Realtor Email</b>
													</td>
												</tr>
												<tr>
													<td>
														<b>Realtor Phone</b>
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
			<div class="row">
				<div class="col-md-12 text-center">
					<button class="btn bg-purple m-t-10 m-r-5" type="button" onclick="printMortgage();"><i class="fa fa-print"></i> Print</button>
					<button class="btn btn-warning m-t-10 m-r-5" type="button" onclick="go('services/partner_services/export/'+'<?= $reference ?>'+'/'+'<?= $reference_id ?>'+'/'+'<?= $lead_id ?>');"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
				</div>
			</div>
		</div>
	</div>

<?php
} else {
?>
	<div class="wrapper wrapper-content">
		<div class="ibox-content m-b-md m-t-15">
			<div class="mortgage_container">
				<table style="width: 100%; vertical-align: top;font-size:35px;" cellpadding="0" cellspacing="0">
					<hr>
					<h1 style="line-height: 5px;">Client Information</h1>
					<hr>
					<h1></h1>
					<tr>
						<td>
							<p><b>Type : </b><?= ($mortgages_info['type_of_contact_name'] != '') ? $mortgages_info['type_of_contact_name'] : 'N/A'; ?></p>
							<p><b>Name : </b><?= ($lead_details['first_name'] != '' && $lead_details['last_name'] != '') ? $lead_details['first_name'] . ' ' . $lead_details['last_name'] : 'N/A'; ?></p>
							<p><b>Email : </b><?= ($lead_details['email'] != '') ? $lead_details['email'] : 'N/A'; ?></p>
							<p><b>Phone : </b><?= ($lead_details['phone1'] != '') ? $lead_details['phone1'] : 'N/A'; ?></p>
						</td>

						<td>
							<p style="text-align: right;"><b>Date :</b> <?= date('m-d-Y', strtotime($lead_details['referred_date'])); ?></p>
							<p><b>Assigned To :</b> <?= $assigned_to['first_name'] . ' ' . $assigned_to['last_name']; ?></p>
							<p><b>Submitted by :</b> <?= $requested_by['first_name'] . ' ' . $requested_by['last_name']; ?></p>
						</td>
					</tr>
				</table>
				<h1></h1>
				<table style="width: 100%; vertical-align: top;font-size:35px;" cellpadding="0" cellspacing="0">						
					<hr><br>
					<h1 style="line-height: 5px;">Mortgages And Lending Information</h1>
					<hr>
					<h1></h1>
					<tr>
						<td>
							<p><b>Mortagage Status</b></p>
							<p><b>Type of Mortgage</b></p>
							<p><b>Purchase Price</b></p>
							<p><b>What is Property For</b></p>
						</td>
						<td>
							<p><?= $mortgages_info['mortgage_status']; ?></p>
							<p><?= $mortgages_info['type_of_mortgage_name']; ?></p>
							<p><?= '$ ' . $mortgages_info['purchase_price']; ?></p>
							<p><?= $what_is_property_for; ?></p>
						</td>
					</tr>
				</table>
				<h1></h1>
				<table style="width: 100%; vertical-align: top;font-size:35px;" cellpadding="0" cellspacing="0">	
					<hr><br>
					<h1 style="line-height: 5px;">Realtor Information</h1>
					<hr>
					<h1></h1>
					<tr>
						<td>
							<p><b>Realtor Name</b></p>
							<p><b>Realtor Email</b></p>
							<p><b>Realtor Phone</b></p>
						</td>
						<td>
							<p><?= ($mortgages_info['realtor_name'] == '') ? 'N/A' : $mortgages_info['realtor_name']; ?></p>
							<p><?= ($mortgages_info['realtor_email'] == '') ? 'N/A' : $mortgages_info['realtor_email']; ?></p>
							<p><?= ($mortgages_info['realtor_phone'] == '') ? 'N/A' : $mortgages_info['realtor_phone']; ?></p>
						</td>

					</tr>
				</table>
			</div>
			<div class="row">
				<div class="col-md-12 text-center" <?= ($export_type != '') ? 'style="display:none"' : ''; ?>>
					<button class="btn bg-purple m-t-10 m-r-5" type="button" onclick="printMortgage();"><i class="fa fa-print"></i> Print</button>
					<button class="btn btn-warning m-t-10 m-r-5" type="button" onclick="go('services/partner_services/export/'+'<?= $reference ?>'+'/'+'<?= $reference_id ?>'+'/'+'<?= $lead_id ?>');"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>