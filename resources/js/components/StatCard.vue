<template>
  <div :class="[
    'bg-white rounded-lg shadow p-6',
    highlight ? 'ring-2 ring-red-500' : ''
  ]">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600">{{ title }}</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ formattedValue }}</p>
        <p v-if="subtitle" class="text-sm text-gray-500 mt-1">{{ subtitle }}</p>
      </div>
      <div :class="[
        'w-12 h-12 rounded-lg flex items-center justify-center text-2xl',
        colorClasses
      ]">
        {{ icon }}
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  title: string
  value: number
  subtitle?: string
  icon: string
  color?: 'blue' | 'green' | 'purple' | 'yellow' | 'red'
  highlight?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  color: 'blue',
  highlight: false
})

const formattedValue = computed(() => {
  if (props.value >= 1000000) {
    return (props.value / 1000000).toFixed(1) + 'M'
  } else if (props.value >= 1000) {
    return (props.value / 1000).toFixed(1) + 'K'
  }
  return props.value.toString()
})

const colorClasses = computed(() => {
  const colors = {
    blue: 'bg-blue-100 text-blue-600',
    green: 'bg-green-100 text-green-600',
    purple: 'bg-purple-100 text-purple-600',
    yellow: 'bg-yellow-100 text-yellow-600',
    red: 'bg-red-100 text-red-600'
  }
  return colors[props.color]
})
</script>