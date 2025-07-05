<template>
  <ShopLayout :categories="categories">
    <div class="bg-white">
      <!-- Header -->
      <section class="bg-gradient-to-r from-green-600 to-green-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ t('order_free_samples') }}</h1>
            <p class="text-xl text-green-100 max-w-3xl mx-auto">
              {{ t('samples_description') }}
            </p>
          </div>
        </div>
      </section>

      <!-- Benefits Section -->
      <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">📦</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('free') }}</h3>
              <p class="text-gray-600">{{ t('no_shipping_charges') }}</p>
            </div>
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">⚡</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('fast_delivery') }}</h3>
              <p class="text-gray-600">{{ t('fast_delivery_description') }}</p>
            </div>
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">✋</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('feel_quality') }}</h3>
              <p class="text-gray-600">{{ t('feel_quality_description') }}</p>
            </div>
          </div>
        </div>
      </section>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          <!-- Product Selection -->
          <div class="lg:col-span-2">
            <div class="mb-8">
              <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ t('select_samples') }}</h2>
              <p class="text-gray-600">{{ t('sample_limit') }}</p>
            </div>

            <!-- Category Filter -->
            <div class="mb-6">
              <div class="flex flex-wrap gap-2">
                <button
                  @click="selectedCategoryFilter = null"
                  :class="[
                    'px-4 py-2 rounded-full text-sm font-medium transition-colors',
                    selectedCategoryFilter === null 
                      ? 'bg-green-600 text-white' 
                      : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                  ]"
                >
                  {{ t('all_products') }}
                </button>
                <button
                  v-for="category in categories"
                  :key="category.id"
                  @click="selectedCategoryFilter = category.id"
                  :class="[
                    'px-4 py-2 rounded-full text-sm font-medium transition-colors',
                    selectedCategoryFilter === category.id 
                      ? 'bg-green-600 text-white' 
                      : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                  ]"
                >
                  {{ category.name }}
                </button>
              </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
              <div
                v-for="product in filteredProducts"
                :key="product.id"
                class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow"
              >
                <div class="aspect-square bg-gray-200 flex items-center justify-center">
                  <img
                    v-if="product.images && product.images.length > 0"
                    :src="product.images[0]"
                    :alt="product.name"
                    class="w-full h-full object-cover"
                  />
                  <span v-else class="text-gray-500">{{ t('no_image') }}</span>
                </div>
                <div class="p-4">
                  <p class="text-xs text-green-600 font-medium uppercase tracking-wide mb-1">
                    {{ product.category.name }}
                  </p>
                  <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ product.name }}</h3>
                  <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ product.description }}</p>
                  
                  <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-900">${{ typeof product.buyer_price === 'string' ? parseFloat(product.buyer_price).toFixed(2) : product.buyer_price.toFixed(2) }}</span>
                    <button
                      @click="toggleSample(product)"
                      :disabled="!isSelected(product.id) && selectedSamples.length >= 8"
                      :class="[
                        'px-4 py-2 text-sm font-medium rounded-lg transition-colors',
                        isSelected(product.id)
                          ? 'bg-green-600 text-white hover:bg-green-700'
                          : selectedSamples.length >= 8
                          ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                          : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                      ]"
                    >
                      {{ isSelected(product.id) ? t('selected_samples') : t('samples') }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sample Cart & Checkout -->
          <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">
                {{ t('selected_samples') }} ({{ selectedSamples.length }}/8)
              </h3>

              <!-- Selected Samples -->
              <div v-if="selectedSamples.length > 0" class="space-y-3 mb-6">
                <div
                  v-for="sample in selectedSamples"
                  :key="sample.id"
                  class="flex items-center justify-between bg-white p-3 rounded-lg"
                >
                  <div>
                    <p class="font-medium text-sm text-gray-900">{{ sample.name }}</p>
                    <p class="text-xs text-gray-500">{{ sample.category.name }}</p>
                  </div>
                  <button
                    @click="removeSample(sample.id)"
                    class="text-red-600 hover:text-red-700 text-sm"
                  >
                    {{ t('remove_sample') }}
                  </button>
                </div>
              </div>

              <div v-else class="text-center py-8 text-gray-500">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                  <span class="text-2xl">📋</span>
                </div>
                <p class="text-sm">{{ t('samples') }}</p>
                <p class="text-xs">{{ t('sample_limit') }}</p>
              </div>

              <!-- Checkout Form -->
              <div v-if="selectedSamples.length > 0">
                <div class="border-t border-gray-200 pt-6">
                  <h4 class="font-medium text-gray-900 mb-4">{{ t('your_information') }}</h4>
                  
                  <form @submit.prevent="submitOrder" class="space-y-4">
                    <div>
                      <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ t('full_name') }} *</label>
                      <input
                        v-model="form.customer_name"
                        type="text"
                        id="name"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                      />
                    </div>

                    <div>
                      <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ t('email_address') }} *</label>
                      <input
                        v-model="form.customer_email"
                        type="email"
                        id="email"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                      />
                    </div>

                    <div>
                      <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ t('phone_number') }}</label>
                      <input
                        v-model="form.customer_phone"
                        type="tel"
                        id="phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                      />
                    </div>

                    <div>
                      <label for="address" class="block text-sm font-medium text-gray-700 mb-1">{{ t('shipping_address') }} *</label>
                      <textarea
                        v-model="form.customer_address"
                        id="address"
                        rows="3"
                        required
                        placeholder="Street address, city, state, zip code"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                      ></textarea>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white p-4 rounded-lg border">
                      <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600">{{ t('samples') }} ({{ selectedSamples.length }})</span>
                        <span class="font-medium">{{ t('free') }}</span>
                      </div>
                      <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600">{{ t('shipping') }}</span>
                        <span class="font-medium">{{ t('free') }}</span>
                      </div>
                      <div class="border-t border-gray-200 pt-2">
                        <div class="flex justify-between items-center">
                          <span class="font-semibold">{{ t('total') }}</span>
                          <span class="font-bold text-green-600">{{ t('free') }}</span>
                        </div>
                      </div>
                    </div>

                    <button
                      type="submit"
                      :disabled="submitting || selectedSamples.length === 0"
                      class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    >
                      <span v-if="submitting">{{ t('processing') }}...</span>
                      <span v-else>{{ t('order_samples_button') }}</span>
                    </button>

                    <p class="text-xs text-gray-500 text-center">
                      By ordering samples, you agree to our terms and privacy policy. 
                      Samples will be shipped within 2-3 business days.
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Why Order Samples Section -->
      <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ t('why_order_samples') }}</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
              {{ t('why_order_samples_description') }}
            </p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
              <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">👁️</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('see_true_colors') }}</h3>
              <p class="text-gray-600 text-sm">{{ t('see_true_colors_description') }}</p>
            </div>
            
            <div class="text-center">
              <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">🤲</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('feel_the_texture') }}</h3>
              <p class="text-gray-600 text-sm">{{ t('feel_the_texture_description') }}</p>
            </div>
            
            <div class="text-center">
              <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">🏠</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('test_in_your_space') }}</h3>
              <p class="text-gray-600 text-sm">{{ t('test_in_your_space_description') }}</p>
            </div>
            
            <div class="text-center">
              <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">⚖️</span>
              </div>
              <h3 class="text-lg font-semibold mb-2">{{ t('compare_options') }}</h3>
              <p class="text-gray-600 text-sm">{{ t('compare_options_description') }}</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </ShopLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'
