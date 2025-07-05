<template>
  <ShopLayout :categories="categories">
    <div class="bg-white min-h-screen">
      <!-- Header -->
      <section class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ t('shopping_cart') }}</h1>
            <p class="text-lg text-gray-600">
              {{ t('review_checkout') }}
            </p>
          </div>
        </div>
      </section>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Empty Cart -->
        <div v-if="cartItems.length === 0" class="text-center py-16">
          <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <ShoppingCartIcon class="h-12 w-12 text-gray-400" />
          </div>
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ t('cart_empty') }}</h2>
          <p class="text-gray-600 mb-8">{{ t('start_shopping_message') }}</p>
          <Link :href="route('products')" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
            {{ t('browse_products') }}
          </Link>
        </div>

        <!-- Cart Content -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          <!-- Cart Items -->
          <div class="lg:col-span-2">
            <div class="bg-white">
              <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ t('cart_items') }} ({{ cartItems.length }})</h2>
              
              <div class="space-y-6">
                <div
                  v-for="item in cartItems"
                  :key="item.id"
                  class="flex flex-col md:flex-row gap-4 p-6 border border-gray-200 rounded-lg"
                >
                  <!-- Product Image -->
                  <div class="w-full md:w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                    <img
                      v-if="item.product.images && item.product.images.length > 0"
                      :src="item.product.images[0]"
                      :alt="item.product.name"
                      class="w-full h-full object-cover rounded-lg"
                    />
                    <span v-else class="text-gray-500 text-sm">{{ t('no_image') }}</span>
                  </div>

                  <!-- Product Details -->
                  <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                      <div class="mb-4 md:mb-0">
                        <p class="text-xs text-green-600 font-medium uppercase tracking-wide mb-1">
                          {{ item.product.category.name }}
                        </p>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ item.product.name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">SKU: {{ item.product.sku }}</p>
                        <p class="text-lg font-bold text-gray-900">${{ getDisplayPrice(item.product) }}</p>
                      </div>

                      <!-- Quantity Controls -->
                      <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                          <label class="text-sm font-medium text-gray-700">{{ t('quantity') }}:</label>
                          <div class="flex items-center border border-gray-300 rounded-lg">
                            <button
                              @click="updateQuantity(item.id, item.quantity - 1)"
                              :disabled="item.quantity <= 1"
                              class="p-2 text-gray-600 hover:text-gray-800 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                              <MinusIcon class="h-4 w-4" />
                            </button>
                            <span class="px-4 py-2 text-center min-w-[60px]">{{ item.quantity }}</span>
                            <button
                              @click="updateQuantity(item.id, item.quantity + 1)"
                              class="p-2 text-gray-600 hover:text-gray-800"
                            >
                              <PlusIcon class="h-4 w-4" />
                            </button>
                          </div>
                        </div>

                        <!-- Remove Button -->
                        <button
                          @click="removeItem(item.id)"
                          class="p-2 text-red-600 hover:text-red-700"
