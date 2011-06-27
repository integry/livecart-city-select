<?php

ClassLoader::import('application.model.ActiveRecordModel');
ClassLoader::import('application.model.delivery.State');
ClassLoader::import('application.model.user.UserAddress');

/**
 *
 * @package application.model.product
 * @author Integry Systems <http://integry.com>
 */
class City extends ActiveRecordModel
{
	public static function defineSchema($className = __CLASS__)
	{
		$schema = self::getSchemaInstance($className);
		$schema->setName($className);

		$schema->registerField(new ARPrimaryKeyField("ID", ARInteger::instance()));
		$schema->registerField(new ARForeignKeyField("stateID", "State", "ID", null, ARInteger::instance()));
		$schema->registerField(new ARField("code", ARVarchar::instance(15)));
		$schema->registerField(new ARField("name", ARVarchar::instance(60)));

		$address = self::getSchemaInstance('UserAddress');
		$address->registerField(new ARForeignKeyField("cityID", "City", "ID", null, ARInteger::instance()));
		$address->registerAutoReference('cityID');
	}

	public static function getNewInstance(State $state, $name = '')
	{
		$instance = parent::getNewInstance(__CLASS__);
		$instance->state->set($state);
		$instance->name->set($name);
		return $instance;
	}

	public static function getInstanceById($id)
	{
		return parent::getInstanceById(__CLASS__, $id, self::LOAD_DATA);
	}
	
	public static function getCitiesByState(State $state)
	{
		$f = new ARSelectFilter();
		$f->setOrder(new ARFieldHandle('City', 'name'));
		$cityArray = $state->getRelatedRecordSetArray('City', $f);

		$cities = array();
		foreach ($cityArray as $city)
		{
			$cities[$city['ID']] = $city['name'];
		}

		return $cities;
	}
}

?>
