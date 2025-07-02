<template>
  <StoreAdminLayout pageTitle="Dashboard">
    <div>
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ user.name }}! Here's what's happening with your store.</p>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <StatCard
          title="Total Products"
          :value="stats.total_products"
          :subtitle="`${stats.active_products} active`"
          icon="📦"
          color="blue"
        />
        <StatCard
          title="Total Orders"
          :value="stats.total_orders"
          :subtitle="`${stats.pending_orders} pending`"
          icon="📋"
          color="green"
        />
        <StatCard
          title="Customers"
          :value="stats.total_customers"
          subtitle="registered users"
          icon="👥"
          color="purple"
        />
        <StatCard
          title="Messages"
          :value="stats.unread_messages"
          subtitle="unread"
          icon="✉️"
          color="yellow"
          :highlight="stats.unread_messages > 0"
        />
      </div>

      <!-- Alerts -->
      <div v-if="stats.low_stock_products > 0" class="mb-8">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <ExclamationTriangleIcon class="h-5 w-5 text-red-400" />
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                Low Stock Alert
              </h3>
              <p class="text-sm text-red-700 mt-1">
                {{ stats.low_stock_products }} products are running low on stock.
                <Link :href="route('admin.inventory')" class="font-medium underline">
                  View inventory →
                </Link>
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
          </div>
          <div class="p-6">
            <div v-if="recentOrders.length === 0" class="text-center text-gray-500 py-4">
              No orders yet
            </div>
            <div v-else class="space-y-4">
              <div v-for="order in recentOrders" :key="order.id" 
                   class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                <div>
                  <p class="font-medium text-gray-900">#{{ order.order_number }}</p>
                  <p class="text-sm text-gray-600">{{ order.customer_name }}</p>
                  <p class="text-xs text-gray-500">{{ order.created_at }}</p>
                </div>
                <div class="text-right">
                  <p class="font-medium text-gray-900">${{ order.total_amount }}</p>
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    order.status === 'processing' ? 'bg-blue-100 text-blue-800' :
                    order.status === 'shipped' ? 'bg-green-100 text-green-800' :
                    'bg-gray-100 text-gray-800'
                  ]">
                    {{ order.status }}
                  </span>
                </div>
              </div>
            </div>
            <div class="mt-4 text-center">
              <Link :href="route('admin.orders.index')" 
                    class="text-green-600 hover:text-green-700 font-medium text-sm">
                View all orders →
              </Link>
            </div>
          </div>
        </div>

        <!-- Low Stock Products -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Low Stock Products</h2>
          </div>
          <div class="p-6">
            <div v-if="lowStockProducts.length === 0" class="text-center text-gray-500 py-4">
              All products are well stocked!
            </div>
            <div v-else class="space-y-4">
              <div v-for="product in lowStockProducts" :key="product.id" 
                   class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                <div>
                  <p class="font-medium text-gray-900">{{ product.name }}</p>
                  <p class="text-sm text-gray-600">{{ product.category }} • {{ product.sku }}</p>
                </div>
                <div class="text-right">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    product.stock_quantity === 0 ? 'bg-red-100 text-red-800' :
                    product.stock_quantity < 5 ? 'bg-red-100 text-red-800' :
                    'bg-yellow-100 text-yellow-800'
                  ]">
                    {{ product.stock_quantity }} left
                  </span>
                </div>
              </div>
            </div>
            <div class="mt-4 text-center">
              <Link :href="route('admin.inventory')" 
                    class="text-green-600 hover:text-green-700 font-medium text-sm">
                Manage inventory →
              </Link>
            </div>
          </div>
        </div>

        <!-- Recent Inventory Transactions -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Inventory</h2>
          </div>
          <div class="p-6">
            <div v-if="recentTransactions.length === 0" class="text-center text-gray-500 py-4">
              No recent transactions
            </div>
            <div v-else class="space-y-4">
              <div v-for="transaction in recentTransactions" :key="transaction.id" 
                   class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                <div>
                  <p class="font-medium text-gray-900">{{ transaction.product_name }}</p>
                  <p class="text-sm text-gray-600">by {{ transaction.user_name }}</p>
                  <p class="text-xs text-gray-500">{{ transaction.created_at }}</p>
                </div>
                <div class="text-right">
                  <span :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                    transaction.type === 'import' ? 'bg-green-100 text-green-800' :
                    transaction.type === 'sale' ? 'bg-blue-100 text-blue-800' :
                    transaction.type === 'adjustment' ? 'bg-yellow-100 text-yellow-800' :
                    'bg-gray-100 text-gray-800'
                  ]">
                    {{ transaction.type }} {{ transaction.quantity }}
                  </span>
                </div>
              </div>
            </div>
            <div class="mt-4 text-center">
              <Link :href="route('admin.inventory.transactions')" 
                    class="text-green-600 hover:text-green-700 font-medium text-sm">
                View all transactions →
              </Link>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
          </div>
          <div class="p-6">
            <div class="space-y-3">
              <Link :href="route('admin.products.create')" 
                    class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                <PlusIcon class="h-5 w-5 text-green-600 mr-3" />
                <span class="text-green-700 font-medium">Add New Product</span>
              </Link>
              
              <Link :href="route('admin.inventory.import')" 
                    class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                <DocumentArrowUpIcon class="h-5 w-5 text-blue-600 mr-3" />
                <span class="text-blue-700 font-medium">Import Products</span>
              </Link>
              
              <Link :href="route('admin.customers')" 
                    class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                <UsersIcon class="h-5 w-5 text-purple-600 mr-3" />
                <span class="text-purple-700 font-medium">View Customers</span>
              </Link>
              
              <Link :href="route('admin.messages')" 
                    class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors group">
                <ChatBubbleLeftIcon class="h-5 w-5 text-yellow-600 mr-3" />
                <span class="text-yellow-700 font-medium">Customer Messages</span>
                <span v-if="stats.unread_messages > 0" 
                      class="ml-auto bg-yellow-200 text-yellow-800 text-xs px-2 py-1 rounded-full">
                  {{ stats.unread_messages }}
                </span>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </StoreAdminLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StoreAdminLayout from '@/layouts/StoreAdminLayout.vue'
import StatCard from '@/components/StatCard.vue'
import { 
  ExclamationTriangleIcon,
  PlusIcon,
  DocumentArrowUpIcon,
  UsersIcon,
  ChatBubbleLeftIcon
} from '@heroicons/vue/24/outline'

interface User {
  id: number
  name: string
  email: string
  role: string
}

interface Stats {
  total_products: number
  active_products: number
  total_categories: number
  total_orders: number
  pending_orders: number
  total_customers: number
  unread_messages: number
  low_stock_products: number
}

interface Order {
  id: number
  order_number: string
  customer_name: string
  status: string
  total_amount: number
  created_at: string
}

interface Product {
  id: number
  name: string
  sku: string
  category: string
  stock_quantity: number
}

interface Transaction {
  id: number
  product_name: string
  type: string
  quantity: number
  user_name: string
  created_at: string
}

interface Props {
  user: User
  stats: Stats
  recentOrders: Order[]
  lowStockProducts: Product[]
  recentTransactions: Transaction[]
  monthlySales: {
    labels: string[]
    data: number[]
  }
}

defineProps<Props>()
</script>