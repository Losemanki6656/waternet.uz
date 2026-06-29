import {createI18n} from 'vue-i18n'
import uz from '@/locales/uz'
import ru from '@/locales/ru'
import en from '@/locales/en'

export const SUPPORTED_LOCALES = ['uz', 'ru', 'en']

const saved = localStorage.getItem('locale')
const initial = SUPPORTED_LOCALES.includes(saved) ? saved : 'uz'

const i18n = createI18n({
	legacy: false,
	globalInjection: true,
	locale: initial,
	fallbackLocale: 'uz',
	messages: {uz, ru, en}
})

document.documentElement.setAttribute('lang', initial)

export function setLocale(locale) {
	if (!SUPPORTED_LOCALES.includes(locale)) return
	i18n.global.locale.value = locale
	localStorage.setItem('locale', locale)
	document.documentElement.setAttribute('lang', locale)
}

export function getLocale() {
	return i18n.global.locale.value
}

export default i18n
