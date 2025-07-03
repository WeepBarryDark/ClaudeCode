<template>
  <ShopLayout :categories="categories">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-green-800 to-green-600 text-white">
      <div class="absolute inset-0 bg-black/20"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="max-w-3xl">
          <h1 class="text-4xl md:text-6xl font-bold mb-6">
            {{ t('premium_flooring') }}
            <span class="text-green-300">{{ t('solutions') }}</span>
          </h1>
          <p class="text-xl md:text-2xl mb-8 text-green-100">
            {{ t('hero_description') }}
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <Link :href="route('products')" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors inline-flex items-center justify-center">
              {{ t('shop_all_products') }}
            </Link>
            <Link :href="route('samples')" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors inline-flex items-center justify-center">
              {{ t('order_free_samples') }}
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            {{ t('browse_by_category') }}
          </h2>
          <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            {{ t('categories_description') }}
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <Link v-for="category in categories" :key="category.id"
                :href="route('products.category', category.slug)"
                class="group relative overflow-hidden rounded-xl bg-gray-100 aspect-square hover:shadow-xl transition-all duration-300">
            <img v-if="category.image" 
                 :src="category.image" 
                 :alt="category.name"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
            <div v-else class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors duration-300"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="text-center text-white">
                <h3 class="text-2xl font-bold mb-2">{{ category.name }}</h3>
                <p v-if="category.description" class="text-green-200 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  {{ category.description }}
                </p>
              </div>
            </div>
          </Link>
        </div>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            {{ t('featured_products') }}
          </h2>
          <p class="text-lg text-gray-600">
            {{ t('featured_products_description') }}
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <ProductCard v-for="product in featuredProducts" :key="product.id" :product="product" />
        </div>

        <div class="text-center mt-12">
          <Link :href="route('products')" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
            {{ t('view_all_products') }}
          </Link>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <TruckIcon class="h-8 w-8 text-green-600" />
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ t('free_shipping') }}</h3>
            <p class="text-gray-600">{{ t('free_shipping_description') }}</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <SwatchIcon class="h-8 w-8 text-green-600" />
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ t('free_samples') }}</h3>
            <p class="text-gray-600">{{ t('free_samples_description') }}</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <ShieldCheckIcon class="h-8 w-8 text-green-600" />
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ t('quality_guarantee') }}</h3>
            <p class="text-gray-600">{{ t('quality_guarantee_description') }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-green-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
          {{ t('need_help_choosing') }}
        </h2>
        <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
          {{ t('expert_help_description') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Link :href="route('contact')" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors">
            {{ t('contact_our_experts') }}
          </Link>
          <a href="tel:555-123-4567" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
            {{ t('call_phone_number') }}
          </a>
        </div>
      </div>
    </section>
  </ShopLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'
import ProductCard from '@/components/ProductCard.vue'
import { useLocale } from '@/composables/useLocale'
import { 
  TruckIcon, 
  SwatchIcon, 
  ShieldCheckIcon 
} from '@heroicons/vue/24/outline'

const { t } = useLocale()

interface Category {
  id: number
  name: string
  slug: string
  description?: string
  image?: string
}

interface Product {
  id: number
  name: string
  sku: string
  description?: string
  images?: string[]
  buyer_price: number
  discount_price?: number
  category: Category
}

interface Props {
  featuredProducts: Product[]
  categories: Category[]
}

defineProps<Props>()
</script>