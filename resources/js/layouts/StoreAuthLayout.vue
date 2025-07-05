<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <!-- Navigation Header -->
    <div class="absolute top-0 left-0 right-0 bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <Link :href="route('home')" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-sm">EF</span>
            </div>
            <span class="text-xl font-bold text-gray-900">{{ t('ecos_flooring') }}</span>
          </Link>

          <!-- Right side navigation -->
          <div class="flex items-center space-x-4">
            <LanguageSelector />
            <Link :href="route('home')" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
              {{ t('back_to_store') }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md mt-16">
      <!-- Logo and Header -->
      <div class="text-center mb-8">
        <Link :href="route('home')" class="inline-flex items-center space-x-2 mb-6">
          <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-lg">EF</span>
          </div>
          <span class="text-2xl font-bold text-gray-900">{{ t('ecos_flooring') }}</span>
        </Link>
        <h2 class="text-3xl font-bold text-gray-900">{{ title }}</h2>
        <p v-if="description" class="mt-2 text-sm text-gray-600">{{ description }}</p>
      </div>

      <!-- Content Card -->
      <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 border border-gray-200">
        <slot />
      </div>

      <!-- Footer Links -->
      <div class="mt-6 text-center">
        <div class="flex justify-center space-x-6 text-sm">
          <Link :href="route('home')" class="text-gray-600 hover:text-green-600 transition-colors">
            {{ t('home') }}
          </Link>
          <Link :href="route('products')" class="text-gray-600 hover:text-green-600 transition-colors">
            {{ t('products') }}
          </Link>
          <Link :href="route('contact')" class="text-gray-600 hover:text-green-600 transition-colors">
            {{ t('contact_us') }}
          </Link>
          <Link :href="route('about')" class="text-gray-600 hover:text-green-600 transition-colors">
            {{ t('about_us') }}
          </Link>
        </div>
        <p class="mt-4 text-xs text-gray-500">
          {{ t('copyright') }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { useLocale } from '@/composables/useLocale'
import LanguageSelector from '@/components/LanguageSelector.vue'

const { t } = useLocale()

interface Props {
  title?: string
  description?: string
}

defineProps<Props>()
</script>