import { App } from 'vue'
import { usePage } from '@inertiajs/vue3'

// Global translation function
export function useTranslation() {
  const page = usePage()
  
  const t = (key: string, fallback?: string) => {
    const translations = page.props.translations || {}
    return translations[key] || fallback || key
  }
  
  return { t }
}

// Vue plugin for global translation
export default {
  install(app: App) {
    const { t } = useTranslation()
    
    // Make translation function available globally
    app.config.globalProperties.$t = t
    app.provide('t', t)
  }
}

// Auto-translate directive
export const translateDirective = {
  mounted(el: HTMLElement, binding: any) {
    const { t } = useTranslation()
    const key = binding.value || el.textContent?.trim()
    if (key) {
      el.textContent = t(key)
    }
  },
  updated(el: HTMLElement, binding: any) {
    const { t } = useTranslation()
    const key = binding.value || el.textContent?.trim()
    if (key) {
      el.textContent = t(key)
    }
  }
}