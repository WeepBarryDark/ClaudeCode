<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Shared Admin Navigation -->
    <AdminNavigation />

    <!-- Main Content Area (with left margin for sidebar) -->
    <div class="md:ml-64">
      <!-- Page Header -->
      <div v-if="pageTitle || breadcrumbs?.length" class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <!-- Breadcrumbs -->
          <nav v-if="breadcrumbs?.length" class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
              <li v-for="(breadcrumb, index) in breadcrumbs" :key="index" class="inline-flex items-center">
                <ChevronRightIcon v-if="index > 0" class="w-4 h-4 text-gray-400 mr-2" />
                <Link v-if="breadcrumb.href && index < breadcrumbs.length - 1" 
                      :href="breadcrumb.href" 
                      class="text-sm font-medium text-gray-500 hover:text-green-600">
                  {{ breadcrumb.label }}
                </Link>
                <span v-else class="text-sm font-medium text-gray-900">
                  {{ breadcrumb.label }}
                </span>
              </li>
            </ol>
          </nav>

          <!-- Page Title -->
          <div v-if="pageTitle" class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ pageTitle }}</h1>
            <div v-if="$slots.actions" class="flex items-center space-x-3">
              <slot name="actions" />
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import AdminNavigation from '@/components/AdminNavigation.vue'
import { ChevronRightIcon } from '@heroicons/vue/24/outline'

interface BreadcrumbItem {
  label: string
  href?: string
}

interface Props {
  pageTitle?: string
  breadcrumbs?: BreadcrumbItem[]
}

defineProps<Props>()
</script>