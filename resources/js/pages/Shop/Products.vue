<template>
  <ShopLayout :categories="categories">
    <div class="bg-white">
      <!-- Header -->
      <section class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ t('our_flooring_collection') }}</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
              {{ t('flooring_collection_description') }}
            </p>
          </div>
        </div>
      </section>

      <!-- Category Tabs -->
      <section class="sticky top-0 bg-white border-b border-gray-200 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex space-x-8 overflow-x-auto py-4">
            <button
              @click="selectedCategory = null"
              :class="[
                'whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors',
                selectedCategory === null 
                  ? 'border-green-600 text-green-600' 
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              {{ t('all_products') }}
            </button>
            <button
              v-for="category in categories"
              :key="category.id"
              @click="selectedCategory = category.id"
              :class="[
                'whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors',
                selectedCategory === category.id 
                  ? 'border-green-600 text-green-600' 
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              {{ category.name }}
            </button>
          </div>
        </div>
      </section>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
          <!-- Sidebar Filters -->
          <div class="lg:w-64 flex-shrink-0">
            <div class="bg-gray-50 rounded-lg p-6 sticky top-32">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ t('filters') }}</h3>
              
              <!-- Price Range -->
              <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">{{ t('price_range') }}</h4>
                <div class="space-y-2">
                  <label class="flex items-center">
                    <input type="radio" v-model="priceRange" value="all" class="mr-2 text-green-600">
                    <span class="text-sm text-gray-700">{{ t('all_prices') }}</span>
                  </label>
                  <label class="flex items-center">
                    <input type="radio" v-model="priceRange" value="0-3" class="mr-2 text-green-600">
                    <span class="text-sm text-gray-700">{{ t('under_3') }}</span>
                  </label>
                  <label class="flex items-center">
                    <input type="radio" v-model="priceRange" value="3-6" class="mr-2 text-green-600">
                    <span class="text-sm text-gray-700">{{ t('price_3_6') }}</span>
                  </label>
                  <label class="flex items-center">
                    <input type="radio" v-model="priceRange" value="6-10" class="mr-2 text-green-600">
                    <span class="text-sm text-gray-700">{{ t('price_6_10') }}</span>
                  </label>
                  <label class="flex items-center">
                    <input type="radio" v-model="priceRange" value="10+" class="mr-2 text-green-600">
                    <span class="text-sm text-gray-700">{{ t('price_10_plus') }}</span>
                  </label>
                </div>
              </div>

              <!-- Colors -->
              <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">{{ t('colors') }}</h4>
                <div class="grid grid-cols-3 gap-2">
                  <button
                    v-for="color in availableColors"
                    :key="color"
                    @click="toggleColor(color)"
                    :class="[
                      'w-8 h-8 rounded-full border-2 transition-all',
                      selectedColors.includes(color)
                        ? 'border-green-600 shadow-lg'
                        : 'border-gray-300 hover:border-gray-400'
                    ]"
                    :style="{ backgroundColor: getColorValue(color) }"
                    :title="color"
                  ></button>
                </div>
                <div class="mt-2 flex flex-wrap gap-1">
                  <span
                    v-for="color in selectedColors"
                    :key="color"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800"
                  >
                    {{ color }}
                    <button @click="toggleColor(color)" class="ml-1 text-green-600 hover:text-green-800">×</button>
                  </span>
                </div>
              </div>

              <!-- Sizes -->
              <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">{{ t('sizes') }}</h4>
                <div class="space-y-2">
                  <label
                    v-for="size in availableSizes"
                    :key="size"
                    class="flex items-center"
                  >
                    <input
                      type="checkbox"
                      v-model="selectedSizes"
                      :value="size"
                      class="mr-2 text-green-600 rounded"
                    >
                    <span class="text-sm text-gray-700">{{ size }}</span>
                  </label>
                </div>
              </div>

              <!-- Sort By -->
              <div>
                <h4 class="text-sm font-medium text-gray-900 mb-3">{{ t('sort_by') }}</h4>
                <select
                  v-model="sortBy"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                >
                  <option value="name">{{ t('name_a_z') }}</option>
                  <option value="price_low">{{ t('price_low_high') }}</option>
                  <option value="price_high">{{ t('price_high_low') }}</option>
                  <option value="newest">{{ t('newest_first') }}</option>
                </select>
              </div>

              <!-- Clear Filters -->
              <button
                @click="clearFilters"
                class="w-full mt-4 px-4 py-2 text-sm text-green-600 border border-green-600 rounded-lg hover:bg-green-50 transition-colors"
              >
                {{ t('clear_all_filters') }}
              </button>
            </div>
          </div>

          <!-- Products Grid -->
          <div class="flex-1">
            <!-- Results Info -->
            <div class="flex items-center justify-between mb-6">
              <p class="text-gray-600">
                {{ filteredProducts.length }} {{ t('products_found') }}
                <span v-if="selectedCategory">{{ t('in') }} {{ selectedCategoryName }}</span>
              </p>
              <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">{{ t('view') }}:</span>
                <button
                  @click="viewMode = 'grid'"
                  :class="[
                    'p-2 border rounded',
                    viewMode === 'grid' ? 'border-green-600 text-green-600' : 'border-gray-300 text-gray-400'
                  ]"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                  </svg>
                </button>
                <button
                  @click="viewMode = 'list'"
                  :class="[
                    'p-2 border rounded',
                    viewMode === 'list' ? 'border-green-600 text-green-600' : 'border-gray-300 text-gray-400'
                  ]"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- No Results -->
            <div v-if="filteredProducts.length === 0" class="text-center py-12">
              <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">{{ t('no_products_found') }}</h3>
              <p class="text-gray-600 mb-4">{{ t('try_adjusting_filters') }}</p>
              <button
                @click="clearFilters"
                class="text-green-600 hover:text-green-700 font-medium"
              >
                {{ t('clear_all_filters_button') }}
              </button>
            </div>

            <!-- Products Grid View -->
            <div
              v-else-if="viewMode === 'grid'"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
            >
              <ProductCard
                v-for="product in filteredProducts"
                :key="product.id"
                :product="product"
                :userRole="$page.props.auth.user?.role"
              />
            </div>

            <!-- Products List View -->
            <div v-else class="space-y-6">
              <div
                v-for="product in filteredProducts"
                :key="product.id"
                class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow"
              >
                <div class="flex flex-col md:flex-row gap-6">
                  <div class="w-full md:w-48 h-48 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                    <img
                      v-if="product.images && product.images.length > 0"
                      :src="product.images[0]"
                      :alt="product.name"
                      class="w-full h-full object-cover rounded-lg"
                    />
                    <span v-else class="text-gray-500">{{ t('no_image') }}</span>
                  </div>
                  <div class="flex-1">
                    <div class="flex flex-col h-full">
                      <div class="mb-4">
                        <p class="text-xs text-green-600 font-medium uppercase tracking-wide mb-1">
                          {{ product.category.name }}
                        </p>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ product.name }}</h3>
                        <p class="text-gray-600 mb-3">{{ product.description }}</p>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                          <span v-if="product.colors?.length">
                            {{ t('colors_label') }}: {{ product.colors.slice(0, 3).join(', ') }}
                            <span v-if="product.colors.length > 3">+{{ product.colors.length - 3 }} {{ t('more') }}</span>
                          </span>
                          <span v-if="product.sizes?.length">
                            {{ t('sizes_label') }}: {{ product.sizes.join(', ') }}
                          </span>
                        </div>
                      </div>
                      <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center space-x-2">
                          <span class="text-2xl font-bold text-gray-900">
                            ${{ getDisplayPrice(product) }}
                          </span>
                          <span v-if="hasDiscount(product)" class="text-lg text-gray-500 line-through">
                            ${{ getOriginalPrice(product) }}
                          </span>
                        </div>
                        <div class="flex items-center space-x-2">
                          <Link
                            :href="route('product.show', product.id)"
                            class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors"
                          >
                            {{ t('view_details') }}
                          </Link>
                          <button
                            @click="addToCart(product.id)"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                          >
                            {{ t('add_to_cart') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ShopLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'
import ProductCard from '@/components/ProductCard.vue'
import { useLocale } from '@/composables/useLocale'

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
  vip_buyer_price?: number
  commercial_buyer_price?: number
  discount_price?: number
  colors?: string[]
  sizes?: string[]
  category: Category
  stock_quantity: number
}

interface Props {
  products: {
    data: Product[]
  }
  categories: Category[]
  filters?: {
    category?: string
    min_price?: number
    max_price?: number
    colors?: string
    sizes?: string
    sort_by?: string
  }
}

const props = defineProps<Props>()

// State
const selectedCategory = ref<number | null>(null)
const priceRange = ref('all')
const selectedColors = ref<string[]>([])
const selectedSizes = ref<string[]>([])
const sortBy = ref('name')
const viewMode = ref<'grid' | 'list'>('grid')

// Available options
const availableColors = computed(() => {
  const colors = new Set<string>()
  props.products.data.forEach(product => {
    product.colors?.forEach(color => colors.add(color))
  })
  return Array.from(colors).sort()
})

const availableSizes = computed(() => {
  const sizes = new Set<string>()
  props.products.data.forEach(product => {
    product.sizes?.forEach(size => sizes.add(size))
  })
  return Array.from(sizes).sort()
})

// Computed
const selectedCategoryName = computed(() => {
  if (!selectedCategory.value) return null
  return props.categories.find(c => c.id === selectedCategory.value)?.name
})

const filteredProducts = computed(() => {
  let filtered = [...props.products.data]

  // Filter by category
  if (selectedCategory.value) {
    filtered = filtered.filter(p => p.category.id === selectedCategory.value)
  }

  // Filter by price range
  if (priceRange.value !== 'all') {
    const [min, max] = priceRange.value.split('-').map(Number)
    filtered = filtered.filter(p => {
      const price = p.buyer_price
      if (priceRange.value === '10+') return price >= 10
      return price >= min && price <= max
    })
  }

  // Filter by colors
  if (selectedColors.value.length > 0) {
    filtered = filtered.filter(p =>
      p.colors?.some(color => selectedColors.value.includes(color))
    )
  }

  // Filter by sizes
  if (selectedSizes.value.length > 0) {
    filtered = filtered.filter(p =>
      p.sizes?.some(size => selectedSizes.value.includes(size))
    )
  }

  // Sort
  if (sortBy.value === 'price_low') {
    filtered.sort((a, b) => a.buyer_price - b.buyer_price)
  } else if (sortBy.value === 'price_high') {
    filtered.sort((a, b) => b.buyer_price - a.buyer_price)
  } else if (sortBy.value === 'newest') {
    filtered.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime())
  } else {
    filtered.sort((a, b) => a.name.localeCompare(b.name))
  }

  return filtered
})

