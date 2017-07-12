<!-- top navigation -->
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="public/template/production/images/img.jpg" alt=""><?=$data['username'];?>
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="javascript:;"> Profile</a></li>

						<li><a href="Login#/signin"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>

				
			</ul>
		</nav>
	</div>
</div><!-- /top navigation -->

<div class="right_col" role="main" ng-app="PersonApp">
	<div class="" ng-controller="MainCtrl">
		<div class="page-title">
			<div class="title_left">
				<h3>People Management </h3>
			</div>


		</div>

		<div class="clearfix"></div>

		<!-- Modals -->
		<div class="modal fade AddPersonModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Add New Person</h4>
					</div>
					<form class="form-horizontal form-label-left" name="CreateForm" ng-submit="SubmitCreateForm (CreateForm.$valid)">
						<div class="modal-body">

							<div ng-show="create_error" class="alert alert-danger alert-dismissible fade in" role="alert" style="text-shadow: none!important;">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>{{create_error}}</strong>
							</div>
							<div ng-show="create_success" class="alert alert-success alert-dismissible fade in" role="alert" style="text-shadow: none!important;">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>{{create_success}}</strong>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3" for="first_name">First Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" id="first_name" required="required" class="form-control col-md-7 col-xs-12" ng-model="first_name" required ng-required='true' >
								</div>
								<p ng-show="CreateForm.first_name.$invalid && !CreateForm.first_name.$pristine" class="help-block">Your first name is required.</p>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3" for="last_name">Last Name <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" id="last_name" name="last_name" required="required" class="form-control col-md-7 col-xs-12" ng-model="last_name" required ng-required='true' >
								</div>
								<p ng-show="CreateForm.last_name.$invalid && !CreateForm.last_name.$pristine" class="help-block">Your last name is required.</p>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3" for="language">Language <span class="required">*</span></label>
								<div class="col-md-7 col-xs-12">
									<select class="form-control" name="language" id="language" ng-model="language" required ng-required='true' >
										<option>Choose option</option>
										<option>English</option>
										<option>Afrikaans</option>
										<option>IsiZulu</option>
										<option>IsiXhosa</option>
									</select>
								</div>
								<p ng-show="CreateForm.language.$invalid && !CreateForm.language.$pristine" class="help-block">Your language is required.</p>

							</div>

							<div class="form-group">
								<label class="control-label col-md-3" for="single_cal1">Date of Birth <span class="required">*</span></label>
								<div class="col-md-7 col-xs-12">
									<div class="col-md-7 xdisplay_inputx form-group has-feedback">
										<input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder="Date of Birth" aria-describedby="inputSuccess2Status" ng-model="dob" required ng-required='true' >
										<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
										<span id="inputSuccess2Status" class="sr-only">(success)</span>
									</div>
								</div>
								<p ng-show="CreateForm.dob.$invalid && !CreateForm.dob.$pristine" class="help-block">Your date of birth is required.</p>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control" id="inputSuccess5" placeholder="Phone" ng-model="mobile" required ng-required='true' >
								<span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
								<p ng-show="CreateForm.mobile.$invalid && !CreateForm.mobile.$pristine" class="help-block">Your phone number is required.</p>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<input type="email" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email" ng-model="email" required ng-required='true' >
								<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
								<p ng-show="CreateForm.mobile.$invalid && !CreateForm.mobile.$pristine" class="help-block">Your email is invalid.</p>
							</div>

						</div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" ng-disabled="CreateForm.$invalid">Save</button>
						</div>
					</form>

				</div>
			</div>
		</div>
		<!-- /Modals -->

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target=".AddPersonModal">Add Person</button>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<!-- content -->
						<table 
						data-toggle="table"
						data-url="PeopleManagement/GetAllPeople"
						data-search="true"
						data-show-refresh="true"
						data-show-toggle="true"
						data-show-columns="true"
						data-toolbar="#toolbar"
						data-sort-name="queryDate"
						data-sort-order="desc"
						id="table-people"
						class="display table table-striped"
						data-row-style="rowStyle"

						data-show-pagination-switch="true"
						data-pagination="true"
						data-page-list="[10, 25, 50, 100, ALL]"
						data-show-export="true"
						data-export-options='
						{
						"fileName": "All People",
						"worksheetName": "People",
					}
					'
					>
					<thead>
						<tr>
							<th data-field="first_name" data-sortable="true">Firstname</th>
							<th data-field="surname" data-sortable="true">Surname</th>
							<th data-field="mobile" data-sortable="true">Mobile Number</th>
							<th data-field="email" data-sortable="true">Email</th>
							<th data-field="language" data-sortable="true">Language</th>
							<th data-field="date_of_birth" data-sortable="true">Date Of Birth</th>
							<th data-field="created" data-sortable="true">Created</th>
							<th data-field="buttons">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>