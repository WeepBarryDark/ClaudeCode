<template>
  <ShopLayout :categories="categories">
    <div class="bg-white">
      <!-- Hero Section -->
      <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ t('about_ecos_flooring') }}</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
              {{ t('about_description') }}
            </p>
          </div>
        </div>
      </section>

      <!-- Our Story Section -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ t('our_story') }}</h2>
              <div class="space-y-4 text-gray-600">
                <p>
                  {{ t('our_story_paragraph_1') }}
                </p>
                <p>
                  {{ t('our_story_paragraph_2') }}
                </p>
                <p>
                  {{ t('our_story_paragraph_3') }}
                </p>
              </div>
            </div>
            <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
              <span class="text-gray-500">{{ t('company_photo') }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Values Section -->
      <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ t('our_mission') }}</h2>
            <p class="text-lg text-gray-600">{{ t('our_values_description') }}</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">🌱</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">{{ t('sustainability') }}</h3>
              <p class="text-gray-600">
                {{ t('sustainability_description') }}
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">⭐</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">{{ t('quality_products') }}</h3>
              <p class="text-gray-600">
                {{ t('quality_products_description') }}
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">🤝</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">{{ t('expert_service') }}</h3>
              <p class="text-gray-600">
                {{ t('expert_service_description') }}
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Team Section -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ t('meet_our_team') }}</h2>
            <p class="text-lg text-gray-600">{{ t('meet_our_team_description') }}</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-gray-500">{{ t('photo') }}</span>
              </div>
              <h3 class="text-xl font-semibold mb-1">Sarah Johnson</h3>
              <p class="text-green-600 mb-2">{{ t('founder_ceo') }}</p>
              <p class="text-gray-600 text-sm">
                {{ t('sarah_description') }}
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-gray-500">{{ t('photo') }}</span>
              </div>
              <h3 class="text-xl font-semibold mb-1">Mike Chen</h3>
              <p class="text-green-600 mb-2">{{ t('installation_manager') }}</p>
              <p class="text-gray-600 text-sm">
                {{ t('mike_description') }}
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-gray-500">{{ t('photo') }}</span>
              </div>
              <h3 class="text-xl font-semibold mb-1">Emily Rodriguez</h3>
              <p class="text-green-600 mb-2">{{ t('design_consultant') }}</p>
              <p class="text-gray-600 text-sm">
                {{ t('emily_description') }}
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="py-16 bg-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 class="text-3xl font-bold mb-4">{{ t('ready_to_transform') }}</h2>
          <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
            {{ t('expert_help_description') }}
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <Link :href="route('contact')" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors">
              {{ t('consultation') }}
            </Link>
            <Link :href="route('samples')" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
              {{ t('order_free_samples') }}
            </Link>
          </div>
        </div>
      </section>
    </div>
  </ShopLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'
import { useLocale } from '@/composables/useLocale'

const { t } = useLocale()

interface Category {
  id: number
  name: string
  slug: string
  description?: string
  image?: string
}

interface Props {
  categories: Category[]
}

defineProps<Props>()
</script>