import {Preferences} from '@capacitor/preferences';

window.$storage = {};

window.$storage.set = function setObject(key, value) {
	return Preferences.set({
		key: key,
		value: JSON.stringify(value)
	});
};


window.$storage.get = async function getObject(key) {
	let ret = await Preferences.get({key: key})

	return JSON.parse(ret.value);
};

window.$storage.remove = async function removeObject(key) {
	await Preferences.remove({ key: key });
};
