<template>
  <div class="relative" @click.stop>
    <button
      @click.stop="toggleDropdown"
      class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      <span class="sr-only">{{ t('language') }}</span>
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
      </svg>
      <span class="ml-2 text-xs">{{ currentLocale === 'en' ? 'EN' : '中' }}</span>
      <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>

    <div 
      v-if="isOpen"
      class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-[9999]"
    >
      <div class="py-1">
        <button
          v-for="locale in availableLocales"
          :key="locale.code"
          @click="changeLanguage(locale.code)"
          class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center"
          :class="{ 'bg-gray-100 dark:bg-gray-700': currentLocale === locale.code }"
        >
          <span class="flex-1">{{ locale.name }}</span>
          <svg
            v-if="currentLocale === locale.code"
            class="w-4 h-4 text-indigo-600 dark:text-indigo-400"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useLocale } from '@/composables/useLocale'
import { router } from '@inertiajs/vue3'

const { currentLocale, availableLocales, t } = useLocale()
const isOpen = ref(false)

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const closeDropdown = () => {
  isOpen.value = false
}

const changeLanguage = (locale: string) => {
  console.log('Changing language to:', locale)
  isOpen.value = false
  
  // Update language via API
  router.post(route('language.update'), {
    locale: locale
  }, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Language updated successfully')
      // Reload page to apply new locale
      window.location.reload()
    },
    onError: (errors) => {
      console.error('Language update failed:', errors)
    }
  })
}

// Click outside to close
const handleClickOutside = (event: Event) => {
  if (isOpen.value) {
    isOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>