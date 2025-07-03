<template>
  <!-- Navigation Header -->
  <nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <Link :href="route('home')" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-sm">EF</span>
            </div>
            <span class="text-xl font-bold text-gray-900">{{ t('ecos_flooring') }}</span>
          </Link>
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-8">
          <Link :href="route('home')" 
                class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors"
                :class="{ 'text-green-600 border-b-2 border-green-600': route().current('home') }">
            {{ t('home') }}
          </Link>
          <div class="relative group">
            <button class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors flex items-center">
              {{ t('flooring_products') }}
              <ChevronDownIcon class="ml-1 h-4 w-4" />
            </button>
            <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
              <Link v-for="category in categories" :key="category.id"
                    :href="route('products.category', category.slug)"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600">
                {{ category.name }}
              </Link>
              <Link :href="route('products')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 border-t">
                {{ t('view_all_products') }}
              </Link>
            </div>
          </div>
          <Link :href="route('samples')" 
                class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors"
                :class="{ 'text-green-600 border-b-2 border-green-600': route().current('samples') }">
            {{ t('order_samples') }}
          </Link>
          <Link :href="route('contact')" 
                class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors"
                :class="{ 'text-green-600 border-b-2 border-green-600': route().current('contact') }">
            {{ t('contact_us') }}
          </Link>
          <Link :href="route('about')" 
                class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors"
                :class="{ 'text-green-600 border-b-2 border-green-600': route().current('about') }">
            {{ t('about_us') }}
          </Link>
        </div>

        <!-- Cart & Auth -->
        <div class="flex items-center space-x-4">
          <!-- Language Selector -->
          <LanguageSelector />
          
          <Link :href="route('cart')" class="relative p-2 text-gray-700 hover:text-green-600 transition-colors">
            <ShoppingCartIcon class="h-6 w-6" />
            <span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
              {{ cartCount }}
            </span>
          </Link>
          
          <div v-if="$page.props.auth.user" class="relative group">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-green-600 transition-colors">
              <UserIcon class="h-5 w-5" />
              <span class="text-sm">{{ $page.props.auth.user.name }}</span>
            </button>
            <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
              <Link :href="route('admin.dashboard')" 
                    v-if="$page.props.auth.user && ['shop_manager', 'supervisor', 'admin', 'super_admin'].includes($page.props.auth.user.role)"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">
                {{ t('admin_dashboard') }}
              </Link>
              <Link :href="route('profile.edit')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">
                {{ t('profile_settings') }}
              </Link>
              <Link :href="route('logout')" method="post" as="button"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 border-t">
                {{ t('sign_out') }}
              </Link>
            </div>
          </div>
          
          <div v-else class="flex items-center space-x-2">
            <Link :href="route('login')" class="text-sm text-gray-700 hover:text-green-600 transition-colors">
              {{ t('sign_in') }}
            </Link>
            <Link :href="route('register')" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 transition-colors">
              {{ t('sign_up') }}
            </Link>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-gray-700">
            <Bars3Icon v-if="!mobileMenuOpen" class="h-6 w-6" />
            <XMarkIcon v-else class="h-6 w-6" />
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-show="mobileMenuOpen" class="md:hidden border-t border-gray-200 pt-4 pb-3">
        <div class="space-y-2">
          <Link :href="route('home')" class="block px-3 py-2 text-gray-700 hover:text-green-600">{{ t('home') }}</Link>
          <Link :href="route('products')" class="block px-3 py-2 text-gray-700 hover:text-green-600">{{ t('view_all_products') }}</Link>
          <Link v-for="category in categories" :key="category.id"
                :href="route('products.category', category.slug)"
                class="block px-6 py-2 text-sm text-gray-600 hover:text-green-600">
            {{ category.name }}
          </Link>
          <Link :href="route('samples')" class="block px-3 py-2 text-gray-700 hover:text-green-600">{{ t('order_samples') }}</Link>
          <Link :href="route('contact')" class="block px-3 py-2 text-gray-700 hover:text-green-600">{{ t('contact_us') }}</Link>
          <Link :href="route('about')" class="block px-3 py-2 text-gray-700 hover:text-green-600">{{ t('about_us') }}</Link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { 
  ChevronDownIcon, 
  ShoppingCartIcon, 
  UserIcon, 
  Bars3Icon, 
  XMarkIcon 
} from '@heroicons/vue/24/outline'
import LanguageSelector from './LanguageSelector.vue'
import { useLocale } from '@/composables/useLocale'

interface Category {
  id: number
  name: string
  slug: string
}

interface Props {
  categories?: Category[]
}

const props = withDefaults(defineProps<Props>(), {
  categories: () => []
})

const { t } = useLocale()
const mobileMenuOpen = ref(false)

const cartCount = computed(() => {
  // This would come from a cart store/composable
  return 0
})
</script>