<?php

function valid_isPass($value)
{
	if (!preg_match('^[0-9a-zA-Z]{5,16}^', $value))
	{
		return false;
	}

	return true;
}
