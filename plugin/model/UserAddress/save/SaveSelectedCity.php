<?php

ClassLoader::import('module.city-select.application.model.City');

class SaveSelectedCity extends ModelPlugin
{
	public function process()
	{
		$city = $this->object->getField('city')->get();
		if (is_numeric($city))
		{
			$loaded = City::getInstanceById($city);
			$this->object->getField('cityID')->set($loaded);
			$this->object->getField('city')->set($loaded->name->get());
			$this->object->save();
		}
	}
}

?>
