<? session_unset(); ?>
<script type="text/javascript">
	
	function submit(ev)
	{
		var proceed = true;
	
		for(var i = 0; i < this.length; i++){
			if(this[i].type == "text")
				if(!validateField(this)[i])
					proceed = false;
		}
		if(!proceed)
			ev.preventDefault();
	}
	function validateField(input)
	{

		input.className = input.className.replace(/ok|bad/,"");
		if(input.className.match("number"))
			result = !isNaN(parseFloat(input.value));
		else
			result = (input.value.length > 0);
		if(result)
			input.className +=  " ok";
		else{
			input.className += " bad";
		}
		return result;
	}
	window.onload = function()
	{
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
			if(inputs[i].type == "text")
				inputs[i].onblur = function(){ validateField(this)};
		var e = document.getElementById("form").onsubmit = function(){ submit();};
	};
</script>
<style>
td{
	border:1px solid black;
}
.ok{
	border:2px solid green;
}
.bad{
	border: 2px solid red;
}
</style>
<div class="textbox">
	<a href="?context=<?php echo $context; ?>"><?php echo "$context index";  ?></a>
</div>
<?php if($action == "edit" || $action == "new"){ ?>
	<form  id="form" name="form" action="<?php echo "?context=$context&id=" . $object->id; ?>" method="post">
<?php } ?>
	<table>
		<?php foreach($context::$defs as $key => $val){ ?>	
			<?php if($key != "id") {?>
			<tr>
				<td><?php echo $key ?></td>
				<td>
				<?php if ($action == "show") { ?>
					<?php echo $object->$key; ?>
				<?php }else{ ?>
					<input class="<?php echo $context::$defs[$key]; ?>" type="text" name="form[<?php echo $key; ?>]" value="<?php echo $object->$key; ?>" />
				<?php } ?>
				</td>
			</tr>
			<?php } ?>
		<?php } ?>
		<?php if($action == "edit" || $action == "new"){ ?>
			<tr>
				<td colspan=2><input type="submit" value="<?php echo $action; ?>"/></td>
			</tr>
		<?php } ?>
	</table>
<?php if($action == "edit" || $action == "new"){ ?>
</form>
<?php } ?>