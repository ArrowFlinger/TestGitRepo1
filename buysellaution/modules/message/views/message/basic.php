<ul id="message" class="<?php echo $message->type.'_msg'; ?>">
<?php
	if( is_array( $message->message ) ):
		foreach( $message->message as $msg ): ?>
	<li><p><?php echo $msg; ?><p></li>
<?php
		endforeach;
	else: ?>
	<li><p><?php echo $message->message; ?></p></li>
<?php endif; ?>
</ul>
