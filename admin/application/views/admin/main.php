<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2 ">
			<div class="display">
				<div class="number">
                   <a href="<?=base_url()?>admin/customers">
					<h3 class="font-green-sharp">
						<span data-counter="counterup" data-value="7800"><?=get_count_all('services',null);?></span>
						<small class="font-green-sharp"></small>
					</h3>
					<small>الخدمات</small></a>
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
                   <a href="<?=base_url()?>admin/orders">
					<h3 class="font-red-haze">
						<span data-counter="counterup" data-value="1349"><?=get_count_all('requests',null);?></span>
					</h3>
					<small>طلبات العملاء</small></a>
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
                    <a href="<?=base_url()?>creator/contracts">
					<h3 class="font-blue-sharp">
						<span data-counter="counterup" data-value="567">
                            <?=get_count_all('users');?></span>
					</h3>
					<small>العملاء</small></a>
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
                    <a href="<?=base_url()?>admin/investor">
					<h3 class="font-purple-soft">
						<span data-counter="counterup" data-value="276"><?=get_count_all('categories');?></span>
					</h3>
					<small>الأقسام</small></a>
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