<?php
function asset($identifier) {
	return \App\Contract\Asset::get($identifier);
}
?>