// Methods
const toggleColor = (color: string) => {
  const index = selectedColors.value.indexOf(color)
  if (index === -1) {
    selectedColors.value.push(color)
  } else {
    selectedColors.value.splice(index, 1)
  }
}

const clearFilters = () => {
  selectedCategory.value = null
  priceRange.value = 'all'
  selectedColors.value = []
  selectedSizes.value = []
  sortBy.value = 'name'
}

const getColorValue = (colorName: string): string => {
  const colorMap: Record<string, string> = {
    'white': '#ffffff',
    'black': '#000000',
    'brown': '#8b4513',
    'gray': '#808080',
    'grey': '#808080',
    'beige': '#f5f5dc',
    'oak': '#daa520',
    'cherry': '#de3163',
    'mahogany': '#c04000',
    'walnut': '#773f1a',
    'maple': '#faf0e6',
    'pine': '#ffc020',
    'red': '#ff0000',
    'blue': '#0000ff',
    'green': '#008000',
    'yellow': '#ffff00',
    'natural': '#deb887',
    'honey': '#ffc649',
    'espresso': '#3c2415',
    'light oak': '#d2b48c',
    'dark oak': '#654321'
  }
  
  return colorMap[colorName.toLowerCase()] || '#e5e7eb'
}

const getDisplayPrice = (product: Product) => {
  const userRole = props.$page?.props?.auth?.user?.role || 'buyer'
  
  // Convert discount price to number
  const discountPrice = typeof product.discount_price === 'string' ? parseFloat(product.discount_price) : product.discount_price
  const buyerPrice = typeof product.buyer_price === 'string' ? parseFloat(product.buyer_price) : product.buyer_price
  
  if (discountPrice && discountPrice < buyerPrice) {
    return discountPrice.toFixed(2)
  }
  
  let price: number
  switch (userRole) {
    case 'vip_buyer':
      price = product.vip_buyer_price || product.buyer_price
      break
    case 'commercial_buyer':
      price = product.commercial_buyer_price || product.buyer_price
      break
    default:
      price = product.buyer_price
  }
  
  // Convert to number if string
  const numPrice = typeof price === 'string' ? parseFloat(price) : price
  return numPrice.toFixed(2)
}

