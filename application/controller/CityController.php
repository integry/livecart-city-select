<?php

ClassLoader::import('module.city-select.application.model.City');

/**
 *  @author Integry Systems
 */
class CityController extends FrontendController
{
	public function cities()
	{
		if (!$this->request->get('state'))
		{
			$cities = array();
		}
		else if ($state = State::getInstanceByID($this->request->get('state'), true))
		{
			$cities = City::getCitiesByState($state);
		}
		
		return new JSONResponse($cities);
	}
}

?>
