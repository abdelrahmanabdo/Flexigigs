<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-purple-soft">
							<span data-counter="counterup" data-value="276"><?= $total['total'] ?></span>
						</h3>
						<small> مبلغ القرض الكلى</small>
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
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-green-sharp">
							<span data-counter="counterup" data-value="7800"><?= $total['installment_numbers'] - $paid ?></span>
							<small class="font-green-sharp"></small>
						</h3>
						<small> عددالأقساط المتبقية</small>
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
						<h3 class="font-red-haze">
							<span data-counter="counterup" data-value="1349">
								<?= $paid ?></span>
						</h3>
						<small> عدد الأقساط المدفوعة</small>
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
						<h3 class="font-blue-sharp">
							<span data-counter="counterup" data-value="567"> <?= $total['percent'] ?> % </span>
						</h3>
						<small> النسبة المتفق عليها </small>
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
</div>
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
						<h3 class="font-purple-soft">
							<span data-counter="counterup" data-value="274"><?= $total['installment_next_date'] ?></span>
						</h3>
						<small>  تاريخ القسط القادم</small>
				</div>
				<div class="icon">
					<i class="icon-clock"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">
                        <span class="sr-only">54% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>
</div>