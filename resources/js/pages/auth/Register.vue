<script setup lang="ts">
import StoreAuthLayout from '@/layouts/StoreAuthLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

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
    <StoreAuthLayout title="Sign Up" description="Create your account to start shopping premium flooring solutions">
        <Head title="Sign Up" />

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input
                    id="name"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    v-model="form.name"
                    placeholder="Enter your full name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.name }"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input
                    id="email"
                    type="email"
                    required
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="Enter your email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.email }"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input
                    id="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    v-model="form.password"
                    placeholder="Create a secure password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-900 bg-white placeholder-gray-500"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    v-model="form.password_confirmation"
                    placeholder="Confirm your password"
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
                <span v-if="form.processing">Creating account...</span>
                <span v-else>Create Account</span>
            </button>

            <div class="text-center text-sm text-gray-600">
                Already have an account?
                <Link :href="route('login')" class="text-green-600 hover:text-green-700 font-medium">
                    Sign in here
                </Link>
            </div>
        </form>
    </StoreAuthLayout>
</template>
