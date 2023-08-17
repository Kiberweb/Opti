<script setup>
    import Select from '@/Components/Select.vue';
    import {useForm} from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        meta:Object,
        links: Object,
        lists: {
            type: Array,
            default: [3, 5, 10, 17, 20, 25, 30, 40, 70],
        },
    });

    const selected = ref(props.meta.per_page);

    const linksLength = props.meta.links.length - 1;

    const prev = props.meta.links[0];
    const next = props.meta.links[linksLength];
    const notUse = [0, linksLength];

    function setOnPage() {
        selected.value = props.meta.per_page;
        props.meta.links.forEach(( elem,index) => {
            elem.url += '&limit=' + selected.value;
        });
    }

    function onPage() {
        let url = new URL(location.href);
        url.searchParams.delete('page');
        url.searchParams.set('per-page', selected.value);

        location.href = url;
    }
</script>

<template>
    <div>
        <nav class="flex justify-between items-center px-6 py-6" aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400 flex items-center	">
            Showing
            <span class="font-semibold text-gray-900 dark:text-white mx-3">
                {{ meta.current_page }} - {{ meta.last_page }}
            </span>
            of
            <span class="font-semibold text-gray-900 dark:text-white mx-3">{{ meta.total }}</span>

            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <Select
                    v-model:selected="selected"
                    :options="lists"
                    @change="onPage"
                    my-classes="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
            </span>
        </span>

            <ul class="inline-flex items-center -space-x-px">
                <!-- First btn -->
                <li>
                    <a :href="links.first + '&limit=' + selected" class="cursor-pointer block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span>First</span>
                    </a>
                </li>
                <!-- Prev btn -->
                <li v-if="prev.url">
                    <a :href="prev.url" class="cursor-pointer block py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">{{ prev.label }}</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                </li>

                <li v-for="(link, index) in meta.links" :key="link.label">
                    <template v-if="!notUse.includes(index)">
                        <template v-if="link.active">
                            <span aria-current="page" class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white font-bold">{{ link.label }}</span>
                        </template>
                        <template v-else>
                            <a :href="link.url" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ link.label }}</a>
                        </template>
                    </template>
                </li>

                <!-- Next btn -->
                <li v-if="next.url">
                    <a :href="next.url" class="cursor-pointer block py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">{{ next.label }}</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                </li>
                <!-- Last btn -->
                <li>
                    <a :href="links.last + '&limit=' + selected" class="cursor-pointer block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span>Last</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style></style>
