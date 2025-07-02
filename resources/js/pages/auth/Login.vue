<script setup lang="ts">
import StoreAuthLayout from '@/layouts/StoreAuthLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <StoreAuthLayout title="Sign In" description="Welcome back! Enter your credentials to access your account">
        <Head title="Sign In" />

        <div v-if="status" class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input
                    id="email"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="Enter your email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.email }"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-green-600 hover:text-green-700">
                        Forgot password?
                    </Link>
                </div>
                <input
                    id="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    v-model="form.password"
                    placeholder="Enter your password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div class="flex items-center">
                <input
                    id="remember"
                    type="checkbox"
                    v-model="form.remember"
                    class="h-4 w-4 text-green-600 focus:ring-green-600 border-gray-300 rounded"
                />
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Remember me
                </label>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                <span v-if="form.processing">Signing in...</span>
                <span v-else>Sign In</span>
            </button>

            <div class="text-center text-sm text-gray-600">
                Don't have an account?
                <Link :href="route('register')" class="text-green-600 hover:text-green-700 font-medium">
                    Sign up here
                </Link>
            </div>
        </form>
    </StoreAuthLayout>
</template>
