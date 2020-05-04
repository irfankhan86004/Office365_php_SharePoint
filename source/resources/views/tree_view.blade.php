<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Folders</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo asset("css/demo.css");?>" type="text/css">
		<link rel="stylesheet" href="<?php echo asset("css/zTreeStyle/zTreeStyle.css");?>" type="text/css">
		<script type="text/javascript" src="<?php echo asset("js/jquery-1.4.4.min.js");?>"></script>
		<script type="text/javascript" src="<?php echo asset("js/jquery.ztree.core.js");?>"></script>
        <!-- Styles -->
        <style>
            ul.ztree {
				
				width: 500px; 
			}
        </style>
		<SCRIPT type="text/javascript">
			<!--
			var setting = {
				async: {
					enable: true,
					url:"tree.php",
					autoParam:["id", "name=n", "level=lv"],
					otherParam:{"otherParam":"zTreeAsyncTest"},
					dataFilter: filter
				}
			};

			function filter(treeId, parentNode, childNodes) {
				if (!childNodes) return null;
				for (var i=0, l=childNodes.length; i<l; i++) {
					childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
				}
				return childNodes;
			}

			$(document).ready(function(){
				$.fn.zTree.init($("#treeDemo"), setting);
			});
			//-->
		</SCRIPT>
    </head>
    <body>
        <div class="container">
			<div class='row'>	
				<div class='col-md-12'>	
					<div class="zTreeDemoBackground left">
						<ul id="treeDemo" class="ztree"></ul>
					</div>
				</div>
			</div>
		</div>
    </body>
</html>