import { useLocale } from '@/composables/useLocale'

const { t } = useLocale()

interface Category {
  id: number
  name: string
  slug: string
}

interface Product {
  id: number
  name: string
  sku: string
  description?: string
  images?: string[]
  buyer_price: number
  category: Category
}

interface Props {
  categories: Category[]
  products: Product[]
}

const props = defineProps<Props>()

// State
const selectedCategoryFilter = ref<number | null>(null)
const selectedSamples = ref<Product[]>([])
const submitting = ref(false)

const form = ref({
  customer_name: '',
  customer_email: '',
  customer_phone: '',
  customer_address: ''
})

// Computed
const filteredProducts = computed(() => {
  if (!selectedCategoryFilter.value) return props.products
  return props.products.filter(p => p.category.id === selectedCategoryFilter.value)
})

// Methods
const isSelected = (productId: number) => {
  return selectedSamples.value.some(s => s.id === productId)
}

const toggleSample = (product: Product) => {
  if (isSelected(product.id)) {
    removeSample(product.id)
  } else if (selectedSamples.value.length < 8) {
    selectedSamples.value.push(product)
  }
}

const removeSample = (productId: number) => {
  const index = selectedSamples.value.findIndex(s => s.id === productId)
  if (index !== -1) {
    selectedSamples.value.splice(index, 1)
  }
}

const submitOrder = async () => {
  if (selectedSamples.value.length === 0) return
  
  submitting.value = true
  
  try {
    await router.post(route('samples.store'), {
      ...form.value,
      selected_products: selectedSamples.value.map(s => s.id)
    })
    
    // Reset form on success
    selectedSamples.value = []
    form.value = {
      customer_name: '',
      customer_email: '',
      customer_phone: '',
      customer_address: ''
    }
  } catch (error) {
    console.error('Failed to submit sample order:', error)
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>