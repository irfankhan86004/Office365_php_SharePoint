<?php $selectedFolder = explode('/', $targetFolderUrl);
//dump($selectedFolder);exit;

$selectedFolder = !empty(end($selectedFolder)) ? end($selectedFolder) : 'Root/';
?>
<h3>File Save on this path: <?php echo $selectedFolder ;?></h3>
<input type='hidden' name='current_path' id='current_path' value='{{$targetFolderUrl}}'>
<div class='col-md-6'>
	<h2>Folders List </h2>
	<table class="table">
		<thead>
		  <tr>
			<th>Name</th>
			<th>Action</th>
		  </tr>
		</thead>
		<tbody>
			<?php foreach ($childFolder->getData() as $folder):
			
			//dump($folder);exit;
			?>
				<tr>
					<td><?php 
					//$folderName = str_replace('/sites/test/Shared Documents/', '', $folder->getProperty("ServerRelativeUrl")); 
					
					$folders = explode('/', $folder->getProperty("ServerRelativeUrl"));
					
					echo end($folders);
					?></td>
					<td><a href='javascript:void(0);' class='open_child' data-url='<?php echo $folder->getProperty("ServerRelativeUrl");?>'>Open</a></td>
				</tr>
			<?php endforeach;?>
			
		</tbody>
	</table>
</div>

<div class='col-md-6'>
	<h2>File List </h2>
	<table class="table">
	<thead>
	  <tr>
		<th>Name</th>
	  </tr>
	</thead>
	<tbody>
		<?php foreach ($files->getData() as $file):
		
		//dump($folder);exit;
		?>
			<tr>
				<td><?php 
				//$folderName = str_replace('/sites/test/Shared Documents/', '', $folder->getProperty("ServerRelativeUrl")); 
				
				$file = explode('/', $file->getProperty("ServerRelativeUrl"));
				
				echo end($file);
				?></td>
			</tr>
		<?php endforeach;?>
		
	</tbody>
	</table>
</div>	
		<script>
			
		$( ".open_child" ).click(function() {
			
			folderpath = $(this).attr('data-url');
			
			$.ajax({
				url: "{{ url('open_child') }}",
				type : 'POST',
				data: {folderpath: folderpath, _token : '{{ csrf_token() }}'},
				success:function(msg){

					$('#folder_list').html(msg); 
				}
			});
		});
		</script>