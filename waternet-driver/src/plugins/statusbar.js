import {Capacitor} from '@capacitor/core'
import {StatusBar, Style} from '@capacitor/status-bar'

// Make the WebView draw edge-to-edge so our gradient header reaches the very
// top of the screen (behind the status bar). Style.Dark = light/white status
// bar icons, which suits the dark-blue header. Safe-area padding in CSS keeps
// the header content below the status bar icons.
if (Capacitor.isNativePlatform()) {
	StatusBar.setOverlaysWebView({overlay: true}).catch(() => {})
	StatusBar.setStyle({style: Style.Dark}).catch(() => {})
}
