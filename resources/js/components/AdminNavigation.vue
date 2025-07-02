<template>
  <!-- Vertical Sidebar Navigation -->
  <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center h-16 px-6 border-b border-gray-200">
      <Link :href="route('admin.dashboard')" class="flex items-center space-x-2">
        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
          <span class="text-white font-bold text-sm">EF</span>
        </div>
        <div>
          <span class="text-lg font-bold text-gray-900">Ecos Flooring</span>
          <span class="block text-xs text-gray-500">Admin Panel</span>
        </div>
      </Link>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-6 px-3">
      <div class="space-y-1">
        <a href="/admin/dashboard" 
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <LayoutGrid class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Dashboard
        </a>
        <a href="/admin/products" 
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <Package class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Products
        </a>
        <a href="/admin/orders" 
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <ShoppingCart class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Orders
        </a>
        <a href="/admin/inventory" 
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <BarChart3 class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Inventory
        </a>
        <a href="/admin/customers" 
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <Users class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Customers
        </a>
        <a href="/admin/messages" 
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <MessageSquare class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Messages
        </a>
      </div>
    </nav>

    <!-- Bottom Section -->
    <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-gray-200">
      <div class="space-y-2">
        <Link :href="route('home')" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
          <Store class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
          Back to Store
        </Link>
        
        <div class="relative group">
          <button class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
            <UserIcon class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
            <span class="truncate">{{ $page.props.auth.user.name }}</span>
            <ChevronDownIcon class="h-4 w-4 ml-auto" />
          </button>
          <div class="absolute bottom-full left-0 right-0 mb-1 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <Link :href="route('profile.edit')"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-t-md">
              Profile Settings
            </Link>
            <Link :href="route('logout')" method="post" as="button"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 border-t rounded-b-md">
              Sign Out
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Overlay -->
  <div v-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"></div>
  
  <!-- Mobile Sidebar -->
  <div v-show="mobileMenuOpen" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200 md:hidden">
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
      <Link :href="route('admin.dashboard')" class="flex items-center space-x-2">
        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
          <span class="text-white font-bold text-sm">EF</span>
        </div>
        <div>
          <span class="text-lg font-bold text-gray-900">Ecos Flooring</span>
          <span class="block text-xs text-gray-500">Admin Panel</span>
        </div>
      </Link>
      <button @click="mobileMenuOpen = false" class="p-2 text-gray-700">
        <XMarkIcon class="h-6 w-6" />
      </button>
    </div>

    <nav class="mt-6 px-3">
      <div class="space-y-1">
        <a href="/admin/dashboard" @click="mobileMenuOpen = false"
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
          <LayoutGrid class="h-5 w-5 mr-3" />Dashboard
        </a>
        <a href="/admin/products" @click="mobileMenuOpen = false"
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
          <Package class="h-5 w-5 mr-3" />Products
        </a>
        <a href="/admin/orders" @click="mobileMenuOpen = false"
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
          <ShoppingCart class="h-5 w-5 mr-3" />Orders
        </a>
        <a href="/admin/inventory" @click="mobileMenuOpen = false"
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
          <BarChart3 class="h-5 w-5 mr-3" />Inventory
        </a>
        <a href="/admin/customers" @click="mobileMenuOpen = false"
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
          <Users class="h-5 w-5 mr-3" />Customers
        </a>
        <a href="/admin/messages" @click="mobileMenuOpen = false"
              class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
          <MessageSquare class="h-5 w-5 mr-3" />Messages
        </a>
      </div>
    </nav>
  </div>

  <!-- Mobile Menu Button -->
  <button @click="mobileMenuOpen = !mobileMenuOpen" class="fixed top-4 left-4 z-40 p-2 bg-white rounded-md shadow-md md:hidden">
    <Bars3Icon v-if="!mobileMenuOpen" class="h-6 w-6 text-gray-700" />
    <XMarkIcon v-else class="h-6 w-6 text-gray-700" />
  </button>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { 
  Squares2X2Icon as LayoutGrid, 
  CubeIcon as Package, 
  ShoppingCartIcon as ShoppingCart, 
  ChartBarIcon as BarChart3, 
  UsersIcon as Users, 
  ChatBubbleLeftRightIcon as MessageSquare,
  BuildingStorefrontIcon as Store,
  UserIcon,
  ChevronDownIcon,
  Bars3Icon,
  XMarkIcon
} from '@heroicons/vue/24/outline'

const mobileMenuOpen = ref(false)
</script>