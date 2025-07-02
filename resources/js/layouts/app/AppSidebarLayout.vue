<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <AppSidebar />
        <!-- Main Content Area (with left margin for sidebar) -->
        <div class="md:ml-64">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </div>
    </div>
</template>
