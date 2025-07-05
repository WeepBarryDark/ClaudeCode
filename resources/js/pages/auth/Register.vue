<script setup lang="ts">
import StoreAuthLayout from '@/layouts/StoreAuthLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { useLocale } from '@/composables/useLocale';

const { t } = useLocale();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <StoreAuthLayout :title="t('sign_up')" :description="t('create_account')">
        <Head :title="t('sign_up')" />

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ t('full_name') }}</label>
                <input
                    id="name"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    v-model="form.name"
                    :placeholder="t('full_name')"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.name }"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ t('email_address') }}</label>
                <input
                    id="email"
                    type="email"
                    required
                    autocomplete="email"
                    v-model="form.email"
                    :placeholder="t('email_address')"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.email }"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ t('password') }}</label>
                <input
                    id="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    v-model="form.password"
                    :placeholder="t('password')"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ t('confirm_password') }}</label>
                <input
                    id="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    v-model="form.password_confirmation"
                    :placeholder="t('confirm_password')"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.password_confirmation }"
                />
                <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                <span v-if="form.processing">{{ t('processing') }}...</span>
                <span v-else>{{ t('create_account_button') }}</span>
            </button>

            <div class="text-center text-sm text-gray-600">
                {{ t('already_have_account') }}
                <Link :href="route('login')" class="text-green-600 hover:text-green-700 font-medium">
                    {{ t('sign_in') }}
                </Link>
            </div>
        </form>
    </StoreAuthLayout>
</template>
