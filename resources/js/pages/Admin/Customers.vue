<template>
  <StoreAdminLayout :pageTitle="t('customers')">
    <div>
      <!-- Header Actions -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <p class="text-gray-600">{{ t('manage_customer_accounts') }}</p>
        </div>
        <div class="flex space-x-3">
          <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
            {{ t('export_customers') }}
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            {{ t('add_customer') }}
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-blue-600 text-sm">👥</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">{{ t('total_customers') }}</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalCustomers }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-green-600 text-sm">🆕</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">{{ t('new_this_month') }}</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.newThisMonth }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-purple-600 text-sm">⭐</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">{{ t('vip_customers') }}</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.vipCustomers }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-yellow-600 text-sm">💰</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">{{ t('avg_order_value') }}</p>
              <p class="text-2xl font-bold text-gray-900">${{ stats.avgOrderValue }}</p>
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
              :placeholder="t('search_customers')"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 text-gray-900 bg-white placeholder-gray-500"
            />
          </div>
          <select v-model="roleFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">{{ t('all_roles') }}</option>
            <option value="buyer">{{ t('buyer') }}</option>
            <option value="vip_buyer">{{ t('vip_buyer') }}</option>
            <option value="commercial_buyer">{{ t('commercial_buyer') }}</option>
          </select>
          <select v-model="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>

      <!-- Customers Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">{{ t('customer_database') }}</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('customer') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('role') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('orders') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('total_spent') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('last_order') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('status') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="customer in filteredCustomers" :key="customer.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                      <span class="text-gray-600 text-sm font-medium">{{ customer.name.charAt(0) }}</span>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ customer.name }}</div>
                      <div class="text-sm text-gray-500">{{ customer.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    customer.role === 'vip_buyer' ? 'bg-purple-100 text-purple-800' :
                    customer.role === 'commercial_buyer' ? 'bg-blue-100 text-blue-800' :
                    'bg-gray-100 text-gray-800'
                  ]">
                    {{ customer.role.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ customer.orderCount }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ customer.totalSpent }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ customer.lastOrder }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    customer.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                  ]">
                    {{ t(customer.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-green-600 hover:text-green-900 mr-3">{{ t('view') }}</button>
                  <button class="text-blue-600 hover:text-blue-900 mr-3">{{ t('edit') }}</button>
                  <button class="text-gray-600 hover:text-gray-900">{{ t('message') }}</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              {{ t('showing_results', { from: 1, to: Math.min(10, filteredCustomers.length), total: filteredCustomers.length }) }}
            </div>
            <div class="flex space-x-2">
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">{{ t('previous') }}</button>
              <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">1</button>
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">2</button>
              <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">{{ t('next') }}</button>
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
import { useLocale } from '@/composables/useLocale'

const { t } = useLocale()

const searchQuery = ref('')
const roleFilter = ref('')
const statusFilter = ref('')

const stats = ref({
  totalCustomers: 1248,
  newThisMonth: 67,
  vipCustomers: 89,
  avgOrderValue: '425'
})

// Mock data
const customers = ref([
  { 
    id: 1, 
    name: 'John Smith', 
    email: 'john@example.com', 
    role: 'buyer', 
    orderCount: 3, 
    totalSpent: '2,450.00', 
    lastOrder: '2025-01-15',
    status: 'active'
  },
  { 
    id: 2, 
    name: 'Sarah Johnson', 
    email: 'sarah@example.com', 
    role: 'vip_buyer', 
    orderCount: 12, 
    totalSpent: '15,230.50', 
    lastOrder: '2025-01-14',
    status: 'active'
  },
  { 
    id: 3, 
    name: 'Mike Brown', 
    email: 'mike@example.com', 
    role: 'commercial_buyer', 
    orderCount: 8, 
    totalSpent: '45,750.00', 
    lastOrder: '2025-01-13',
    status: 'active'
  },
  { 
    id: 4, 
    name: 'Emily Davis', 
    email: 'emily@example.com', 
    role: 'buyer', 
    orderCount: 1, 
    totalSpent: '890.25', 
    lastOrder: '2025-01-12',
    status: 'active'
  },
  { 
    id: 5, 
    name: 'David Wilson', 
    email: 'david@example.com', 
    role: 'buyer', 
    orderCount: 0, 
    totalSpent: '0.00', 
    lastOrder: 'Never',
    status: 'inactive'
  },
])

const filteredCustomers = computed(() => {
  let filtered = customers.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(customer => 
      customer.name.toLowerCase().includes(query) || 
      customer.email.toLowerCase().includes(query)
    )
  }

  if (roleFilter.value) {
    filtered = filtered.filter(customer => customer.role === roleFilter.value)
  }

  if (statusFilter.value) {
    filtered = filtered.filter(customer => customer.status === statusFilter.value)
  }

  return filtered
})
</script>