const getOriginalPrice = (product: Product) => {
  const userRole = props.$page?.props?.auth?.user?.role || 'buyer'
  
  let price: number
  switch (userRole) {
    case 'vip_buyer':
      price = product.vip_buyer_price || product.buyer_price
      break
    case 'commercial_buyer':
      price = product.commercial_buyer_price || product.buyer_price
      break
    default:
      price = product.buyer_price
  }
  
  // Convert to number if string
  const numPrice = typeof price === 'string' ? parseFloat(price) : price
  return numPrice.toFixed(2)
}

const hasDiscount = (product: Product) => {
  const originalPrice = parseFloat(getOriginalPrice(product))
  const discountPrice = typeof product.discount_price === 'string' ? parseFloat(product.discount_price) : product.discount_price
  return discountPrice && discountPrice < originalPrice
}

const addToCart = async (productId: number) => {
  try {
    await router.post(route('cart.add'), {
      product_id: productId,
      quantity: 1
    })
  } catch (error) {
    console.error('Failed to add to cart:', error)
  }
}

// Initialize filters from URL
onMounted(() => {
  if (props.filters?.category) {
    const category = props.categories.find(c => c.slug === props.filters.category)
    if (category) selectedCategory.value = category.id
  }
  if (props.filters?.sort_by) {
    sortBy.value = props.filters.sort_by
  }
})
</script>