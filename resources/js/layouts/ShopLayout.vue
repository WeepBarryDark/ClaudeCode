<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Shared Store Navigation -->
    <StoreNavigation :categories="categories" />

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <div class="flex items-center space-x-2 mb-4">
              <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">EF</span>
              </div>
              <span class="text-xl font-bold">Ecos Flooring</span>
            </div>
            <p class="text-gray-400 text-sm">
              Premium flooring solutions for your home and business. Quality materials, expert installation, and exceptional service.
            </p>
          </div>
          <div>
            <h3 class="font-semibold mb-4">Products</h3>
            <ul class="space-y-2 text-sm text-gray-400">
              <li><Link :href="route('products')" class="hover:text-white transition-colors">All Flooring</Link></li>
              <li v-for="category in categories.slice(0, 4)" :key="category.id">
                <Link :href="route('products.category', category.slug)" class="hover:text-white transition-colors">
                  {{ category.name }}
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold mb-4">Services</h3>
            <ul class="space-y-2 text-sm text-gray-400">
              <li><Link :href="route('samples')" class="hover:text-white transition-colors">Free Samples</Link></li>
              <li><a href="#" class="hover:text-white transition-colors">Installation</a></li>
              <li><a href="#" class="hover:text-white transition-colors">Consultation</a></li>
              <li><a href="#" class="hover:text-white transition-colors">Warranty</a></li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold mb-4">Contact</h3>
            <ul class="space-y-2 text-sm text-gray-400">
              <li>Phone: (555) 123-4567</li>
              <li>Email: info@ecosflooring.com</li>
              <li>Mon-Fri: 8AM-6PM</li>
              <li>Sat: 9AM-4PM</li>
            </ul>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
          <p>&copy; 2025 Ecos Flooring. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Live Chat Widget -->
    <LiveChat />
  </div>
</template>

<script setup lang="ts">
import StoreNavigation from '@/components/StoreNavigation.vue'
import LiveChat from '@/components/LiveChat.vue'

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
</script>