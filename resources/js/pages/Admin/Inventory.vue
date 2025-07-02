<template>
  <StoreAdminLayout pageTitle="Inventory">
    <div>
      <!-- Header Actions -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <p class="text-gray-600">Track stock levels and manage inventory</p>
        </div>
        <div class="flex space-x-3">
          <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
            Export Report
          </button>
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Import CSV
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            Stock Adjustment
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-blue-600 text-sm">📦</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Products</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalProducts }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-red-600 text-sm">⚠️</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Low Stock</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.lowStock }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-yellow-600 text-sm">📊</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Value</p>
              <p class="text-2xl font-bold text-gray-900">${{ stats.totalValue }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-green-600 text-sm">✅</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">In Stock</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.inStock }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Bar -->
      <div class="bg-white rounded-lg shadow mb-6 p-4">
        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-60">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search inventory..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 text-gray-900 bg-white placeholder-gray-500"
            />
          </div>
          <select v-model="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Categories</option>
            <option value="hardwood">Hardwood</option>
            <option value="vinyl">Vinyl</option>
            <option value="laminate">Laminate</option>
            <option value="tile">Tile</option>
          </select>
          <select v-model="stockFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Stock Levels</option>
            <option value="in_stock">In Stock</option>
            <option value="low_stock">Low Stock</option>
            <option value="out_of_stock">Out of Stock</option>
          </select>
        </div>
      </div>

      <!-- Inventory Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Stock Management</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Cost</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Value</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="item in filteredInventory" :key="item.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                      <span class="text-gray-500 text-xs">IMG</span>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ item.name }}</div>
                      <div class="text-sm text-gray-500">SKU: {{ item.sku }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ item.category }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    item.currentStock === 0 ? 'bg-red-100 text-red-800' :
                    item.currentStock <= item.minStock ? 'bg-yellow-100 text-yellow-800' :
                    'bg-green-100 text-green-800'
                  ]">
                    {{ item.currentStock }} units
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ item.minStock }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ item.unitCost }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  ${{ (item.currentStock * parseFloat(item.unitCost)).toFixed(2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-green-600 hover:text-green-900 mr-3">Adjust</button>
                  <button class="text-blue-600 hover:text-blue-900 mr-3">Reorder</button>
                  <button class="text-gray-600 hover:text-gray-900">History</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing 1 to {{ Math.min(10, filteredInventory.length) }} of {{ filteredInventory.length }} results
            </div>
            <div class="flex space-x-2">
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Previous</button>
              <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">1</button>
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
const stockFilter = ref('')

const stats = ref({
  totalProducts: 156,
  lowStock: 12,
  totalValue: '45,230',
  inStock: 144
})

// Mock data
const inventory = ref([
  { 
    id: 1, 
    name: 'Oak Hardwood Flooring', 
    sku: 'OAK-001', 
    category: 'Hardwood', 
    currentStock: 150, 
    minStock: 20,
    unitCost: '6.50'
  },
  { 
    id: 2, 
    name: 'Luxury Vinyl Plank', 
    sku: 'LVP-002', 
    category: 'Vinyl', 
    currentStock: 5, 
    minStock: 25,
    unitCost: '3.99'
  },
  { 
    id: 3, 
    name: 'Bamboo Flooring', 
    sku: 'BAM-003', 
    category: 'Bamboo', 
    currentStock: 75, 
    minStock: 15,
    unitCost: '5.25'
  },
  { 
    id: 4, 
    name: 'Ceramic Tile', 
    sku: 'CER-004', 
    category: 'Tile', 
    currentStock: 0, 
    minStock: 50,
    unitCost: '2.99'
  },
  { 
    id: 5, 
    name: 'Laminate Wood Look', 
    sku: 'LAM-005', 
    category: 'Laminate', 
    currentStock: 200, 
    minStock: 30,
    unitCost: '2.50'
  },
])

const filteredInventory = computed(() => {
  let filtered = inventory.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(item => 
      item.name.toLowerCase().includes(query) || 
      item.sku.toLowerCase().includes(query)
    )
  }

  if (categoryFilter.value) {
    filtered = filtered.filter(item => item.category.toLowerCase() === categoryFilter.value)
  }

  if (stockFilter.value) {
    if (stockFilter.value === 'out_of_stock') {
      filtered = filtered.filter(item => item.currentStock === 0)
    } else if (stockFilter.value === 'low_stock') {
      filtered = filtered.filter(item => item.currentStock > 0 && item.currentStock <= item.minStock)
    } else if (stockFilter.value === 'in_stock') {
      filtered = filtered.filter(item => item.currentStock > item.minStock)
    }
  }

  return filtered
})
</script>