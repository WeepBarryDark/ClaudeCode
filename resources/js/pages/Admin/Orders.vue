<template>
  <StoreAdminLayout pageTitle="Orders">
    <div>
      <!-- Header Actions -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <p class="text-gray-600">Track and manage customer orders</p>
        </div>
        <div class="flex space-x-3">
          <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
            Export Orders
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            New Order
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
              placeholder="Search orders by number or customer..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 text-gray-900 bg-white placeholder-gray-500"
            />
          </div>
          <select v-model="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
          </select>
          <input
            type="date"
            v-model="dateFilter"
            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white"
          />
        </div>
      </div>

      <!-- Orders Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Order Management</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div>
                    <div class="text-sm font-medium text-gray-900">#{{ order.orderNumber }}</div>
                    <div class="text-sm text-gray-500">{{ order.items }} items</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ order.customerName }}</div>
                    <div class="text-sm text-gray-500">{{ order.customerEmail }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ order.date }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ order.total }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    order.status === 'processing' ? 'bg-blue-100 text-blue-800' :
                    order.status === 'shipped' ? 'bg-green-100 text-green-800' :
                    order.status === 'delivered' ? 'bg-green-100 text-green-800' :
                    'bg-red-100 text-red-800'
                  ]">
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-green-600 hover:text-green-900 mr-3">View</button>
                  <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                  <button class="text-gray-600 hover:text-gray-900">Print</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing 1 to {{ Math.min(10, filteredOrders.length) }} of {{ filteredOrders.length }} results
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
const statusFilter = ref('')
const dateFilter = ref('')

// Mock data
const orders = ref([
  { 
    id: 1, 
    orderNumber: 'ORD-001', 
    customerName: 'John Smith', 
    customerEmail: 'john@example.com',
    date: '2025-01-15', 
    total: '2,450.00', 
    items: 3, 
    status: 'pending' 
  },
  { 
    id: 2, 
    orderNumber: 'ORD-002', 
    customerName: 'Sarah Johnson', 
    customerEmail: 'sarah@example.com',
    date: '2025-01-14', 
    total: '1,200.50', 
    items: 2, 
    status: 'processing' 
  },
  { 
    id: 3, 
    orderNumber: 'ORD-003', 
    customerName: 'Mike Brown', 
    customerEmail: 'mike@example.com',
    date: '2025-01-13', 
    total: '3,750.00', 
    items: 5, 
    status: 'shipped' 
  },
  { 
    id: 4, 
    orderNumber: 'ORD-004', 
    customerName: 'Emily Davis', 
    customerEmail: 'emily@example.com',
    date: '2025-01-12', 
    total: '890.25', 
    items: 1, 
    status: 'delivered' 
  },
  { 
    id: 5, 
    orderNumber: 'ORD-005', 
    customerName: 'David Wilson', 
    customerEmail: 'david@example.com',
    date: '2025-01-11', 
    total: '156.00', 
    items: 1, 
    status: 'cancelled' 
  },
])

const filteredOrders = computed(() => {
  let filtered = orders.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(o => 
      o.orderNumber.toLowerCase().includes(query) || 
      o.customerName.toLowerCase().includes(query) ||
      o.customerEmail.toLowerCase().includes(query)
    )
  }

  if (statusFilter.value) {
    filtered = filtered.filter(o => o.status === statusFilter.value)
  }

  if (dateFilter.value) {
    filtered = filtered.filter(o => o.date === dateFilter.value)
  }

  return filtered
})
</script>