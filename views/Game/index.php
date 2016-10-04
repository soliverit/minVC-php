
<table>
	<tr>
		<td>Name</td>
		<td>Description</td>
	</tr>
	<?php for($i = 0; $i < count($collection); $i++){ ?>
	<tr>
		<td><?php echo $collection[$i]->Name ?></td>
		<td><?php echo $collection[$i]->Description ?></td>
		<td><a href="<?php echo "?context=Game&id=". $collection[$i]->id ?>">View</a></td>
		<td><a href="<?php echo "?context=Game&edit=true&id=". $collection[$i]->id ?>">Edit</a></td>
	</tr>
	<?php } ?>
</table>
