<script setup lang="ts">
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3';
import { 
    BookOpen, 
    Folder, 
    LayoutGrid, 
    Package, 
    ShoppingCart, 
    Users, 
    MessageSquare, 
    BarChart3, 
    Settings,
    ArrowLeft,
    Store
} from 'lucide-vue-next';
import { type NavItem } from '@/types';
import { useLocale } from '@/composables/useLocale';
import LanguageSelector from '@/components/LanguageSelector.vue';

const page = usePage();
const mobileMenuOpen = ref(false);
const { t } = useLocale();

const mainNavItems: NavItem[] = [
    {
        title: t('dashboard'),
        href: '/admin/dashboard',
        icon: LayoutGrid,
    },
    {
        title: t('products'),
        href: '/admin/products',
        icon: Package,
    },
    {
        title: t('orders'),
        href: '/admin/orders',
        icon: ShoppingCart,
    },
    {
        title: t('inventory'),
        href: '/admin/inventory',
        icon: BarChart3,
    },
    {
        title: t('customers'),
        href: '/admin/customers',
        icon: Users,
    },
    {
        title: t('messages'),
        href: '/admin/messages',
        icon: MessageSquare,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: t('back_to_shop'),
        href: '/',
        icon: Store,
    },
    {
        title: t('settings'),
        href: '/settings/profile',
        icon: Settings,
    },
];
</script>

<template>
    <!-- Vertical Sidebar Navigation (Same style as AdminNavigation) -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200">
        <!-- Logo -->
        <div class="flex items-center h-16 px-6 border-b border-gray-200">
            <Link :href="route('admin.dashboard')" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">EF</span>
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-900">{{ t('ecos_flooring') }}</span>
                    <span class="block text-xs text-gray-500">{{ t('admin_panel') }}</span>
                </div>
            </Link>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 px-3">
            <div class="space-y-1">
                <a v-for="item in mainNavItems" :key="item.href" 
                   :href="item.href"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
                    <component :is="item.icon" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
                    {{ item.title }}
                </a>
            </div>
        </nav>

        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-gray-200">
            <div class="space-y-2">
                <a v-for="item in footerNavItems" :key="item.href"
                   :href="item.href"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
                    <component :is="item.icon" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
                    {{ item.title }}
                </a>
                
                <div class="relative group">
                    <button class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors group">
                        <Settings class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" />
                        <span class="truncate">{{ page.props.auth.user.name }}</span>
                        <ArrowLeft class="h-4 w-4 ml-auto rotate-90" />
                    </button>
                    <div class="absolute bottom-full left-0 right-0 mb-1 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <Link :href="route('profile.edit')"
                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-t-md">
                            {{ t('profile_settings') }}
                        </Link>
                        <Link :href="route('logout')" method="post" as="button"
                              class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 border-t rounded-b-md">
                            {{ t('sign_out') }}
                        </Link>
                    </div>
                </div>
                
                <!-- Language Selector -->
                <div class="mt-3 px-3">
                    <LanguageSelector />
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div v-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"></div>
    
    <!-- Mobile Sidebar -->
    <div v-show="mobileMenuOpen" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200 md:hidden">
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
            <Link :href="route('admin.dashboard')" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">EF</span>
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-900">{{ t('ecos_flooring') }}</span>
                    <span class="block text-xs text-gray-500">{{ t('admin_panel') }}</span>
                </div>
            </Link>
            <button @click="mobileMenuOpen = false" class="p-2 text-gray-700">
                <Settings class="h-6 w-6" />
            </button>
        </div>

        <nav class="mt-6 px-3">
            <div class="space-y-1">
                <a v-for="item in mainNavItems" :key="item.href" 
                   :href="item.href" @click="mobileMenuOpen = false"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">
                    <component :is="item.icon" class="h-5 w-5 mr-3" />
                    {{ item.title }}
                </a>
            </div>
        </nav>
    </div>

    <!-- Mobile Menu Button -->
    <button @click="mobileMenuOpen = !mobileMenuOpen" class="fixed top-4 left-4 z-40 p-2 bg-white rounded-md shadow-md md:hidden">
        <BookOpen v-if="!mobileMenuOpen" class="h-6 w-6 text-gray-700" />
        <Settings v-else class="h-6 w-6 text-gray-700" />
    </button>
</template>
