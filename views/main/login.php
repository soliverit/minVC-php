
<html>
	<head>
	<script type="text/javascript">

	
	function submit(input)
	{
		if(input.user.value == ''){
			input.user.focus();
			return false;
		}else if(input.password.value == ''){
			input.password.focus();
			return false;
		}
		return true;	
	}
	window.onload = function()
	{
		var e = document.getElementById("form").onsubmit = function(ev)
		{
			if(! submit(ev.target))
				ev.preventDefault();
		};
	};

	</script>
		<style>
			td{
				width:200px;
				height:35px;
			}
		</style>
	</head>
	<body>
		<div id="loginBox">
			<?php if(isset($msg)){ ?>
				<div id="msg"><?php echo $msg; ?></div>
			<?php } ?>
		</div>
		<form id="form" action="" method="post" >
			<table>
				<tr>
					<td>Username</td>
					<td><input type="text" name="user"/></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password"/></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>