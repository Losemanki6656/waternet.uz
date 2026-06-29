import {Capacitor} from '@capacitor/core'
import {StatusBar, Style} from '@capacitor/status-bar'

// Keep the WebView BELOW the status bar (no overlay) and paint the native
// status bar the same solid blue as the header. The status bar then reads as a
// seamless extension of the header instead of overlapping the content — and
// the header keeps its normal (web) height.
const STATUS_BAR_COLOR = '#1D4ED8'

if (Capacitor.isNativePlatform()) {
	StatusBar.setOverlaysWebView({overlay: false}).catch(() => {})
	StatusBar.setStyle({style: Style.Dark}).catch(() => {})
	StatusBar.setBackgroundColor({color: STATUS_BAR_COLOR}).catch(() => {})
}
