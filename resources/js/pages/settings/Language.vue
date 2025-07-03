<template>
  <div class="space-y-6">
    <div>
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ t('timezone') }}</h2>
      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Manage your timezone preferences. Language can be changed from the navigation bar.
      </p>
    </div>

    <form @submit.prevent="updateTimezone" class="space-y-6">
      <div>
        <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
          {{ t('timezone') }}
        </label>
        <select
          id="timezone"
          v-model="form.timezone"
          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
          <optgroup v-for="group in availableTimezones" :key="group.group" :label="group.group">
            <option v-for="zone in group.zones" :key="zone.code" :value="zone.code">
              {{ zone.name }}
            </option>
          </optgroup>
        </select>
        <p v-if="form.errors.timezone" class="mt-2 text-sm text-red-600 dark:text-red-400">
          {{ form.errors.timezone }}
        </p>
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          :disabled="form.processing"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
        >
          <svg
            v-if="form.processing"
            class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          {{ t('save_changes') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { defineProps } from 'vue'
import { useLocale } from '@/composables/useLocale'

interface Props {
  auth: {
    user: {
      id: number
      name: string
      email: string
      timezone: string
      locale: string
    }
  }
}

const props = defineProps<Props>()
const { t, availableLocales, availableTimezones } = useLocale()

const form = useForm({
  timezone: props.auth.user.timezone,
})

const updateTimezone = () => {
  form.put(route('settings.timezone.update'), {
    preserveScroll: true,
  })
}
</script>