<template>
  <StoreAdminLayout pageTitle="Messages">
    <div>
      <!-- Header Actions -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <p class="text-gray-600">Customer inquiries and support messages</p>
        </div>
        <div class="flex space-x-3">
          <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
            Mark All Read
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            Compose Message
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-yellow-600 text-sm">📧</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Messages</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalMessages }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-red-600 text-sm">🔴</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Unread</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.unreadMessages }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-green-600 text-sm">✅</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Resolved Today</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.resolvedToday }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
              <span class="text-blue-600 text-sm">⏱️</span>
            </div>
            <div>
              <p class="text-sm text-gray-600">Avg Response Time</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.avgResponseTime }}</p>
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
              placeholder="Search messages..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 text-gray-900 bg-white placeholder-gray-500"
            />
          </div>
          <select v-model="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Categories</option>
            <option value="general">General Inquiry</option>
            <option value="product_inquiry">Product Information</option>
            <option value="sample_request">Sample Request</option>
            <option value="installation">Installation Services</option>
            <option value="warranty">Warranty Claim</option>
            <option value="complaint">Complaint</option>
          </select>
          <select v-model="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-900 bg-white">
            <option value="">All Status</option>
            <option value="unread">Unread</option>
            <option value="read">Read</option>
            <option value="replied">Replied</option>
            <option value="resolved">Resolved</option>
          </select>
        </div>
      </div>

      <!-- Messages Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Customer Messages</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="message in filteredMessages" :key="message.id" 
                  :class="{ 'bg-blue-50': message.status === 'unread' }"
                  class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                      <span class="text-gray-600 text-sm font-medium">{{ message.customerName.charAt(0) }}</span>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ message.customerName }}</div>
                      <div class="text-sm text-gray-500">{{ message.customerEmail }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    message.category === 'complaint' ? 'bg-red-100 text-red-800' :
                    message.category === 'warranty' ? 'bg-yellow-100 text-yellow-800' :
                    message.category === 'product_inquiry' ? 'bg-blue-100 text-blue-800' :
                    'bg-gray-100 text-gray-800'
                  ]">
                    {{ message.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ message.subject }}</div>
                  <div class="text-sm text-gray-500 truncate max-w-xs">{{ message.preview }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ message.date }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    message.status === 'unread' ? 'bg-red-100 text-red-800' :
                    message.status === 'read' ? 'bg-yellow-100 text-yellow-800' :
                    message.status === 'replied' ? 'bg-blue-100 text-blue-800' :
                    'bg-green-100 text-green-800'
                  ]">
                    {{ message.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-green-600 hover:text-green-900 mr-3">Reply</button>
                  <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                  <button class="text-gray-600 hover:text-gray-900">Mark Read</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing 1 to {{ Math.min(10, filteredMessages.length) }} of {{ filteredMessages.length }} results
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

const stats = ref({
  totalMessages: 342,
  unreadMessages: 23,
  resolvedToday: 15,
  avgResponseTime: '2.5h'
})

// Mock data
const messages = ref([
  { 
    id: 1, 
    customerName: 'John Smith', 
    customerEmail: 'john@example.com',
    category: 'product_inquiry',
    subject: 'Question about hardwood installation',
    preview: 'I\'m interested in oak hardwood flooring for my living room...',
    date: '2025-01-15 10:30',
    status: 'unread'
  },
  { 
    id: 2, 
    customerName: 'Sarah Johnson', 
    customerEmail: 'sarah@example.com',
    category: 'sample_request',
    subject: 'Need samples for bathroom renovation',
    preview: 'Could you please send me samples of your waterproof vinyl...',
    date: '2025-01-15 09:15',
    status: 'replied'
  },
  { 
    id: 3, 
    customerName: 'Mike Brown', 
    customerEmail: 'mike@example.com',
    category: 'complaint',
    subject: 'Issue with recent order delivery',
    preview: 'My order #ORD-003 was delivered damaged and I need...',
    date: '2025-01-14 16:45',
    status: 'resolved'
  },
  { 
    id: 4, 
    customerName: 'Emily Davis', 
    customerEmail: 'emily@example.com',
    category: 'installation',
    subject: 'Installation service inquiry',
    preview: 'I would like to schedule installation for my recent purchase...',
    date: '2025-01-14 14:20',
    status: 'read'
  },
  { 
    id: 5, 
    customerName: 'David Wilson', 
    customerEmail: 'david@example.com',
    category: 'warranty',
    subject: 'Warranty claim for laminate flooring',
    preview: 'I purchased laminate flooring 6 months ago and noticed...',
    date: '2025-01-14 11:35',
    status: 'unread'
  },
])

const filteredMessages = computed(() => {
  let filtered = messages.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(message => 
      message.customerName.toLowerCase().includes(query) || 
      message.customerEmail.toLowerCase().includes(query) ||
      message.subject.toLowerCase().includes(query) ||
      message.preview.toLowerCase().includes(query)
    )
  }

  if (categoryFilter.value) {
    filtered = filtered.filter(message => message.category === categoryFilter.value)
  }

  if (statusFilter.value) {
    filtered = filtered.filter(message => message.status === statusFilter.value)
  }

  return filtered
})
</script>