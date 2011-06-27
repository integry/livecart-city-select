<?php

ClassLoader::import('application.model.datasync.DataImport');
ClassLoader::import('application.model.user.User');
ClassLoader::import('application.model.user.UserAddress');
ClassLoader::import('module.city-select.application.model.City');

/**
 *  Handles city data import logic
 *
 *  @package application.model.datasync.import
 *  @author Integry Systems
 */
class CityImport extends DataImport
{
	public function getFields()
	{
		$this->loadLanguageFile('backend/User');
		$this->loadLanguageFile('backend/UserGroup');

		foreach (ActiveGridController::getSchemaColumns('City', $this->application) as $key => $data)
		{
			$fields[$key] = $this->translate($data['name']);
		}
		
		unset($fields['City.ID']);
		
		$fields['State.countryID'] = $this->translate('State.countryID');
		$fields['State.name'] = $this->translate('State.name');
		$fields['State.code'] = $this->translate('State.code');
		
		return $this->getGroupedFields($fields);
	}

	public function isRootCategory()
	{
		return false;
	}

	protected function getInstance($record, CsvImportProfile $profile)
	{
		$fields = $profile->getSortedFields();
		if (isset($fields['City']['code']))
		{
			$instance = ActiveRecordModel::getRecordSet('City', eq('City.code', $record[$fields['City']['code']]))->shift();
		}

		if (!isset($instance))
		{
			if (!isset($fields['State']['countryID']))
			{
				return;
			}
			
			if (isset($fields['State']['code']))
			{
				$f = select(eq('State.code', $record[$fields['State']['code']]));
			}
			else if (isset($fields['State']['name']))
			{
				$f = select(eq('State.name', $record[$fields['State']['name']]));
			}
			else
			{
				return;
			}

			$f->mergeCondition(eq('State.countryID', $record[$fields['State']['countryID']]));
			$owner = ActiveRecordModel::getRecordSet('State', $f)->shift();
			
			if (!$owner)
			{
				return;
			}
		}

		if (empty($instance))
		{
			if (empty($owner))
			{
				return;
			}

			$instance = City::getNewInstance($owner);
		}

		return $instance;
	}
}

?>
