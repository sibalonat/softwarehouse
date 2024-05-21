<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { computed } from 'vue';
import DynamicHeroIcon from '../Partials/DynamicHeroIcon.vue';

const emit = defineEmits(['pagination-change-page']);

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
    limit: {
        type: Number,
        default: 0,
    },
    keepLength: {
        type: Boolean,
        default: false,
    },
    itemClasses: {
        type: Array,
        default: () => [
            'bg-white',
            'text-gray-500',
            'border-gray-300',
            'hover:bg-gray-50',
        ],
    },
    activeClasses: {
        type: Array,
        default: () => [
            'bg-blue-50',
            'border-blue-500',
            'text-blue-600',
        ],
    },
});

// computed
const isApiResource = computed(() => {
    return props.data.meta;
});

const currentPage = computed(() => {
    return isApiResource.value ? props.data.meta.current_page : props.data.current_page ?? null;
});

const lastPage = computed(() => {
    return isApiResource.value ? props.data.meta.last_page : props.data.last_page ?? null;
});

const nextPageUrl = computed(() => {
    return (
        props.data.next_page_url ??
        props.data.meta?.next_page_url ??
        props.data.links?.next ??
        null
    );
});

const perPage = computed(() => {
    return isApiResource.value ? props.data.meta.per_page : props.data.per_page ?? null;
});

const prevPageUrl = computed(() => {
    return (
        props.data.prev_page_url ??
        props.data.meta?.prev_page_url ??
        props.data.links?.prev ??
        null
    );
});


const total = computed(() => {
    return isApiResource.value ? props.data.meta.total : props.data.total ?? null;
});

const pageRange = computed(() => {

    if(props.limit === -1) {
        return 0;
    }

    if(props.limit === 0) {
        return lastPage.value;
    }

    var current = currentPage.value;
    var size = props.keepLength;
    var last = lastPage.value;
    var delta = props.limit;
    var left = current - delta;
    var right = current + delta;
    var leftPad = (delta + 2) * 2;
    var rightPad = (delta + 2) * 2 - 1;
    var range = [];
    var pages = [];
    var l;

    for (var i = 1; i <= last; i++) {
        // Item is first or last
        if (i === 1 || i === last) {
            range.push(i);
        }
        // Item is within the delta
        else if (i >= left && i <= right) {
            range.push(i);
        }
        // Item is before max left padding
        else if (size && i < leftPad && current < leftPad - 2) {
            range.push(i);
        }
        // Item is after max right padding
        else if (
            size &&
            i > last - rightPad &&
            current > last - rightPad + 2
        ) {
            range.push(i);
        }
    }

    range.forEach(function (i) {
        if (l) {
            if (i - l === 2) {
                pages.push(l + 1);
            } else if (i - l !== 1) {
                pages.push('...');
            }
        }
        pages.push(i);
        l = i;
    });

    return pages;
});

// methods

const selectPage = (page) => {
    if (page === '...' || page === currentPage.value) {
        return;
    }
    emit('pagination-change-page', page);
};


</script>

<template>
    <div class="grid grid-cols-2 mb-4 gap-x-4">
        <Link
            :href="prevPageUrl"
            class="relative inline-flex items-center w-40 px-2 py-2 text-sm font-medium border ms-auto rounded-l-md focus:z-20 disabled:opacity-50"
            :class="itemClasses"
            :disabled="!prevPageUrl"
        >
            <DynamicHeroIcon name="backward" :size="5" class="mx-auto " />
        </Link>

        <Link
            :href="nextPageUrl"
            class="relative inline-flex items-center w-40 px-2 py-2 text-sm font-medium border rounded-r-md focus:z-20 disabled:opacity-50"
            :class="itemClasses"
            :disabled="!nextPageUrl"
        >
            <DynamicHeroIcon name="forward" :size="5" class="mx-auto " />
        </Link>
    </div>

    <nav
    class="grid w-full grid-cols-12 rounded-md shadow-sm isolate"
    aria-label="Pagination"
    v-if="total > perPage">
            <button
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium border focus:z-20"
                :class="[
                    page == currentPage ? activeClasses : itemClasses,
                    page == currentPage ? 'z-30' : '',
                ]"
                :aria-current="currentPage ? 'page' : null"
                v-for="(page, key) in pageRange"
                :key="key"
                @click="selectPage(page)"
                :disabled="page === currentPage"
            >
                {{ page }}
            </button>
        </nav>
</template>

