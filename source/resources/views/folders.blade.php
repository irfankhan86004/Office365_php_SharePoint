<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Folders</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
			
			<div class='row'>
				<div class='col-md-6'>
					<input type='file' name='file' id='file' value=''>
					<a href='javascript:void(0);' id='upload_file'>Upload</a>
				</div>	
			</div>	
			<div class='row'>	
						
					<div id='folder_list'>
						
 						@include('_folders')
					</div>
			</div>
		</div>
		
		<script>
			
		$( "#upload_file" ).click(function() {
				
			var formData = new FormData();
			formData.append('file', $('#file')[0].files[0]);
			formData.append('_token', "{{ csrf_token() }}");
			formData.append('current_path', $('#current_path').val());
			
			$.ajax({
				url : "{{ url('/upload_file')}}",
				type : 'POST',
				data : formData,
				processData: false,  // tell jQuery not to process the data
				contentType: false,  // tell jQuery not to set contentType
				success : function(data) {
					
					
					alert('file uploaded');		
				}
			});	
		});
		</script>
    </body>
	
	
</html>
