<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

// $messages = $this->session->userdata('messages');
?>
<div id="notifications">
	<?php
	 if($this->session->flashdata('msg')){ ?>
<div class="alert alert-success alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<p><?php echo $this->session->flashdata('msg'); ?></p>
</div>
	 <?php }

	if(!empty($messages)) 
	{
		foreach ($messages as $message) 
		{	
			if ($message['type'] == 'error') 
			{
				$message['type'] = 'danger';
			}
			?>
			<div class="alert alert-<?php echo $message['type']; ?> alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p><?php echo $message['message']; ?></p>
			</div>
			<?php
		}
	}
	?>
</div>
<?php
$this->session->unset_userdata('messages');