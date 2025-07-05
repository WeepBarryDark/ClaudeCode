import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useLocale() {
    const page = usePage()
    
    const currentLocale = computed(() => page.props.locale || page.props.auth?.user?.locale || 'en')
    const currentTimezone = computed(() => page.props.timezone || page.props.auth?.user?.timezone || 'UTC')
    
    const isEnglish = computed(() => currentLocale.value === 'en')
    const isChinese = computed(() => currentLocale.value === 'zh-CN')
    
    const availableLocales = [
        { code: 'en', name: 'English' },
        { code: 'zh-CN', name: '中文简体' }
    ]
    
    const availableTimezones = [
        {
            group: 'Australia',
            zones: [
                { code: 'Australia/Sydney', name: 'Australia/Sydney (AEDT/AEST)' },
                { code: 'Australia/Melbourne', name: 'Australia/Melbourne (AEDT/AEST)' },
                { code: 'Australia/Brisbane', name: 'Australia/Brisbane (AEST)' },
                { code: 'Australia/Perth', name: 'Australia/Perth (AWST)' },
                { code: 'Australia/Adelaide', name: 'Australia/Adelaide (ACDT/ACST)' },
            ]
        },
        {
            group: 'New Zealand',
            zones: [
                { code: 'Pacific/Auckland', name: 'New Zealand/Auckland (NZDT/NZST)' },
                { code: 'Pacific/Chatham', name: 'New Zealand/Chatham (CHADT/CHAST)' },
            ]
        },
        {
            group: 'China',
            zones: [
                { code: 'Asia/Shanghai', name: 'China/Shanghai (CST)' },
                { code: 'Asia/Hong_Kong', name: 'Hong Kong (HKT)' },
                { code: 'Asia/Macau', name: 'Macau (CST)' },
            ]
        }
    ]
    
    const formatDateInTimezone = (date: Date | string, timezone?: string) => {
        const targetTimezone = timezone || currentTimezone.value
        const dateObj = typeof date === 'string' ? new Date(date) : date
        
        return new Intl.DateTimeFormat(currentLocale.value, {
            timeZone: targetTimezone,
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(dateObj)
    }
    
    const formatTimeInTimezone = (date: Date | string, timezone?: string) => {
        const targetTimezone = timezone || currentTimezone.value
        const dateObj = typeof date === 'string' ? new Date(date) : date
        
        return new Intl.DateTimeFormat(currentLocale.value, {
            timeZone: targetTimezone,
            hour: '2-digit',
            minute: '2-digit'
        }).format(dateObj)
    }
    
    const t = (key: string, fallback?: string) => {
        // Import comprehensive translations from Laravel language files
        // This connects to the PHP language files in /lang/{locale}/messages.php
        const translations = page.props.translations || {}
        
        // Only log if no translation found
        if (!translations[key] && process.env.NODE_ENV === 'development') {
            console.warn(`Missing translation for key: "${key}" in locale: ${currentLocale.value}`)
        }
        
        return translations[key] || fallback || key
    }
    
    return {
        currentLocale,
        currentTimezone,
        isEnglish,
        isChinese,
        availableLocales,
        availableTimezones,
        formatDateInTimezone,
        formatTimeInTimezone,
        t
    }
}