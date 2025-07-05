<template>
  <div class="bg-white rounded-lg shadow-sm overflow-hidden group hover:shadow-lg transition-all duration-300">
    <div class="relative aspect-square overflow-hidden">
      <img v-if="product.images && product.images.length > 0" 
           :src="product.images[0]" 
           :alt="product.name"
           class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
      <div v-else class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
        <SwatchIcon class="h-16 w-16 text-gray-400" />
      </div>
      
      <!-- Discount Badge -->
      <div v-if="hasDiscount" class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
        {{ discountPercentage }}% {{ t('off') }}
      </div>
      
      <!-- Quick View Button -->
      <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
        <Link :href="route('product.show', product.id)" 
              class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
          {{ t('quick_view') }}
        </Link>
      </div>
    </div>
    
    <div class="p-4">
      <!-- Category -->
      <p class="text-xs text-green-600 font-medium uppercase tracking-wide mb-1">
        {{ product.category.name }}
      </p>
      
      <!-- Product Name -->
      <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
        <Link :href="route('product.show', product.id)" class="hover:text-green-600 transition-colors">
          {{ product.name }}
        </Link>
      </h3>
      
      <!-- Description -->
      <p v-if="product.description" class="text-sm text-gray-600 mb-3 line-clamp-2">
        {{ product.description }}
      </p>
      
      <!-- Price -->
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="text-lg font-bold text-gray-900">
            ${{ displayPrice }}
          </span>
          <span v-if="hasDiscount" class="text-sm text-gray-500 line-through">
            ${{ originalPrice }}
          </span>
        </div>
        
        <!-- Add to Cart Button -->
        <button @click="addToCart" 
                class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-700 transition-colors"
                :disabled="isAddingToCart">
          <ShoppingCartIcon v-if="!isAddingToCart" class="h-5 w-5" />
          <div v-else class="h-5 w-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
        </button>
      </div>
      
      <!-- Product Options Preview -->
      <div v-if="product.colors && product.colors.length > 0" class="mt-3">
        <p class="text-xs text-gray-500 mb-1">{{ t('available_colors') }}:</p>
        <div class="flex space-x-1">
          <div v-for="(color, index) in product.colors.slice(0, 4)" :key="color"
               class="w-4 h-4 rounded-full border border-gray-300"
               :style="{ backgroundColor: getColorValue(color) }"
               :title="color">
          </div>
          <span v-if="product.colors.length > 4" class="text-xs text-gray-500">
            +{{ product.colors.length - 4 }} {{ t('more') }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { ShoppingCartIcon, SwatchIcon } from '@heroicons/vue/24/outline'
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
  vip_buyer_price?: number
  commercial_buyer_price?: number
  discount_price?: number
  colors?: string[]
  sizes?: string[]
  category: Category
}

interface Props {
  product: Product
  userRole?: string
}

const props = withDefaults(defineProps<Props>(), {
  userRole: 'buyer'
})

const isAddingToCart = ref(false)

const originalPrice = computed(() => {
  let price: number
  switch (props.userRole) {
    case 'vip_buyer':
      price = props.product.vip_buyer_price || props.product.buyer_price
      break
    case 'commercial_buyer':
      price = props.product.commercial_buyer_price || props.product.buyer_price
      break
    default:
      price = props.product.buyer_price
  }
  return typeof price === 'string' ? parseFloat(price) : price
})

const displayPrice = computed(() => {
  const discount = props.product.discount_price
  const discountPrice = typeof discount === 'string' ? parseFloat(discount) : discount
  
  if (discountPrice && discountPrice < originalPrice.value) {
    return discountPrice.toFixed(2)
  }
  return originalPrice.value.toFixed(2)
})

const hasDiscount = computed(() => {
  const discount = props.product.discount_price
  const discountPrice = typeof discount === 'string' ? parseFloat(discount) : discount
  return discountPrice && discountPrice < originalPrice.value
})

const discountPercentage = computed(() => {
  if (!hasDiscount.value) return 0
  const discount = props.product.discount_price
  const discountPrice = typeof discount === 'string' ? parseFloat(discount) : discount
  return Math.round((1 - discountPrice! / originalPrice.value) * 100)
})

const addToCart = async () => {
  isAddingToCart.value = true
  try {
    await router.post(route('cart.add'), {
      product_id: props.product.id,
      quantity: 1
    })
    // You could show a success message here
  } catch (error) {
    console.error('Failed to add to cart:', error)
    // You could show an error message here
  } finally {
    isAddingToCart.value = false
  }
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
    'natural': '#deb887'
  }
  
  return colorMap[colorName.toLowerCase()] || '#e5e7eb'
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