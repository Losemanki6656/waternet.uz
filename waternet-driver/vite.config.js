import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  // Relative base so the built assets load over file:// inside the Capacitor WebView.
  base: './',
  // Expose YANDEX_*-prefixed env vars (e.g. YANDEX_MAPS_KEY) to the client,
  // in addition to the default VITE_* ones.
  envPrefix: ['VITE_', 'YANDEX_'],
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
    // The codebase imports .vue components without an extension (e.g.
    // `@/components/AppLayout`), which Vite does not resolve by default.
    extensions: ['.mjs', '.js', '.mts', '.ts', '.jsx', '.tsx', '.json', '.vue'],
  },
  server: {
    port: 5174,
    host: true,
  },
  build: {
    outDir: 'dist',
  },
})
