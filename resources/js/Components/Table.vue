<script setup>
    import Checkbox from '@/Components/Checkbox.vue';
    import { computed, ref } from 'vue';

    const version = '0.0.2';
    const collum = {
        keys: [],
        titles: [],
    };
    // all selected in checkbox items
    const selectedIds = ref([]);
    const inputSelectedAll = ref(null);
    const listsCheckBox = ref(null);

    const emits = defineEmits(['update:data']);

    const props = defineProps({
        checked: Boolean,
        id: {
            type: Boolean,
            default: true,
        },
        data: Array,
        headers: {
            type: [Array, Object],
            default: [],
        },
        delete: {
            type: Array,
            default: [],
        }
    });

    const proxyData = computed({
        get() {
            return props.data;
        },
        set(val) {
            emits('updata:data', val);
        },
    });

    function getKeys() {
        if (props.data.length >= 1) {
            return Object.keys(props.data[0]);
        }
    }

    function titleTableHeader() {
        collum.keys = getKeys();
        collum.titles = [...collum.keys];
    }

    function setTitle(index, value) {
        collum.titles[index] = value;
    }

    function changeTitleHeader(key, index) {
        let value = props.headers[key];
        if (value) {
            setTitle(index, value);
        }
    }

    function aliasTitle() {
        collum.titles.forEach((item, index) => {
            if (Array.isArray(props.headers)) {
                changeTitleHeader(index, index);
            } else {
                changeTitleHeader(collum.titles[index], index);
            }
        });
    }

    function deleteKeyAndTitle(item) {
        const index = collum.titles.indexOf(item);
        if (index !== -1) {
            collum.keys.splice(index, 1);
            collum.titles.splice(index, 1);
        }
    }

    function deleteItems() {
        props.delete.forEach((item)=> {
            deleteKeyAndTitle(item);
        });
    }

    titleTableHeader();
    aliasTitle();

    // removed unnecessary values
    if (!props.id) {
        deleteKeyAndTitle('id');
    }

    // destroy items
    deleteItems();

    function emptyCheckBox() {
        if (selectedIds.value.length === 0) {
            return true;
        }

        return false;
    }

    function listCheckBoxes(elem = [], item = false, value = true, single = false) {
        elem.forEach((box, index) => {
            if (box.firstChild.checked === item) {
                selectedIds.value.push(box.value);
                box.firstChild.checked = value;
            } else if (single) {
                selectedIds.value.splice(selectedIds.value.indexOf(elem.value), 1);
            } else {
                box.firstChild.checked = value;
                selectedIds.value = [];
            }
        });
    }

    function selectAll(elem) {
        if (elem.target.checked) {
            return listCheckBoxes(listsCheckBox.value);
        }

        listCheckBoxes(listsCheckBox.value, false, false);
    }

    function selectOne(elem) {
        if (elem.target.checked) {
            return listCheckBoxes([elem.target], true);
        }

        listCheckBoxes([elem.target], true, false, true);

        if (emptyCheckBox()) {
            inputSelectedAll.value.firstChild.checked = false;
        }
    }

    defineExpose({
        selectedIds,
    });
</script>

<template>
    <div class="my-shadow bg-white overflow-hidden sm:rounded-lg">
        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th v-if="checked" scope="col" class="p-4">
                                    <div class="flex items-center" ref="inputSelectedAll">
                                        <Checkbox @change="selectAll($event)" />
                                    </div>
                                </th>
                                <th v-for="value in collum.titles" :key="value" scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                    {{ value }}
                                </th>
                                <th scope="col" class="p-4">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <template v-for="(item, index) in proxyData" :key="item.id">
                                <tr :class="((index + 1) % 2) ? 'hover:bg-gray-100 dark:hover:bg-gray-700' : 'bg-gray-100 dark:bg-gray-700'">
                                    <td v-if="checked" class="p-4 w-4">
                                        <div class="flex items-center" ref="listsCheckBox">
                                            <Checkbox :value="item.id" @change="selectOne($event)" />
                                        </div>
                                    </td>
                                    <td v-for="name in collum.keys" :key="name + '_' + item.id" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                        <template v-if="name !== 'visible'">
                                            <span :name="name">{{ item[name] }}</span>
                                        </template>
                                        <template v-else>
                                            <slot name="visible" :visible="item">
                                                <Checkbox v-model:checked="item.visible" class="cursor-pointer" />
                                            </slot>
                                        </template>
                                    </td>
                                    <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                        <slot name="action" :item="item">
                                        </slot>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .action-btn svg {
        display: inline-block;
        width: 20px;
        height: 20px;
    }
    .btn-delete {
        color: red;
    }
    .my-shadow {
        border: 1px solid #e5e7eb;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>
