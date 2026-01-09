<div id="media-container">
	{{-- <form id="media-form" action="<?php //echo site_url(CN_BASE.'index'); 
										?>" method="POST">	 --}}
	<form id="media-form" action="{{route('admin.media-manager')}}" method="POST">

		<!-- control bar -->
		<div class="control-bar">
			<div class="btn-toolbar" role="toolbar" area-label="toolbar of media buttons">
				<div class="btn-group" role="group" area-label="show thumb" title="Thumbs View">
					<button type="button" id="thumbs" data-layout="thumbs" class="btn btn-sm btn-secondary btn-layout"><span class="fa fa-th-large"></span></button>
				</div>
				<div class="btn-group" role="group" area-label="show details" title="Details View">
					<button type="button" id="details" data-layout="details" class="btn btn-sm btn-secondary btn-layout"><span class="fa fa-list"></span></button>
				</div>
			</div>
		</div>
		<!-- /.control-bar -->
		<!-- thumbs view -->


		<div id="thumbs-layout" class="media-layout hidden-xs-up">
			<?php //$this->load->view('admin/gallery-manager/thumbs'); 
			?>
			@include("dashboard/gallery-manager/thumbs")

		</div>

		<!-- /.thumbs view -->
		<!-- details view -->
		<div id="details-layout" class="media-layout hidden-xs-up">
			@include("dashboard/gallery-manager/details")

			<?php //$this->load->view('admin/gallery-manager/details'); 
			?>
		</div>
		<div>

		</div>
		<!-- /.details view -->
		<input id="path" name="path" type="hidden" />
	</form>
</div>