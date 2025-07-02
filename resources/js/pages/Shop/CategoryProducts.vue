<template>
  <ShopLayout :categories="categories">
    <div class="bg-white">
      <!-- Category Header -->
      <section class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ category.name }}</h1>
            <p v-if="category.description" class="text-xl text-gray-600 max-w-2xl mx-auto">
              {{ category.description }}
            </p>
          </div>
        </div>
      </section>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Results Info -->
        <div class="flex items-center justify-between mb-6">
          <p class="text-gray-600">
            {{ products.data.length }} products in {{ category.name }}
          </p>
          <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">View:</span>
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

        <!-- Products Grid View -->
        <div
          v-if="viewMode === 'grid'"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
          <ProductCard
            v-for="product in products.data"
            :key="product.id"
            :product="product"
            :userRole="$page.props.auth.user?.role"
          />
        </div>

        <!-- Products List View -->
        <div v-else class="space-y-6">
          <div
            v-for="product in products.data"
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
                <span v-else class="text-gray-500">No Image</span>
              </div>
              <div class="flex-1">
                <div class="flex flex-col h-full">
                  <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ product.name }}</h3>
                    <p class="text-gray-600 mb-3">{{ product.description }}</p>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                      <span v-if="product.colors?.length">
                        Colors: {{ product.colors.slice(0, 3).join(', ') }}
                        <span v-if="product.colors.length > 3">+{{ product.colors.length - 3 }} more</span>
                      </span>
                      <span v-if="product.sizes?.length">
                        Sizes: {{ product.sizes.join(', ') }}
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
                        View Details
                      </Link>
                      <button
                        @click="addToCart(product.id)"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                      >
                        Add to Cart
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="products.links.length > 3" class="mt-12 flex justify-center">
          <nav class="flex items-center space-x-2">
            <Link
              v-for="link in products.links"
              :key="link.label"
              :href="link.url"
              v-html="link.label"
              :class="[
                'px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                link.active
                  ? 'bg-green-600 text-white'
                  : link.url
                  ? 'text-gray-700 hover:bg-gray-100'
                  : 'text-gray-400 cursor-not-allowed'
              ]"
            />
          </nav>
        </div>

        <!-- Empty State -->
        <div v-if="products.data.length === 0" class="text-center py-12">
          <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m0 0V9a2 2 0 012-2h2m4 0h2a2 2 0 012 2v4M6 9h2m3 0h3" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
          <p class="text-gray-600 mb-4">There are no products in this category yet.</p>
          <Link :href="route('products')" class="text-green-600 hover:text-green-700 font-medium">
            Browse all products
          </Link>
        </div>
      </div>
    </div>
  </ShopLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'
import ProductCard from '@/components/ProductCard.vue'

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
}

interface Props {
  category: Category
  products: {
    data: Product[]
    links: Array<{
      url: string | null
      label: string
      active: boolean
    }>
  }
  categories: Category[]
}

const props = defineProps<Props>()

const viewMode = ref<'grid' | 'list'>('grid')

// Methods
const getDisplayPrice = (product: Product) => {
  const userRole = props.$page?.props?.auth?.user?.role || 'buyer'
  
  // Convert to numbers if strings
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
</script>