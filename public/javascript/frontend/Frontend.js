User.StateSwitcher.prototype.originalinitialize = User.StateSwitcher.prototype.initialize;
User.StateSwitcher.prototype.initialize = function(countrySelector, stateSelector, stateTextInput, url)
{
	this.originalinitialize(countrySelector, stateSelector, stateTextInput, url);
	Event.observe(window, 'load', this.updateCities.bind(this));
}

User.StateSwitcher.prototype.originalupdateStatesComplete = User.StateSwitcher.prototype.updateStatesComplete;
User.StateSwitcher.prototype.updateStatesComplete = function(ajaxRequest)
{
	this.originalupdateStatesComplete(ajaxRequest);
	this.updateCities();
}

User.StateSwitcher.prototype.updateCities = function()
{
	if (!this.getCitySelector())
	{
		return;
	}
	
	this.citySelector.length = 0;
	new LiveCart.AjaxRequest(Router.createUrl('city', 'cities', {state: this.stateSelector.value}), null, this.updateCitiesComplete.bind(this));
}

User.StateSwitcher.prototype.updateCitiesComplete = function(ajaxRequest)
{
	eval('var states = ' + ajaxRequest.responseText);

	if (Object.keys(states).length)
	{
		this.citySelector.options[this.citySelector.length] = new Option('', '', true);
	}

	Object.keys(states).each(function(key)
	{
		if (!isNaN(parseInt(key)))
		{
			this.citySelector.options[this.citySelector.length] = new Option(states[key], key, false);
		}
	}.bind(this));

	if (states.length)
	{
		this.citySelector.focus();
	}

	if (this.indicator)
	{
		Element.hide(this.indicator);
	}
	
	if (this.citySelector.getAttribute('initialValue'))
	{
		var value = this.citySelector.getAttribute('initialValue');
		if (parseInt(value))
		{
			this.citySelector.value = value;
		}
		else
		{
			$A(this.citySelector.options).each(function(opt)
			{
				if (opt.innerHTML == value)
				{
					this.citySelector.value = opt.value;
				}
			}.bind(this));
		}

		this.citySelector.setAttribute('initialValue', '');
	}	
}

User.StateSwitcher.prototype.getCitySelector = function()
{
	if (!this.citySelector)
	{
		this.citySelector = $(this.stateSelector.form).down('select.city');
		this.stateSelector.onchange = this.updateCities.bind(this);
	}
	
	return this.citySelector;
}
