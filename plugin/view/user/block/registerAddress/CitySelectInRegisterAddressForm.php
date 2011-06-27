<?php

class CitySelectInRegisterAddressForm extends ViewPlugin
{
	public function process($source)
	{
		$source = preg_replace('/\{\{label \{t _city\}:\}\}.*\{textfield class="text"\}/msU', '{{label {t _city}:}} {selectfield class="city"}', $source);
		preg_match('/\{if \$fields\.CITY\}.*\{\/if\}/msU', $source, $match);
		$field = array_shift($match);
		$source = str_replace($field, '', $source);
		$source = str_replace('{if $fields.POSTALCODE}', $field . '{if $fields.POSTALCODE}', $source);

		return $source;
	}
}

?>