:title="t('remove_item')"
                        >
                          <TrashIcon class="h-5 w-5" />
                        </button>
                      </div>
                    </div>

                    <!-- Item Total -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                      <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ t('item_total') }}:</span>
                        <span class="text-lg font-semibold text-gray-900">
                          ${{ (parseFloat(getDisplayPrice(item.product)) * item.quantity).toFixed(2) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Continue Shopping -->
              <div class="mt-8 pt-6 border-t border-gray-200">
                <Link :href="route('products')" class="text-green-600 hover:text-green-700 font-medium">
                  ← {{ t('continue_shopping') }}
                </Link>
              </div>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ t('order_summary') }}</h3>

              <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                  <span class="text-gray-600">{{ t('subtotal') }}</span>
                  <span class="font-medium">${{ subtotal }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">{{ t('shipping') }}</span>
                  <span class="font-medium">{{ shipping === 0 ? t('free') : `$${shipping}` }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">{{ t('tax') }} (8.5%)</span>
                  <span class="font-medium">${{ tax }}</span>
                </div>
                <div class="border-t border-gray-300 pt-3">
                  <div class="flex justify-between">
                    <span class="text-lg font-semibold">{{ t('total') }}</span>
                    <span class="text-lg font-bold text-green-600">${{ total }}</span>
                  </div>
                </div>
              </div>

              <!-- Shipping Info -->
              <div class="mb-6 p-4 bg-green-50 rounded-lg">
                <div class="flex items-start space-x-2">
                  <TruckIcon class="h-5 w-5 text-green-600 mt-0.5" />
                  <div>
                    <p class="text-sm font-medium text-green-800">{{ t('free_shipping_over_99') }}</p>
                    <p class="text-xs text-green-600">
                      {{ parseFloat(subtotal) >= 99 ? t('qualify_free_shipping') : t('add_for_free_shipping').replace(':amount', `$${(99 - parseFloat(subtotal)).toFixed(2)}`) }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Checkout Button -->
              <button
                @click="proceedToCheckout"
                :disabled="processing || cartItems.length === 0"
                class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors mb-4"
              >
                <span v-if="processing">{{ t('processing') }}...</span>
                <span v-else>{{ t('proceed_to_checkout') }}</span>
              </button>

              <!-- Payment Options -->
              <div class="text-center text-sm text-gray-600 mb-4">
                <p>{{ t('secure_checkout_with') }}:</p>
                <div class="flex justify-center space-x-2 mt-2">
                  <span class="px-2 py-1 bg-white rounded border text-xs">VISA</span>
                  <span class="px-2 py-1 bg-white rounded border text-xs">MC</span>
                  <span class="px-2 py-1 bg-white rounded border text-xs">AMEX</span>
                  <span class="px-2 py-1 bg-white rounded border text-xs">PayPal</span>
                </div>
              </div>

              <!-- Save for Later -->
              <button
                v-if="$page.props.auth.user"
                @click="saveForLater"
                class="w-full text-gray-600 hover:text-gray-800 py-2 text-sm font-medium border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
              >
                {{ t('save_cart_later') }}
              </button>
            </div>
          </div>
        </div>

        <!-- Recommended Products -->
        <div v-if="recommendedProducts.length > 0" class="mt-16">
          <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ t('you_might_like') }}</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
              v-for="product in recommendedProducts"
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
                <div class="flex items-center justify-between">
                  <span class="text-lg font-bold text-gray-900">${{ getDisplayPrice(product) }}</span>
                  <button
                    @click="addToCart(product.id)"
                    class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors"
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
  </ShopLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { 
  ShoppingCartIcon, 
  MinusIcon, 
  PlusIcon, 
  TrashIcon,
  TruckIcon 
} from '@heroicons/vue/24/outline'
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
  vip_buyer_price?: number
  commercial_buyer_price?: number
  discount_price?: number
  category: Category
}

interface CartItem {
  id: number
  product: Product
  quantity: number
}

interface Props {
  categories: Category[]
  cartItems: CartItem[]
  recommendedProducts: Product[]
}

const props = defineProps<Props>()

const processing = ref(false)

// Computed values
const subtotal = computed(() => {
  return props.cartItems.reduce((sum, item) => {
    return sum + (parseFloat(getDisplayPrice(item.product)) * item.quantity)
  }, 0).toFixed(2)
})

const shipping = computed(() => {
  return parseFloat(subtotal.value) >= 99 ? 0 : 12.99
})

const tax = computed(() => {
  return (parseFloat(subtotal.value) * 0.085).toFixed(2)
})

const total = computed(() => {
  return (parseFloat(subtotal.value) + shipping.value + parseFloat(tax.value)).toFixed(2)
})

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

const updateQuantity = async (itemId: number, newQuantity: number) => {
  if (newQuantity < 1) return
  
  try {
    await router.patch(route('cart.update', itemId), {
      quantity: newQuantity
    })
  } catch (error) {
    console.error('Failed to update quantity:', error)
  }
}

const removeItem = async (itemId: number) => {
  try {
    await router.delete(route('cart.remove', itemId))
  } catch (error) {
    console.error('Failed to remove item:', error)
  }
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

const proceedToCheckout = async () => {
  processing.value = true
  
  try {
    await router.get(route('checkout'))
  } catch (error) {
    console.error('Failed to proceed to checkout:', error)
  } finally {
    processing.value = false
  }
}

const saveForLater = async () => {
  try {
    await router.post(route('cart.save'))
  } catch (error) {
    console.error('Failed to save cart:', error)
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