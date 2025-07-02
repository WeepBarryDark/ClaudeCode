<template>
  <StoreAdminLayout pageTitle="Products">
    <div>
      <!-- Header Actions -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <p class="text-gray-600">Manage your product catalog</p>
        </div>
        <div class="flex space-x-3">
          <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
            Import Products
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            Add Product
          </button>
        </div>
      </div>

      <!-- Filter Bar -->
      <div class="bg-white rounded-lg shadow mb-6 p-4">
        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-60">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search products..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 text-gray-900 bg-white placeholder-gray-500"
            />
          </div>
          <select v-model="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Categories</option>
            <option value="hardwood">Hardwood</option>
            <option value="vinyl">Vinyl</option>
            <option value="laminate">Laminate</option>
            <option value="tile">Tile</option>
            <option value="carpet">Carpet</option>
          </select>
          <select v-model="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="low_stock">Low Stock</option>
          </select>
        </div>
      </div>

      <!-- Products Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Product Inventory</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="product in filteredProducts" :key="product.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                      <span class="text-gray-500 text-xs">IMG</span>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                      <div class="text-sm text-gray-500">SKU: {{ product.sku }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.category }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ product.price }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    product.stock < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'
                  ]">
                    {{ product.stock }} units
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                  ]">
                    {{ product.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-green-600 hover:text-green-900 mr-3">Edit</button>
                  <button class="text-red-600 hover:text-red-900">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing 1 to {{ Math.min(10, filteredProducts.length) }} of {{ filteredProducts.length }} results
            </div>
            <div class="flex space-x-2">
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Previous</button>
              <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">1</button>
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">2</button>
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Next</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </StoreAdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import StoreAdminLayout from '@/layouts/StoreAdminLayout.vue'

const searchQuery = ref('')
const categoryFilter = ref('')
const statusFilter = ref('')

// Mock data
const products = ref([
  { id: 1, name: 'Oak Hardwood Flooring', sku: 'OAK-001', category: 'Hardwood', price: '8.99', stock: 150, status: 'active' },
  { id: 2, name: 'Luxury Vinyl Plank', sku: 'LVP-002', category: 'Vinyl', price: '4.99', stock: 5, status: 'active' },
  { id: 3, name: 'Bamboo Flooring', sku: 'BAM-003', category: 'Bamboo', price: '6.99', stock: 75, status: 'active' },
  { id: 4, name: 'Ceramic Tile', sku: 'CER-004', category: 'Tile', price: '3.99', stock: 200, status: 'inactive' },
  { id: 5, name: 'Laminate Wood Look', sku: 'LAM-005', category: 'Laminate', price: '2.99', stock: 0, status: 'active' },
])

const filteredProducts = computed(() => {
  let filtered = products.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(p => 
      p.name.toLowerCase().includes(query) || 
      p.sku.toLowerCase().includes(query)
    )
  }

  if (categoryFilter.value) {
    filtered = filtered.filter(p => p.category.toLowerCase() === categoryFilter.value)
  }

  if (statusFilter.value) {
    if (statusFilter.value === 'low_stock') {
      filtered = filtered.filter(p => p.stock < 10)
    } else {
      filtered = filtered.filter(p => p.status === statusFilter.value)
    }
  }

  return filtered
})
</script>