<?php

ClassLoader::import('module.city-select.application.model.City');

class RegisterCitySelector extends ProcessPlugin
{
	public function process()
	{
		City::getSchemaInstance('City');
		City::defineSchema();
	}
}

?>
