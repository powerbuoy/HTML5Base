App.plugins.AjaxForm = {
	init: function () {
		var forms = document.querySelectorAll('form.ajax');

		for (var i = 0; i < forms.length; i++) {
			this.ajaxForm(forms[i]);
		}
	}, 

	ajaxForm: function (form) {
		var self = this;

		form.addEventListener('submit', function (e) {
			var form = this;

			e.preventDefault();

			// Remove error/success classes - set loading
			form.classList.remove('error');
			form.classList.remove('success');
			form.classList.add('loading');

			// Remove potential old message
			var oldMessage = form.parentNode.querySelector('p.form-message');

			if (oldMessage) {
				oldMessage.parentNode.removeChild(oldMessage);
			}

			// Remove potential old error messsages
			var errorMessages = form.querySelectorAll('strong.error');

			for (var i = 0; i < errorMessages.length; i++) {
				errorMessages[i].parentNode.removeChild(errorMessages[i]);
			}

			// Check potential captcha
			var captcha = document.querySelector('div.captcha');

			if (captcha) {
				if (!grecaptcha.getResponse(captcha.getAttribute('captcha-data-widget-id'))) {
					var errorMsg = document.createElement('strong');

					errorMsg.classList.add('error');
					errorMsg.innerHTML = 'Please verify that you are human';

					captcha.parentNode.appendChild(errorMsg);

					return;
				}
			}

			// AJAX the form away
			self.ajax({
				method:		form.method, 
				url:		form.action, 
				data:		self.serialize(form), 
				callback:	function (data) {
					var data = JSON.parse(data);

					form.classList.remove('loading');

					// Success! Do cool stuff
					if (data.success) {
						form.classList.add('success');
						form.reset();
					}
					// The backend returned an error
					else {
						form.classList.add('error');
					}

					// The backend returned a message - display it
					if (data.msg && data.msg.length) {
						var newMessage = document.createElement('p');

						newMessage.classList.add('form-message');
						newMessage.innerHTML = data.msg;

						form.parentNode.insertBefore(newMessage, form);
					}

					// The backend returned errors - display them
					if (data.errors) {
						for (var fieldName in data.errors) {
							var strong = document.createElement('strong');
							var field = fieldName == 'captcha' ? form.querySelector('div.captcha') : form.querySelector('[name="' + fieldName + '"]');

							strong.classList.add('error');
							strong.innerHTML = data.errors[fieldName];

							if (field) {
								field.parentNode.insertBefore(strong, field.nextSibling);
							}
						}
					}
				}
			});
		});
	}, 

	// Or maybe : https://developer.mozilla.org/en-US/docs/DOM/XMLHttpRequest/Using_XMLHttpRequest
	ajax: function (conf, updateID) {
		// Create config
		var config = {
			method:		conf.method || 'get', 
			url:		conf.url, 
			data:		conf.data || '', 
			callback:	conf.callback || function (data) {
				if (updateID) {
					document.getElementById(updateID).innerHTML = data;
				}
			}
		};

		// Create ajax request object
		var xhr = new XMLHttpRequest();

		// This runs when request is complete
		var onReadyStateChange = function () {
			if (xhr.readyState == 4) {
				config.callback(xhr.responseText);
			}
		};

		// Send the request
		if (config.method.toUpperCase() == 'POST') {
			xhr.open('POST', config.url, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.onreadystatechange = onReadyStateChange;
			xhr.send(config.data);
		}
		else {
			xhr.open('GET', config.url + '?' + config.data, true);
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.onreadystatechange = onReadyStateChange;
			xhr.send(null);
		}
	},

	// https://code.google.com/p/form-serialize/
	serialize: function (form) {
		if (!form || form.nodeName !== "FORM") {
			return;
		}

		var i, j, q = [];

		for (i = form.elements.length - 1; i >= 0; i = i - 1) {
			if (form.elements[i].name === "") {
				continue;
			}

			switch (form.elements[i].nodeName) {
				case 'INPUT':
					switch (form.elements[i].type) {
						case 'text':
						case 'hidden':
						case 'password': 
						case 'search': 
						case 'email': 
						case 'url': 
						case 'tel': 
						case 'number': 
						case 'date': 
						case 'month': 
						case 'week': 
						case 'time': 
						case 'datetime': 
						case 'datetime-local': 
						case 'color': 
						case 'button':
						case 'reset':
						case 'submit':
							q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
						break;

						case 'checkbox':
						case 'radio':
							if (form.elements[i].checked) {
								q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
							}
						break;

						case 'file':
						break;
					}
				break;			 

				case 'TEXTAREA':
					q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
				break;

				case 'SELECT':
					switch (form.elements[i].type) {
						case 'select-one':
							q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
						break;

						case 'select-multiple':
							for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1) {
								if (form.elements[i].options[j].selected) {
									q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].options[j].value));
								}
							}
						break;
					}
				break;

				case 'BUTTON':
					switch (form.elements[i].type) {
						case 'reset':
						case 'submit':
						case 'button':
							q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
						break;
					}
				break;
			}
		}

		return q.join("&");
	}
};