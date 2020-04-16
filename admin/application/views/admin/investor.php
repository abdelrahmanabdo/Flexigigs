<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-red-haze">
							<span data-counter="counterup" data-value="1349"><?=$total;?></span>
						</h3>
						<small> اجمالى المبلغ الكلى المستثمر</small>
				</div>
				<div class="icon">
					<i class="icon-like"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
                        <span class="sr-only">100% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-green-sharp">
							<span data-counter="counterup" data-value="7800"><?=$total-$invested?></span>
							<small class="font-green-sharp"></small>
						</h3>
						<small> الرصيد الحالى المتبقى </small>
				</div>
				<div class="icon">
					<i class="icon-users"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                        <span class="sr-only">100% progress</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-blue-sharp">
							<span data-counter="counterup" data-value="567">
				<?= $total_bonds; ?>				
							</span>
						</h3>
						<small> المبلغ المسترد </small>
				</div>
				<div class="icon">
					<i class="icon-basket"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp">
                        <span class="sr-only">100% grow</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-purple-soft">
							<span data-counter="counterup" data-value="276"><?=$total_bonds +($total-$invested)?></span>
						</h3>
						<small> المبلغ المتاح</small>
				</div>
				<div class="icon">
					<i class="icon-user"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">
                        <span class="sr-only">56% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="portlet light portlet-fit ">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-bubble font-dark"></i>
			<span class="caption-subject font-dark bold uppercase">قائمة العقود المشترك بها </span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th> # </th>
						<th> تاريخ العقد  </th>
						<th> المبلغ </th>
						<th> الأقساط المدفوعة </th>
						<th> الأقساط المتبقية </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> 1 </td>
						<td> Mark </td>
						<td> Otto </td>
						<td> makr124 </td>
						<td>
							<span class="label label-sm label-success"> Approved </span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
